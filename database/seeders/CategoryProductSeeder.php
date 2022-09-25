<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = $this->getProducts();

        foreach($products as $value) {
            DB::table('category_product')->insert([
                'category_id' => Category::inRandomOrder()->first()->id,
                'product_id' => $value->id
            ]);
            
        }
    }

    private function getProducts() 
    {
        return DB::table('products')->get();
    }
}
