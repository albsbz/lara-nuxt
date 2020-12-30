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
        ProductCategory::factory(20)->create();
    }
}
