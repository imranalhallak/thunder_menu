<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $menus = [
            ['slug' => 'breakfast', 'arabic_name' => 'الإفطار', 'english_name' => 'Breakfast', 'turkish_name' => 'Kahvaltı'],
            ['slug' => 'lunch', 'arabic_name' => 'الغداء', 'english_name' => 'Lunch', 'turkish_name' => 'Öğle Yemeği'],
            ['slug' => 'dinner', 'arabic_name' => 'العشاء', 'english_name' => 'Dinner', 'turkish_name' => 'Akşam Yemeği'],
            ['slug' => 'drinks', 'arabic_name' => 'المشروبات', 'english_name' => 'Drinks', 'turkish_name' => 'İçecekler'],
            ['slug' => 'dessert', 'arabic_name' => 'الحلويات', 'english_name' => 'Dessert', 'turkish_name' => 'Tatlı'],
            ['slug' => 'kids', 'arabic_name' => 'الأطفال', 'english_name' => 'Kids', 'turkish_name' => 'Çocuk'],
            ['slug' => 'vegetarian', 'arabic_name' => 'النباتيين', 'english_name' => 'Vegetarian', 'turkish_name' => 'Vejetaryen'],
            ['slug' => 'seafood', 'arabic_name' => 'المأكولات البحرية', 'english_name' => 'Seafood', 'turkish_name' => 'Deniz Ürünleri'],
            ['slug' => 'specials', 'arabic_name' => 'العروض الخاصة', 'english_name' => 'Specials', 'turkish_name' => 'Özel Menüler'],
            ['slug' => 'combo', 'arabic_name' => 'الكومبو', 'english_name' => 'Combo', 'turkish_name' => 'Kombinasyon'],
        ];

        foreach ($menus as $menu) {
          Menu ::create([
                'image' => 'default_menu_image.png', // Replace with the actual or default image path
                'slug' => $menu['slug'],
                'arabic_name' => $menu['arabic_name'],
                'english_name' => $menu['english_name'],
                'turkish_name' => $menu['turkish_name'],
                'branch_id' => 1, // Branch ID set to 1
            ]);
        }
    }
}
