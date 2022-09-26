<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    protected $count = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'without category';
        DB::table('categories')->insert([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' =>  null,
        ]);

        Category::factory()->count($this->count)->create();
    }
}
