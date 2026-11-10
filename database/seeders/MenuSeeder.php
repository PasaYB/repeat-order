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

            'pawon-sunda' => [
                [
                    'name' => 'Nasi Liwet Sunda',
                    'slug' => 'nasi-liwet-sunda',
                    'description' => 'Nasi liwet gurih dengan ikan asin, lalapan, dan sambal.',
                    'price' => 22000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Ayam Goreng Lengkuas',
                    'slug' => 'ayam-goreng-lengkuas',
                    'description' => 'Ayam goreng berbumbu rempah dengan taburan lengkuas.',
                    'price' => 24000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Karedok',
                    'slug' => 'karedok',
                    'description' => 'Sayuran mentah segar dengan siraman bumbu kacang khas Sunda.',
                    'price' => 15000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Sambal Dadak',
                    'slug' => 'sambal-dadak',
                    'description' => 'Sambal segar yang dibuat langsung dari cabai dan tomat pilihan.',
                    'price' => 5000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'saung-parahyangan' => [
                [
                    'name' => 'Nasi Timbel Komplit',
                    'slug' => 'nasi-timbel-komplit',
                    'description' => 'Nasi timbel dibungkus daun pisang dengan ayam goreng dan lalapan.',
                    'price' => 28000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Ikan Gurame Bakar',
                    'slug' => 'ikan-gurame-bakar',
                    'description' => 'Ikan gurame bakar dengan bumbu kecap dan sambal khas Sunda.',
                    'price' => 35000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Sayur Asem',
                    'slug' => 'sayur-asem',
                    'description' => 'Sayur berkuah asam segar dengan jagung, kacang panjang, dan melinjo.',
                    'price' => 12000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Empal Gepuk',
                    'slug' => 'empal-gepuk',
                    'description' => 'Daging sapi empuk dengan bumbu manis gurih khas Sunda.',
                    'price' => 27000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'dapur-nyi-iteung' => [
                [
                    'name' => 'Pepes Ikan',
                    'slug' => 'pepes-ikan',
                    'description' => 'Ikan berbumbu rempah yang dibungkus daun pisang dan dikukus.',
                    'price' => 22000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Nasi Tutug Oncom',
                    'slug' => 'nasi-tutug-oncom',
                    'description' => 'Nasi hangat yang dicampur oncom berbumbu khas Sunda.',
                    'price' => 20000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Tahu Sumedang',
                    'slug' => 'tahu-sumedang',
                    'description' => 'Tahu goreng khas Sumedang dengan bagian luar renyah.',
                    'price' => 10000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Lotek Sunda',
                    'slug' => 'lotek-sunda',
                    'description' => 'Aneka sayuran rebus dengan bumbu kacang yang gurih.',
                    'price' => 15000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'lesehan-mbah-marto' => [
                [
                    'name' => 'Mangut Lele',
                    'slug' => 'mangut-lele',
                    'description' => 'Lele asap dengan kuah santan pedas dan bumbu rempah Jawa.',
                    'price' => 22000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Oseng Mercon',
                    'slug' => 'oseng-mercon',
                    'description' => 'Potongan daging sapi dengan tumisan cabai rawit pedas.',
                    'price' => 25000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Gudeg Komplit',
                    'slug' => 'gudeg-komplit',
                    'description' => 'Gudeg nangka manis dengan krecek, telur, dan ayam.',
                    'price' => 28000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Tempe Mendoan',
                    'slug' => 'tempe-mendoan',
                    'description' => 'Tempe tipis berbalut tepung berbumbu yang digoreng setengah kering.',
                    'price' => 10000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'sego-berkah' => [
                [
                    'name' => 'Nasi Rames Ayam',
                    'slug' => 'nasi-rames-ayam',
                    'description' => 'Nasi putih dengan ayam, sayuran, sambal, dan lauk pilihan.',
                    'price' => 18000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Nasi Sayur Lodeh',
                    'slug' => 'nasi-sayur-lodeh',
                    'description' => 'Nasi hangat dengan sayur lodeh santan khas rumahan Jawa.',
                    'price' => 15000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Nasi Telur Balado',
                    'slug' => 'nasi-telur-balado',
                    'description' => 'Nasi putih dengan telur rebus berselimut sambal balado.',
                    'price' => 14000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Perkedel Kentang',
                    'slug' => 'perkedel-kentang',
                    'description' => 'Perkedel kentang lembut dengan bumbu bawang dan rempah.',
                    'price' => 5000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'pecel-mbok-darmi' => [
                [
                    'name' => 'Nasi Pecel Komplit',
                    'slug' => 'nasi-pecel-komplit',
                    'description' => 'Nasi dengan sayuran rebus, sambal kacang, peyek, dan tempe.',
                    'price' => 16000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Pecel Telur',
                    'slug' => 'pecel-telur',
                    'description' => 'Pecel sayuran dengan tambahan telur rebus.',
                    'price' => 18000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Nasi Tumpang',
                    'slug' => 'nasi-tumpang',
                    'description' => 'Nasi dengan sayuran dan sambal tumpang berbahan tempe semangit.',
                    'price' => 17000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Peyek Kacang',
                    'slug' => 'peyek-kacang',
                    'description' => 'Keripik tipis berbahan tepung beras dengan taburan kacang.',
                    'price' => 5000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'waroeng-mangut-asap' => [
                [
                    'name' => 'Mangut Ikan Pari',
                    'slug' => 'mangut-ikan-pari',
                    'description' => 'Ikan pari asap dengan kuah santan pedas khas pesisir.',
                    'price' => 28000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Mangut Lele Asap',
                    'slug' => 'mangut-lele-asap',
                    'description' => 'Lele asap dengan kuah santan gurih dan cabai pilihan.',
                    'price' => 23000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Nasi Megono',
                    'slug' => 'nasi-megono',
                    'description' => 'Nasi dengan cacahan nangka muda berbumbu kelapa khas Jawa.',
                    'price' => 16000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Tumis Daun Pepaya',
                    'slug' => 'tumis-daun-pepaya',
                    'description' => 'Daun pepaya tumis dengan bawang dan cabai.',
                    'price' => 10000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'bebek-goreng-cakrawala' => [
                [
                    'name' => 'Bebek Goreng Sambal Korek',
                    'slug' => 'bebek-goreng-sambal-korek',
                    'description' => 'Bebek goreng empuk dengan sambal korek pedas.',
                    'price' => 30000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Bebek Bakar Madu',
                    'slug' => 'bebek-bakar-madu',
                    'description' => 'Bebek bakar dengan olesan madu dan bumbu rempah.',
                    'price' => 32000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Paket Bebek Kremes',
                    'slug' => 'paket-bebek-kremes',
                    'description' => 'Bebek goreng dengan kremesan, nasi, dan lalapan.',
                    'price' => 34000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Sambal Pencit',
                    'slug' => 'sambal-pencit',
                    'description' => 'Sambal mangga muda dengan rasa pedas dan asam segar.',
                    'price' => 7000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'ayam-bakar-tepi-sawah' => [
                [
                    'name' => 'Ayam Bakar Kecap',
                    'slug' => 'ayam-bakar-kecap',
                    'description' => 'Ayam bakar dengan bumbu kecap manis dan rempah Jawa.',
                    'price' => 23000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Ayam Goreng Kalasan',
                    'slug' => 'ayam-goreng-kalasan',
                    'description' => 'Ayam goreng berbumbu santan dengan cita rasa manis gurih.',
                    'price' => 24000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Paket Ayam Penyet',
                    'slug' => 'paket-ayam-penyet',
                    'description' => 'Ayam goreng yang dipenyet bersama sambal bawang.',
                    'price' => 22000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Tahu Tempe Goreng',
                    'slug' => 'tahu-tempe-goreng',
                    'description' => 'Tahu dan tempe goreng berbumbu bawang dan ketumbar.',
                    'price' => 8000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'mie-kocok-mang-ujang' => [
                [
                    'name' => 'Mie Kocok Bandung',
                    'slug' => 'mie-kocok-bandung',
                    'description' => 'Mie kuning dengan kikil, tauge, dan kuah kaldu sapi.',
                    'price' => 22000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Mie Kocok Bakso',
                    'slug' => 'mie-kocok-bakso',
                    'description' => 'Mie kocok dengan tambahan bakso sapi kenyal.',
                    'price' => 25000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Yamin Manis',
                    'slug' => 'yamin-manis',
                    'description' => 'Mie ayam dengan racikan kecap manis khas Bandung.',
                    'price' => 20000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Pangsit Goreng',
                    'slug' => 'pangsit-goreng',
                    'description' => 'Pangsit renyah dengan isian ayam berbumbu.',
                    'price' => 10000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'soto-ayam-bu-rahayu' => [
                [
                    'name' => 'Soto Ayam Kampung',
                    'slug' => 'soto-ayam-kampung',
                    'description' => 'Soto ayam kampung dengan kuah bening dan suwiran ayam.',
                    'price' => 18000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Soto Daging Sapi',
                    'slug' => 'soto-daging-sapi',
                    'description' => 'Soto daging sapi dengan kuah kaldu gurih dan rempah.',
                    'price' => 23000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Nasi Putih',
                    'slug' => 'nasi-putih',
                    'description' => 'Nasi putih hangat sebagai pelengkap soto.',
                    'price' => 5000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Sate Usus',
                    'slug' => 'sate-usus',
                    'description' => 'Sate usus ayam berbumbu manis gurih.',
                    'price' => 5000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'kopi-tjangkir' => [
                [
                    'name' => 'Kopi Tubruk',
                    'slug' => 'kopi-tubruk',
                    'description' => 'Kopi hitam tradisional dengan seduhan sederhana.',
                    'price' => 10000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Kopi Susu Gula Aren',
                    'slug' => 'kopi-susu-gula-aren',
                    'description' => 'Perpaduan kopi, susu, dan manis alami gula aren.',
                    'price' => 18000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Wedang Uwuh',
                    'slug' => 'wedang-uwuh',
                    'description' => 'Minuman rempah tradisional dengan jahe, kayu secang, dan cengkeh.',
                    'price' => 12000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Pisang Goreng',
                    'slug' => 'pisang-goreng',
                    'description' => 'Pisang goreng hangat dengan lapisan tepung renyah.',
                    'price' => 12000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'dapur-klepon' => [
                [
                    'name' => 'Klepon Isi Gula Merah',
                    'slug' => 'klepon-isi-gula-merah',
                    'description' => 'Kue tradisional berbahan tepung ketan dengan isian gula merah.',
                    'price' => 10000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Lupis Ketan',
                    'slug' => 'lupis-ketan',
                    'description' => 'Ketan kukus dengan parutan kelapa dan saus gula merah.',
                    'price' => 10000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Cenil Pelangi',
                    'slug' => 'cenil-pelangi',
                    'description' => 'Jajanan kenyal warna-warni dengan kelapa parut dan gula merah.',
                    'price' => 10000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Kue Putu',
                    'slug' => 'kue-putu',
                    'description' => 'Kue tepung beras kukus dengan isian gula merah dan kelapa.',
                    'price' => 10000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'es-dawet-nyess' => [
                [
                    'name' => 'Es Dawet Ayu',
                    'slug' => 'es-dawet-ayu',
                    'description' => 'Dawet pandan dengan santan dan gula merah cair.',
                    'price' => 10000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Es Cendol Durian',
                    'slug' => 'es-cendol-durian',
                    'description' => 'Cendol segar dengan santan, gula merah, dan daging durian.',
                    'price' => 18000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Es Tape Ketan',
                    'slug' => 'es-tape-ketan',
                    'description' => 'Minuman dingin dengan tape ketan manis dan santan.',
                    'price' => 12000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Es Gula Asem',
                    'slug' => 'es-gula-asem',
                    'description' => 'Minuman tradisional dari asam jawa dan gula merah.',
                    'price' => 8000,
                    'image' => null,
                    'is_available' => true,
                ],
            ],

            'sambal-hejo-cibiru' => [
                [
                    'name' => 'Nasi Ayam Sambal Hejo',
                    'slug' => 'nasi-ayam-sambal-hejo',
                    'description' => 'Ayam goreng dengan sambal cabai hijau khas Sunda.',
                    'price' => 23000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Nasi Ikan Asin',
                    'slug' => 'nasi-ikan-asin',
                    'description' => 'Nasi hangat dengan ikan asin goreng, lalapan, dan sambal hejo.',
                    'price' => 20000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Cumi Sambal Hejo',
                    'slug' => 'cumi-sambal-hejo',
                    'description' => 'Cumi tumis dengan sambal hijau pedas dan bawang.',
                    'price' => 28000,
                    'image' => null,
                    'is_available' => true,
                ],
                [
                    'name' => 'Terong Goreng',
                    'slug' => 'terong-goreng',
                    'description' => 'Terong goreng dengan sambal hijau dan taburan bawang.',
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
