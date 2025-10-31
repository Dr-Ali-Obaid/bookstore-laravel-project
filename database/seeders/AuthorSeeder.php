<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create(["name" => "محمد صلاح"]);
        Author::create(["name" => "صالح سليم"]);
        Author::create(["name" => "يونس علي"]);
        Author::create(["name" => "زياد سالم"]);
        Author::create(["name" => "سلمى منصور"]);
        Author::create(["name" => "سما صبحي"]);

    }
}
