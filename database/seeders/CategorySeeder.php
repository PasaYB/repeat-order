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
        $categories = [
            [
                'name' => 'Makanan Tradisional',
                'slug' => 'makanan-tradisional',
                'description' => 'Aneka makanan khas Nusantara.',
            ],
            [
                'name' => 'Ayam dan Bebek',
                'slug' => 'ayam-dan-bebek',
                'description' => 'Menu ayam dan bebek dengan berbagai olahan.',
            ],
            [
                'name' => 'Bakso dan Mi',
                'slug' => 'bakso-dan-mi',
                'description' => 'Bakso, mi ayam, dan hidangan mi lainnya.',
            ],
            [
                'name' => 'Kopi dan Kafe',
                'slug' => 'kopi-dan-kafe',
                'description' => 'Kafe untuk menikmati kopi dan bersantai.',
            ],
            [
                'name' => 'Roti dan Dessert',
                'slug' => 'roti-dan-dessert',
                'description' => 'Roti, kue, dan hidangan penutup.',
            ],
            [
                'name' => 'Minuman',
                'slug' => 'minuman',
                'description' => 'Aneka minuman dingin dan menyegarkan.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
