<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $count = 3;
    protected $countChildren = 3;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate:fresh');
    }

    public function testProductIndex()
    {
        Category::factory()->create()->each(function ($category) {
            $category->products()->createMany(
                Product::factory()->count($this->countChildren)->raw()
            );
        });

        $category = Category::inRandomOrder()->first();
        $productName = Product::inRandomOrder()->first()->name;

        $response = $this->json("GET", route('product.index', $category));
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'name' => (string) $productName
            ]);
    }

    public function testProductStore()
    {
        Category::factory()->count($this->count)->create();

        $payload = Product::factory()->raw();
        $categories = Category::get();

        foreach ($categories as $category) {
            $payload['categories_slug'][] = $category->slug;
        }

        $response = $this->json("POST", route('product.store'), $payload);
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment([
                'name' => $payload['name'],
            ]);
        $payloadId = json_decode($response->getContent(), true)['data']['id'];
        $categoriesSlug = Product::find($payloadId)->categories()->first()->slug;
        $this->assertTrue(in_array($categoriesSlug, $payload['categories_slug'], true));
    }

    public function testProductUpdate()
    {
        Category::factory()->count($this->count)->create()->each(function ($category) {
            $category->products()->createMany(
                Product::factory()->count($this->countChildren)->raw()
            );
        });

        $categorySlug = Str::slug('new category');
        Category::factory()->create([
            'slug' => $categorySlug,
        ]);

        $product = Product::inRandomOrder()->first();

        $name = $this->faker->realText(20);
        $payload = Product::factory()->raw([
            'name' => $name,
            'categories_slug' => [$categorySlug]
        ]);

        $response = $this->json("put", route('product.update', $product), $payload);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'name' => $name,
            ]);

        $categoriesSlug = Product::find($product->id)->categories()->first()->slug;
        $this->assertTrue(in_array($categoriesSlug, $payload['categories_slug'], true));
    }

    public function testProductDelete()
    {
        Category::factory()->count($this->count)->create()->each(function ($category) {
            $category->products()->createMany(
                Product::factory()->count($this->countChildren)->raw()
            );
        });

        $product = Product::inRandomOrder()->first();

        $response = $this->json("DELETE", route('product.delete', $product));
        $response
            ->assertStatus(Response::HTTP_OK);
    }
}
