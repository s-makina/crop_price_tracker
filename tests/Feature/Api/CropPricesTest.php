<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Crop;
use App\Models\Price;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CropPricesTest extends TestCase
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
    public function it_gets_crop_prices(): void
    {
        $crop = Crop::factory()->create();
        $prices = Price::factory()
            ->count(2)
            ->create([
                'crop_id' => $crop->id,
            ]);

        $response = $this->getJson(route('api.crops.prices.index', $crop));

        $response->assertOk()->assertSee($prices[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_crop_prices(): void
    {
        $crop = Crop::factory()->create();
        $data = Price::factory()
            ->make([
                'crop_id' => $crop->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.crops.prices.store', $crop),
            $data
        );

        $this->assertDatabaseHas('prices', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $price = Price::latest('id')->first();

        $this->assertEquals($crop->id, $price->crop_id);
    }
}
