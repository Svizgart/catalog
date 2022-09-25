<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Illuminate\Support\Facades\Artisan;
use App\Models\{Category, Product};
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $count = 3;
    protected $countChildren = 3;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate:fresh');
    }

    public function testCategoryIndex()
    {
        Category::factory()->count($this->count)->create();
        $categoryName = Category::inRandomOrder()->first()->name;

        $response = $this->json("GET", route('category.index'));
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'name' => (string) $categoryName
            ]);
    }

    public function testCategoryStore()
    {
        $payload = Category::factory()->raw();

        $response = $this->json("POST", route('category.store'), $payload);
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment([
                'name' => $payload['name']
            ]);
    }

    public function testCategoryUpdate()
    {
        $category = Category::factory()->create();

        $name = $this->faker->realText(20);
        $payload = Category::factory()->raw([
            'name' => $name,
        ]);

        $response = $this->json("put", route('category.update', $category), $payload);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'name' => $name,
            ]);
    }

    public function testCategoryDelete()
    {
        $category = Category::factory()->create();

        $response = $this->json("DELETE", route('category.delete', $category));
        $response
            ->assertStatus(Response::HTTP_OK);
    }

}
