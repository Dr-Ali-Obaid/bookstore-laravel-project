@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div id="success" style="display: none" class="col-md-8 text-center h3 p-4 bg-success text-light-rounded">تمت
                عمليةالشراء بنجاح</div>
            @if (session('message'))
                <div class="col-md-8 text-center h3 p-4 bg-success text-light rounded">تمت عملية الشراء بنجاح </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">عربة التسوق</div>
                    <div class="card-body">
                        @if ($items->count())
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">العنوان</th>
                                        <th scope="col">السعر</th>
                                        <th scope="col">الكمية</th>
                                        <th scope="col">السعر الكلي</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                @php($totalPrice = 0)
                                @foreach ($items as $item)
                                    @php($totalPrice += $item->price * $item->pivot->number_of_copies)
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ $item->title }}</th>
                                            <td>{{ $item->price }} $</td>
                                            <td>{{ $item->pivot->number_of_copies }}</td>
                                            <td>{{ $item->price * $item->pivot->number_of_copies }} $</td>
                                            <td>
                                                <form style="float: left; margin: auto 5px" method="POST"
                                                    action="{{ route('cart.remove_all', $item->id) }}">
                                                    @csrf
                                                    <button class="btn btn-outline-danger btn-sm" type="submit">أزل
                                                        الكل</button>
                                                </form>
                                                <form style="float: left; margin: auto 5px" method="POST"
                                                    action="{{ route('cart.remove_one', $item->id) }}">
                                                    @csrf
                                                    <button class="btn btn-outline-warning btn-sm" type="submit">أزل
                                                        واحدا</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach

                            </table>
                            <h4 class="mb-4">المجموع النهائي: {{ $totalPrice }} $</h4>
                            <div id="paypal-button-container" class="d-inline-block"></div>
                            <a href="{{ route('credit.checkout') }}" class="d-inline-block mb float-start btn bg-cart"
                                style="text-decoration:none">
                                <span>بطاقة ائتمانية</span>
                                <i class="fa-solid fa-credit-card"></i>
                            </a>
                        @else
                            <div class="alert alert-info text-center">لا توجد كتب بالعربة</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- Replace "test" with your own sandbox Business account app client ID -->
    <script
        src="https://www.paypal.com/sdk/js?client-id=AadKK-Aa3KYi4DtXndvZkv1IvlTaFnvJst7e99aG1HJO6L4vkx6Am17vnl6L8KGEO_1tUTIR3Yb0qpIa&currency=USD">
    </script>
    <script>
        paypal.Buttons({
            // Sets up the transaction when a payment button is clicked
            createOrder: (data, actions) => {
                return fetch('/api/paypal/create-payment', {
                    method: 'POST',
                    body: JSON.stringify({
                        'userId': "{{ auth()->user()->id }}",
                    })
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    return orderData.id;
                });
            },
            // Finalize the transaction after payer approval
            onApprove: (data, actions) => {
                return fetch('/api/paypal/execute-payment', {
                    method: 'POST',
                    body: JSON.stringify({
                        orderId: data.orderID,
                        userId: "{{ auth()->user()->id }}",
                    })
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    $('#success').slideDown(200);
                    $('.card-body').slideUp(0);
                });
            }
        }).render('#paypal-button-container');
    </script>
@endsection
