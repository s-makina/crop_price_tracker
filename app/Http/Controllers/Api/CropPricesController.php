<?php

namespace App\Http\Controllers\Api;

use App\Models\Crop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PriceResource;
use App\Http\Resources\PriceCollection;

class CropPricesController extends Controller
{
    public function index(Request $request, Crop $crop): PriceCollection
    {
        $this->authorize('view', $crop);

        $search = $request->get('search', '');

        $prices = $crop
            ->prices()
            ->search($search)
            ->latest()
            ->paginate();

        return new PriceCollection($prices);
    }

    public function store(Request $request, Crop $crop): PriceResource
    {
        $this->authorize('create', Price::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'price' => ['required', 'numeric'],
        ]);

        $price = $crop->prices()->create($validated);

        return new PriceResource($price);
    }
}
