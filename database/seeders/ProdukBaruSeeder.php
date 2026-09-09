<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdukBaruSeeder extends Seeder
{
    /**
     * Menambahkan 5 produk makanan & minuman baru sebagai "Produk Pilihan".
     */
    public function run(): void
    {
        $produkBaru = [
            [
                'kategori' => 'Makanan Utama',
                'name' => 'Sate Ayam Madura',
                'description' => 'Sate ayam bakar bumbu kacang khas Madura, disajikan dengan lontong.',
                'price' => 22000,
                'image' => 'images/menu/sate-ayam-madura.svg',
            ],
            [
                'kategori' => 'Makanan Utama',
                'name' => 'Rendang Sapi',
                'description' => 'Daging sapi empuk dimasak berjam-jam dengan bumbu rendang khas Padang.',
                'price' => 32000,
                'image' => 'images/menu/rendang-sapi.svg',
            ],
            [
                'kategori' => 'Camilan',
                'name' => 'Roti Bakar Coklat Keju',
                'description' => 'Roti bakar renyah dengan lelehan coklat dan taburan keju parut.',
                'price' => 14000,
                'image' => 'images/menu/roti-bakar-coklat-keju.svg',
            ],
            [
                'kategori' => 'Minuman',
                'name' => 'Es Cendol',
                'description' => 'Cendol segar dengan santan dan gula merah cair.',
                'price' => 12000,
                'image' => 'images/menu/es-cendol.svg',
            ],
            [
                'kategori' => 'Minuman',
                'name' => 'Jus Alpukat',
                'description' => 'Jus alpukat kental dengan susu coklat di atasnya.',
                'price' => 16000,
                'image' => 'images/menu/jus-alpukat.svg',
            ],
        ];

        foreach ($produkBaru as $produk) {
            $category = Category::firstOrCreate(
                ['name' => $produk['kategori']],
                ['slug' => Str::slug($produk['kategori']) . '-' . Str::random(4)]
            );

            Menu::updateOrCreate(
                ['name' => $produk['name']],
                [
                    'category_id' => $category->id,
                    'description' => $produk['description'],
                    'price' => $produk['price'],
                    'image' => $produk['image'],
                    'is_available' => true,
                    'is_featured' => true,
                ]
            );
        }
    }
}
