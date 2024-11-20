<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;
use App\Models\Menu;
use Illuminate\Support\Str;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve all menu IDs
        $menuIds = Menu::pluck('id');

        foreach ($menuIds as $menuId) {
            for ($i = 1; $i <= 10; $i++) {
                Meal::create([
                    'arabic_name' => 'وجبة ' . $i,
                    'english_name' => 'Meal ' . $i,
                    'turkish_name' => 'Yemek ' . $i,
                    'arabic_description' => 'وصف الوجبة ' . $i,
                    'english_description' => 'Description of Meal ' . $i,
                    'turkish_description' => 'Yemek ' . $i . ' açıklaması',
                    'price_1' => rand(10, 50),
                    'price_2' => rand(50, 100),
                    'price_3' => rand(100, 150),
                    'menu_id' => $menuId,
                    'branch_id' => 1,
                    'images' => '["meal_images/bInkHkq57a6DtM3ZhuNaah6jemR5KiIxqTDbomke.jpg"]', // Replace with actual image if available
                ]);
            }
        }
    }
}
