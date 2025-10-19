<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Company::create([
        'name' => 'ACME Corporation',
        'code' => 'ACME',
        'primary_color' => '#3490dc',
        'accent_color' => '#6cb2eb',
    ]);

    \App\Models\Company::create([
        'name' => 'BETA Industries',
        'code' => 'BETA',
        'primary_color' => '#e3342f',
        'accent_color' => '#f66d6a',
    ]);

    \App\Models\Company::create([
        'name' => 'GAMMA Solutions',
        'code' => 'GAMMA',
        'primary_color' => '#38c172',
        'accent_color' => '#6bd99c',
    ]);
}
}
