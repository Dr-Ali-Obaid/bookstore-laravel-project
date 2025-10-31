<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $book1 = Book::create([
            "category_id" => Category::where("name", "ريادة الأعمال")->first()->id,
            "publisher_id" => Publisher::where("name", "الناشر العربي")->first()->id,
            "title" => "التوظيف عن بعد",
            "description" => "يستعرض هذا الكتاب التحول الجذري في سوق العمل نحو التوظيف عن بُعد، ويقدم دليلًا عمليًا لأصحاب الأعمال والموظفين على حد سواء لفهم هذا النمط الجديد من العمل. يتناول الكتاب مزايا التوظيف عن بُعد، والتحديات التي تواجه الشركات في توظيف وإدارة فرق العمل عن بُعد، ويقدم استراتيجيات فعّالة لبناء فرق منتجة عبر الإنترنت. كما يناقش أدوات الاتصال، وثقافة العمل، وإدارة الأداء، وكيفية جذب أفضل الكفاءات من أي مكان في العالم",
            "number_of_copies" => "200",
            "number_of_pages" => "180",
            "price" => "20",
            "isbn" => "192000000",
            "publish_year" => "2024",
            "cover_image" => "images/covers/1.png"
        ]);
        $book1->authors()->attach(Author::where("name", "محمد صلاح")->first());

         $book2 = Book::create([
            "category_id" => Category::where("name", "البرمجة")->first()->id,
            "publisher_id" => Publisher::where("name", "الناشر العربي")->first()->id,
            "title" => "مدخل إلى تجربة المستخدم",
            "description" => "يوفر هذا الكتاب مقدمة شاملة لمجال تجربة المستخدم، موضحًا أهميته في تصميم المنتجات الرقمية والتقنية الحديثة. يشرح المفاهيم الأساسية مثل قابلية الاستخدام، والبحث مع المستخدمين، وتصميم الواجهات، وتخطيط الرحلة التي يمر بها المستخدم (User Journey). كما يُبرز العلاقة بين التصميم والتفاعل البشري، ويقدم أمثلة وأدوات تساعد المصممين والمطورين على بناء تجارب سلسة وفعّالة ومحببة. الكتاب مثالي للمبتدئين والمهتمين بدخول هذا المجال المتنامي",
            "number_of_copies" => "300",
            "number_of_pages" => "150",
            "price" => "18",
            "isbn" => "156000000",
            "publish_year" => "2023",
            "cover_image" => "images/covers/2.png"
        ]);
        $book2->authors()->attach(Author::where("name", "صالح سليم")->first());

         $book3 = Book::create([
            "category_id" => Category::where("name", "المبيعات والتسويق")->first()->id,
            "publisher_id" => Publisher::where("name", "الناشر العربي")->first()->id,
            "title" => "دليلك المختصر لبيع المنتجات الرقمية",
            "description" => "هذا الكتاب هو مرشد عملي ومباشر لكل من يرغب في دخول عالم بيع المنتجات الرقمية مثل الكتب الإلكترونية، والدورات، والتصاميم، والقوالب البرمجية. يبدأ من اختيار الفكرة المناسبة، ثم تطوير المنتج الرقمي، وتحديد الجمهور المستهدف، وصولًا إلى بناء منصة البيع والتسويق الفعّال عبر القنوات الرقمية. يقدّم الكتاب نصائح مجربة وأدوات ضرورية تساعدك على بدء مشروعك الرقمي بخطوات واضحة وبدون تعقيد، حتى لو لم تكن خبيرًا في التسويق أو البرمجة.",
            "number_of_copies" => "240",
            "number_of_pages" => "190",
            "price" => "22",
            "isbn" => "158800000",
            "publish_year" => "2025",
            "cover_image" => "images/covers/3.png"
        ]);
        $book3->authors()->attach(Author::where("name", "يونس علي")->first());

         $book4 = Book::create([
            "category_id" => Category::where("name", "العمل الحر")->first()->id,
            "publisher_id" => Publisher::where("name", "مؤسسة صخر")->first()->id,
            "title" => "دليلك المختصر لبدء العمل عبر الإنترنت",
            "description" => "يوفر هذا الكتاب مقدمة عملية وواضحة لأي شخص يرغب في دخول عالم العمل الحر أو المشاريع الرقمية عبر الإنترنت. يبدأ بتحديد المهارات المناسبة للعمل عن بُعد، ثم يستعرض مجالات العمل الرقمية الشائعة مثل الترجمة، التصميم، البرمجة، التسويق، وبيع المنتجات الرقمية. كما يشرح كيفية إنشاء حضور احترافي، واستخدام المنصات المناسبة للحصول على فرص عمل أو إطلاق مشروع شخصي. الكتاب مثالي للمبتدئين الذين يبحثون عن مصدر دخل إضافي أو يسعون للتحول المهني نحو العمل الرقم",
            "number_of_copies" => "320",
            "number_of_pages" => "240",
            "price" => "25",
            "isbn" => "123000000",
            "publish_year" => "2024",
            "cover_image" => "images/covers/4.png"
        ]);
        $book4->authors()->attach(Author::where("name", "زياد سالم")->first());

         $book5 = Book::create([
            "category_id" => Category::where("name", "التصميم")->first()->id,
            "publisher_id" => Publisher::where("name", "مؤسسة صخر")->first()->id,
            "title" => "الدليل المختصر لصفحات الهبوط",
            "description" => "يرشدك هذا الكتاب إلى أساسيات تصميم صفحات الهبوط (Landing Pages) التي تُستخدم لجذب العملاء وتحقيق أهداف محددة مثل جمع بيانات الزوار أو زيادة المبيعات. يشرح الكتاب عناصر الصفحة الفعّالة، مثل العناوين الجذابة، الدعوات إلى الإجراء (CTA)، وترتيب المحتوى بصريًا ونفسيًا لإقناع الزائر. كما يقدّم نماذج ناجحة، وأدوات مساعدة، ونصائح لتحسين الأداء عبر اختبارات A/B وتحليل البيانات. الكتاب مناسب للمصممين، والمسوقين، وأصحاب المشاريع الذين يريدون تحويل الزوار إلى عملاء.",
            "number_of_copies" => "170",
            "number_of_pages" => "160",
            "price" => "20",
            "isbn" => "103400000",
            "publish_year" => "2023",
            "cover_image" => "images/covers/5.png"
        ]);
        $book5->authors()->attach(Author::where("name", "سلمى منصور")->first());

         $book6 = Book::create([
            "category_id" => Category::where("name", "المبيعات والتسويق")->first()->id,
            "publisher_id" => Publisher::where("name", "مؤسسة صخر")->first()->id,
            "title" => "دليلك المختصر للعمل كمسوق بالعمولة",
            "description" => "يوضح هذا الكتاب المفاهيم الأساسية للعمل في مجال التسويق بالعمولة (Affiliate Marketing)، ويأخذ بيد المبتدئين خطوة بخطوة من اختيار المجال المناسب، إلى الانضمام للبرامج التسويقية الموثوقة، وبناء منصات الترويج كالمواقع والمدونات والحسابات الاجتماعية. كما يشرح طرق جلب الزوار، وكتابة المحتوى التسويقي، وتحليل النتائج لزيادة الأرباح. يتضمن الكتاب أدوات مساعدة ونصائح مجربة للنجاح دون الحاجة إلى رأس مال كبير أو خبرة تقنية متقدمة.",
            "number_of_copies" => "270",
            "number_of_pages" => "150",
            "price" => "17",
            "isbn" => "112340000",
            "publish_year" => "2025",
            "cover_image" => "images/covers/6.png"
        ]);
        $book6->authors()->attach(Author::where("name", "سما صبحي")->first());
    }
}
