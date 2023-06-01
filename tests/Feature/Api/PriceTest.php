<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Price;

use App\Models\Crop;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PriceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_prices_list(): void
    {
        $prices = Price::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.prices.index'));

        $response->assertOk()->assertSee($prices[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_price(): void
    {
        $data = Price::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.prices.store'), $data);

        $this->assertDatabaseHas('prices', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_price(): void
    {
        $price = Price::factory()->create();

        $crop = Crop::factory()->create();

        $data = [
            'date' => $this->faker->date(),
            'price' => $this->faker->randomNumber(2),
            'crop_id' => $crop->id,
        ];

        $response = $this->putJson(route('api.prices.update', $price), $data);

        $data['id'] = $price->id;

        $this->assertDatabaseHas('prices', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_price(): void
    {
        $price = Price::factory()->create();

        $response = $this->deleteJson(route('api.prices.destroy', $price));

        $this->assertModelMissing($price);

        $response->assertNoContent();
    }
}
