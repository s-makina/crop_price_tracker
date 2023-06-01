<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Crop;
use App\Models\Market;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MarketCropsTest extends TestCase
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
    public function it_gets_market_crops(): void
    {
        $market = Market::factory()->create();
        $crops = Crop::factory()
            ->count(2)
            ->create([
                'market_id' => $market->id,
            ]);

        $response = $this->getJson(route('api.markets.crops.index', $market));

        $response->assertOk()->assertSee($crops[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_market_crops(): void
    {
        $market = Market::factory()->create();
        $data = Crop::factory()
            ->make([
                'market_id' => $market->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.markets.crops.store', $market),
            $data
        );

        $this->assertDatabaseHas('crops', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $crop = Crop::latest('id')->first();

        $this->assertEquals($market->id, $crop->market_id);
    }
}
