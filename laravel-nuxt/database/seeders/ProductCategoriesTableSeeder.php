<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert([
            'name' => 'basic',
            'description' => 'basic category - not delete',
            'slug' => 'basic',
            'parent_id' => null
        ]);


        for ($i = 1; $i <= 40; $i++) {
        ProductCategory::factory(1)->create()->each(function ($category) {
            $allCategories = ProductCategory::all()->except($category->id);
            $category->parent()->associate($allCategories->random(1)->pluck('id')->toArray()[0]);
            $category->save();
        });
    }
    }
}
