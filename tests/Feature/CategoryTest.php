<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Response;
use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $count = 3;

    /*public function withoutMiddleware($middleware = null)
    {
        if (is_null($middleware)) {
            $this->app->instance('middleware.disable', true);

            return $this;
        }

        foreach ((array) $middleware as $abstract) {
            $this->app->instance($abstract, new class {
                public function handle($request, $next) {
                    return $next($request);
                }
            });
        }

        return $this;
    }*/

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
        $this->createAuthUser();

        $payload = Category::factory()->raw();

        $response = $this->json("POST", route('category.store'), $payload);
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment([
                'name' => $payload['name']
            ]);
    }

    public function testCategoryUpdate()
    {
        $this->createAuthUser();
        $category = Category::factory()->create();

        $name = $this->faker->realText(20);
        $payload = Category::factory()->raw([
            'name' => $name,
        ]);

        $response = $this->json("put", route('category.update', $category->slug), $payload);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'name' => $name,
            ]);
    }

    public function testCategoryDelete()
    {
        $this->createAuthUser();
        $category = Category::factory()->create();

        $response = $this->json("DELETE", route('category.delete', $category->slug));
        $response
            ->assertStatus(Response::HTTP_OK);
    }

    private function createAuthUser()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

}
