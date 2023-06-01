<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Crop;

use App\Models\Market;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CropControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_crops(): void
    {
        $crops = Crop::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('crops.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.crops.index')
            ->assertViewHas('crops');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_crop(): void
    {
        $response = $this->get(route('crops.create'));

        $response->assertOk()->assertViewIs('app.crops.create');
    }

    /**
     * @test
     */
    public function it_stores_the_crop(): void
    {
        $data = Crop::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('crops.store'), $data);

        $this->assertDatabaseHas('crops', $data);

        $crop = Crop::latest('id')->first();

        $response->assertRedirect(route('crops.edit', $crop));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_crop(): void
    {
        $crop = Crop::factory()->create();

        $response = $this->get(route('crops.show', $crop));

        $response
            ->assertOk()
            ->assertViewIs('app.crops.show')
            ->assertViewHas('crop');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_crop(): void
    {
        $crop = Crop::factory()->create();

        $response = $this->get(route('crops.edit', $crop));

        $response
            ->assertOk()
            ->assertViewIs('app.crops.edit')
            ->assertViewHas('crop');
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

        $response = $this->put(route('crops.update', $crop), $data);

        $data['id'] = $crop->id;

        $this->assertDatabaseHas('crops', $data);

        $response->assertRedirect(route('crops.edit', $crop));
    }

    /**
     * @test
     */
    public function it_deletes_the_crop(): void
    {
        $crop = Crop::factory()->create();

        $response = $this->delete(route('crops.destroy', $crop));

        $response->assertRedirect(route('crops.index'));

        $this->assertSoftDeleted($crop);
    }
}
