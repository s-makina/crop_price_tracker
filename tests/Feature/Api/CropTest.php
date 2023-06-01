<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Crop;

use App\Models\Market;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CropTest extends TestCase
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
    public function it_gets_crops_list(): void
    {
        $crops = Crop::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.crops.index'));

        $response->assertOk()->assertSee($crops[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_crop(): void
    {
        $data = Crop::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.crops.store'), $data);

        $this->assertDatabaseHas('crops', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_crop(): void
    {
        $crop = Crop::factory()->create();

        $market = Market::factory()->create();

        $data = [
            'name' => $this->faker->text(255),
            'description' => $this->faker->text(),
            'market_id' => $market->id,
        ];

        $response = $this->putJson(route('api.crops.update', $crop), $data);

        $data['id'] = $crop->id;

        $this->assertDatabaseHas('crops', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_crop(): void
    {
        $crop = Crop::factory()->create();

        $response = $this->deleteJson(route('api.crops.destroy', $crop));

        $this->assertSoftDeleted($crop);

        $response->assertNoContent();
    }
}
