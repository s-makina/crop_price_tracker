<?php

namespace App\Http\Controllers\Api;

use App\Models\Market;
use Illuminate\Http\Request;
use App\Http\Resources\CropResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CropCollection;

class MarketCropsController extends Controller
{
    public function index(Request $request, Market $market): CropCollection
    {
        $this->authorize('view', $market);

        $search = $request->get('search', '');

        $crops = $market
            ->crops()
            ->search($search)
            ->latest()
            ->paginate();

        return new CropCollection($crops);
    }

    public function store(Request $request, Market $market): CropResource
    {
        $this->authorize('create', Crop::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
        ]);

        $crop = $market->crops()->create($validated);

        return new CropResource($crop);
    }
}
