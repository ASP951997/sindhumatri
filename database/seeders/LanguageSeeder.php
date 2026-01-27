<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Language::create([
            'name' => 'English',
            'short_name' => 'US',
            'is_active' => 1,
            'rtl' => 0,
        ]);
    }
}
