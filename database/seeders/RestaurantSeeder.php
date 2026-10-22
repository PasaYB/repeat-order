<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = [
            [
                'category' => 'makanan-tradisional',
                'name' => 'Warung Nusantara',
                'slug' => 'warung-nusantara',
                'description' => 'Aneka masakan rumahan khas Indonesia.',
                'address' => 'Sekitar kawasan Malioboro, Yogyakarta',
                'latitude' => -7.7926,
                'longitude' => 110.3657,
                'phone' => '081234567801',
                'opening_time' => '08:00:00',
                'closing_time' => '21:00:00',
                'image' => null,
                'is_open' => true,
            ],
            [
                'category' => 'ayam-dan-bebek',
                'name' => 'Ayam Bakar Senja',
                'slug' => 'ayam-bakar-senja',
                'description' => 'Ayam bakar dengan sambal dan nasi hangat.',
                'address' => 'Sekitar kawasan Gejayan, Yogyakarta',
                'latitude' => -7.7655,
                'longitude' => 110.3890,
                'phone' => '081234567802',
                'opening_time' => '10:00:00',
                'closing_time' => '22:00:00',
                'image' => null,
                'is_open' => true,
            ],
            [
                'category' => 'bakso-dan-mi',
                'name' => 'Bakso Mie Pak Rasa',
                'slug' => 'bakso-mie-pak-rasa',
                'description' => 'Bakso kuah dan mi ayam untuk makan siang.',
                'address' => 'Sekitar kawasan Bulaksumur, Yogyakarta',
                'latitude' => -7.7700,
                'longitude' => 110.3770,
                'phone' => '081234567803',
                'opening_time' => '09:00:00',
                'closing_time' => '20:00:00',
                'image' => null,
                'is_open' => true,
            ],
            [
                'category' => 'kopi-dan-kafe',
                'name' => 'Ruang Kopi',
                'slug' => 'ruang-kopi',
                'description' => 'Kafe sederhana untuk menikmati kopi dan bersantai.',
                'address' => 'Sekitar kawasan Seturan, Sleman',
                'latitude' => -7.7750,
                'longitude' => 110.4140,
                'phone' => '081234567804',
                'opening_time' => '08:00:00',
                'closing_time' => '23:00:00',
                'image' => null,
                'is_open' => true,
            ],
            [
                'category' => 'roti-dan-dessert',
                'name' => 'Manis Bakery',
                'slug' => 'manis-bakery',
                'description' => 'Roti, kue, dan dessert untuk menemani waktu santai.',
                'address' => 'Sekitar kawasan Condongcatur, Sleman',
                'latitude' => -7.7580,
                'longitude' => 110.4020,
                'phone' => '081234567805',
                'opening_time' => '07:00:00',
                'closing_time' => '20:00:00',
                'image' => null,
                'is_open' => true,
            ],
            [
                'category' => 'minuman',
                'name' => 'Segar Sore',
                'slug' => 'segar-sore',
                'description' => 'Aneka minuman dingin dan minuman buah.',
                'address' => 'Sekitar kawasan Wirobrajan, Yogyakarta',
                'latitude' => -7.8010,
                'longitude' => 110.3520,
                'phone' => '081234567806',
                'opening_time' => '10:00:00',
                'closing_time' => '21:00:00',
                'image' => null,
                'is_open' => true,
            ],
        ];

        foreach ($restaurants as $restaurant) {
            $category = Category::where(
                'slug',
                $restaurant['category']
            )->firstOrFail();

            unset($restaurant['category']);

            Restaurant::updateOrCreate(
                ['slug' => $restaurant['slug']],
                [
                    ...$restaurant,
                    'category_id' => $category->id,
                ]
            );
        }
    }
}
