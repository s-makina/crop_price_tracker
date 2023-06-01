<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Price;

use App\Models\Crop;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PriceControllerTest extends TestCase
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
    public function it_displays_index_view_with_prices(): void
    {
        $prices = Price::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('prices.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.prices.index')
            ->assertViewHas('prices');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_price(): void
    {
        $response = $this->get(route('prices.create'));

        $response->assertOk()->assertViewIs('app.prices.create');
    }

    /**
     * @test
     */
    public function it_stores_the_price(): void
    {
        $data = Price::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('prices.store'), $data);

        $this->assertDatabaseHas('prices', $data);

        $price = Price::latest('id')->first();

        $response->assertRedirect(route('prices.edit', $price));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_price(): void
    {
        $price = Price::factory()->create();

        $response = $this->get(route('prices.show', $price));

        $response
            ->assertOk()
            ->assertViewIs('app.prices.show')
            ->assertViewHas('price');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_price(): void
    {
        $price = Price::factory()->create();

        $response = $this->get(route('prices.edit', $price));

        $response
            ->assertOk()
            ->assertViewIs('app.prices.edit')
            ->assertViewHas('price');
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

        $response = $this->put(route('prices.update', $price), $data);

        $data['id'] = $price->id;

        $this->assertDatabaseHas('prices', $data);

        $response->assertRedirect(route('prices.edit', $price));
    }

    /**
     * @test
     */
    public function it_deletes_the_price(): void
    {
        $price = Price::factory()->create();

        $response = $this->delete(route('prices.destroy', $price));

        $response->assertRedirect(route('prices.index'));

        $this->assertModelMissing($price);
    }
}
