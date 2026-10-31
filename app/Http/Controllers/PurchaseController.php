<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Mail\OrderMail;
use App\Models\Book;
use App\Models\Shopping;
use Illuminate\Support\Facades\Mail;

class PurchaseController extends Controller
{
    private $provider;

    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    private function initPayPal()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
        $token = $this->provider->getAccessToken();
        $this->provider->setAccessToken($token);
    }

    public function sendOrderConfirmationMail($order, $user)
    {
        Mail::to($user)->send(new OrderMail($order, $user));
    }

    public function createPayment(Request $request)
    {
        $this->initPayPal();

        $data = json_decode($request->getContent(), true);
        $books = User::find($data['userId'])->booksInCart;
        $total = 0;
        foreach ($books as $book) {
            $total += $book->price * $book->pivot->number_of_copies;
        }
        $order = $this->provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $total
                    ],
                    'description' => 'Order Description'
                ]
            ]
        ]);
        return response()->json($order);
    }

    public function executePayment(Request $request)
    {
        $this->initPayPal();

        $data = json_decode($request->getContent(), true);
        $result = $this->provider->capturePaymentOrder($data['orderId']);
        if ($result['status'] === 'COMPLETED') {
            $user = User::find($data['userId']);
            $books = $user->booksInCart;
            $this->sendOrderConfirmationMail($books, auth()->user());

            foreach ($books as $book) {
                $bookPrice = $book->price;
                $purchaseTime = Carbon::now();
                $user->booksInCart()->updateExistingPivot($book->id, ['bought' => true, 'price' => $bookPrice, 'created_at' => $purchaseTime]);
                $book->save();
            }
        }
        return response()->json($result);
    }

    public function creditCheckout(Request $request)
    {
        $intent = auth()->user()->createSetupIntent();
        $userId = auth()->user()->id;
        $books = User::find($userId)->booksInCart;
        $total = 0;

        foreach ($books as $book) {
            $total += $book->price * $book->pivot->number_of_copies;
        }
        return view('credit.checkout', compact('total', 'intent'));
    }

    public function purchase(Request $request)
    {
        $user = $request->user();
        $paymentMethod = $request->input('payment_method');

        $books = $user->booksInCart;
        $total = 0;
        foreach ($books as $book) {
            $total += $book->price * $book->pivot->number_of_copies;
        }

        if ($total <= 0) {
            return back()->with('error', 'السلة فارغة');
        }

        try {
            $user->createOrGetStripeCustomer();

            $user->updateDefaultPaymentMethod($paymentMethod);

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $total * 100,
                'currency' => 'usd',
                'customer' => $user->stripe_id,
                'payment_method' => $paymentMethod,
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);

            if ($paymentIntent->status === 'succeeded') {
                foreach ($books as $book) {
                    $user->booksInCart()->updateExistingPivot($book->id, [
                        'bought' => true,
                        'price' => $book->price,
                        'created_at' => now(),
                    ]);
                }
                $this->sendOrderConfirmationMail($books, auth()->user());
                return redirect('/cart')->with('message', 'تم شراء المنتج بنجاح');
            } else {
                return back()->with('error', 'لم يتم تأكيد الدفع. الحالة: ' . $paymentIntent->status);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء الدفع: ' . $e->getMessage());
        }
    }

    public function myProduct()
    {
        $myBooks = auth()->user()->userPurchasedBooks;
        return view('books.myProduct', compact('myBooks'));
    }

    public function allProducts()
    {
        $allBooks = Shopping::with(['user', 'book'])->where('bought', true)->get();
        return view('admin.books.allProducts', compact('allBooks'));
    }
}
