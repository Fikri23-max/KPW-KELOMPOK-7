<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@resto.test'],
            [
                'name' => 'Admin Resto',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'pelanggan@resto.test'],
            [
                'name' => 'Pelanggan Contoh',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        $categories = [
            'Makanan Utama' => [
                ['name' => 'Nasi Goreng Spesial', 'price' => 25000, 'description' => 'Nasi goreng dengan telur, ayam suwir, dan kerupuk.', 'image' => 'images/menu/nasi-goreng-spesial.svg'],
                ['name' => 'Ayam Geprek', 'price' => 20000, 'description' => 'Ayam crispy dengan sambal bawang pedas.', 'image' => 'images/menu/ayam-geprek.svg'],
                ['name' => 'Mie Ayam Bakso', 'price' => 18000, 'description' => 'Mie ayam dengan tambahan bakso sapi.', 'image' => 'images/menu/mie-ayam-bakso.svg'],
            ],
            'Minuman' => [
                ['name' => 'Es Teh Manis', 'price' => 5000, 'description' => 'Teh manis dingin segar.', 'image' => 'images/menu/es-teh-manis.svg'],
                ['name' => 'Es Jeruk', 'price' => 7000, 'description' => 'Jeruk peras asli dengan es batu.', 'image' => 'images/menu/es-jeruk.svg'],
                ['name' => 'Kopi Susu Gula Aren', 'price' => 15000, 'description' => 'Kopi susu dengan gula aren khas.', 'image' => 'images/menu/kopi-susu-gula-aren.svg'],
            ],
            'Camilan' => [
                ['name' => 'Tahu Crispy', 'price' => 10000, 'description' => 'Tahu goreng tepung crispy, disajikan dengan saus.', 'image' => 'images/menu/tahu-crispy.svg'],
                ['name' => 'Pisang Goreng Coklat Keju', 'price' => 12000, 'description' => 'Pisang goreng dengan topping coklat dan keju.', 'image' => 'images/menu/pisang-goreng-coklat-keju.svg'],
            ],
        ];

        foreach ($categories as $categoryName => $menus) {
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Str::slug($categoryName) . '-' . Str::random(4)]
            );

            foreach ($menus as $menu) {
                Menu::updateOrCreate(
                    ['name' => $menu['name']],
                    [
                        'category_id' => $category->id,
                        'description' => $menu['description'],
                        'price' => $menu['price'],
                        'image' => $menu['image'],
                        'is_available' => true,
                    ]
                );
            }
        }

        $this->call(ProdukBaruSeeder::class);
    }
}
