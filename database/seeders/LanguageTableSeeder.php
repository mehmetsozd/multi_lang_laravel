<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lang = Config::get('app.locale');
        \App\Models\Language::create([
            'name' => strtoupper($lang),
            'code'=>$lang,
            'is_default'=>'1'
        ]);

    }
}
