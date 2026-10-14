<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Seeder;

class DummyQuizSeeder extends Seeder
{
    /**
     * ITクイズと紹介クイズ以外のダミーを100件登録する。
     */
    public function run(): void
    {
        Quiz::factory()->count(100)->create();
    }
}
