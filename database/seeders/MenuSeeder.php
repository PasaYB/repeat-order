<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            'warung-nusantara' => [
                [
                    'name' => 'Nasi Gudeg Komplit',
                    'slug' => 'nasi-gudeg-komplit',
                    'description' => 'Nasi gudeg dengan krecek, telur, dan ayam.',
                    'price' => 25000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Nasi Ayam Opor',
                    'slug' => 'nasi-ayam-opor',
                    'description' => 'Nasi putih dengan ayam opor dan kuah santan.',
                    'price' => 22000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Soto Ayam',
                    'slug' => 'soto-ayam',
                    'description' => 'Soto ayam hangat dengan nasi dan pelengkap.',
                    'price' => 18000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Es Teh Manis',
                    'slug' => 'es-teh-manis',
                    'description' => 'Teh manis dingin untuk menemani makan.',
                    'price' => 5000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'ayam-bakar-senja' => [
                [
                    'name' => 'Ayam Bakar Madu',
                    'slug' => 'ayam-bakar-madu',
                    'description' => 'Ayam bakar dengan olesan bumbu madu.',
                    'price' => 24000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Ayam Goreng Kremes',
                    'slug' => 'ayam-goreng-kremes',
                    'description' => 'Ayam goreng gurih dengan kremesan renyah.',
                    'price' => 22000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Paket Ayam Bakar',
                    'slug' => 'paket-ayam-bakar',
                    'description' => 'Ayam bakar, nasi putih, sambal, dan lalapan.',
                    'price' => 30000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Sambal Terasi',
                    'slug' => 'sambal-terasi',
                    'description' => 'Sambal terasi sebagai tambahan lauk.',
                    'price' => 4000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'bakso-mie-pak-rasa' => [
                [
                    'name' => 'Bakso Urat',
                    'slug' => 'bakso-urat',
                    'description' => 'Bakso urat dengan kuah kaldu dan sayuran.',
                    'price' => 18000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Bakso Komplit',
                    'slug' => 'bakso-komplit',
                    'description' => 'Bakso dengan mi, tahu, dan pangsit.',
                    'price' => 22000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Mi Ayam',
                    'slug' => 'mi-ayam',
                    'description' => 'Mi dengan ayam berbumbu dan sayuran.',
                    'price' => 15000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Mi Ayam Bakso',
                    'slug' => 'mi-ayam-bakso',
                    'description' => 'Mi ayam dengan tambahan bakso.',
                    'price' => 20000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'ruang-kopi' => [
                [
                    'name' => 'Es Kopi Susu',
                    'slug' => 'es-kopi-susu',
                    'description' => 'Kopi espresso dengan susu dan gula aren.',
                    'price' => 18000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Americano',
                    'slug' => 'americano',
                    'description' => 'Espresso dengan tambahan air.',
                    'price' => 15000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Cafe Latte',
                    'slug' => 'cafe-latte',
                    'description' => 'Espresso dengan susu steamed.',
                    'price' => 22000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Cokelat Dingin',
                    'slug' => 'cokelat-dingin',
                    'description' => 'Minuman cokelat dengan susu dan es.',
                    'price' => 18000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'manis-bakery' => [
                [
                    'name' => 'Croissant Butter',
                    'slug' => 'croissant-butter',
                    'description' => 'Pastry berlapis dengan aroma mentega.',
                    'price' => 16000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Roti Cokelat',
                    'slug' => 'roti-cokelat',
                    'description' => 'Roti lembut dengan isian cokelat.',
                    'price' => 12000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Cheesecake',
                    'slug' => 'cheesecake',
                    'description' => 'Kue keju lembut dengan tekstur creamy.',
                    'price' => 25000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Donat Gula',
                    'slug' => 'donat-gula',
                    'description' => 'Donat lembut dengan taburan gula.',
                    'price' => 8000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'segar-sore' => [
                [
                    'name' => 'Es Teh Lemon',
                    'slug' => 'es-teh-lemon',
                    'description' => 'Teh dingin dengan perasan lemon.',
                    'price' => 10000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Jus Alpukat',
                    'slug' => 'jus-alpukat',
                    'description' => 'Jus alpukat segar yang dibuat saat dipesan.',
                    'price' => 16000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Jus Mangga',
                    'slug' => 'jus-mangga',
                    'description' => 'Jus mangga dengan rasa manis dan segar.',
                    'price' => 15000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Susu Cokelat',
                    'slug' => 'susu-cokelat',
                    'description' => 'Susu dengan campuran cokelat.',
                    'price' => 12000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],
        ];

        foreach ($menus as $restaurantSlug => $restaurantMenus) {
            $restaurant = Restaurant::where('slug', $restaurantSlug)
                ->firstOrFail();

            foreach ($restaurantMenus as $menu) {
                Menu::updateOrCreate(
                    [
                        'restaurant_id' => $restaurant->id,
                        'slug' => $menu['slug'],
                    ],
                    [
                        ...$menu,
                        'restaurant_id' => $restaurant->id,
                    ]
                );
            }
        }
    }
}
