<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_features')->insert([
            'name' => 'size',
        ]);
        DB::table('product_features')->insert([
            'name' => 'color',
        ]);
        DB::table('product_features')->insert([
            'name' => 'weight',
        ]);
    }
}
