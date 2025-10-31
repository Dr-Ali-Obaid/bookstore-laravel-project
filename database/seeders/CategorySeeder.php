<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(["name" => "ريادة الأعمال"]);
        Category::create(["name" => "البرمجة"]);
        Category::create(["name" => "المبيعات والتسويق"]);
        Category::create(["name" => "العمل الحر"]);
        Category::create(["name" => "التصميم"]);
    }
}
