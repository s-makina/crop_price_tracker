<?php

namespace App\Http\Controllers\Api;

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PriceResource;
use App\Http\Resources\PriceCollection;
use App\Http\Requests\PriceStoreRequest;
use App\Http\Requests\PriceUpdateRequest;

class PriceController extends Controller
{
    public function index(Request $request): PriceCollection
    {
        $this->authorize('view-any', Price::class);

        $search = $request->get('search', '');

        $prices = Price::search($search)
            ->latest()
            ->paginate();

        return new PriceCollection($prices);
    }

    public function store(PriceStoreRequest $request): PriceResource
    {
        $this->authorize('create', Price::class);

        $validated = $request->validated();

        $price = Price::create($validated);

        return new PriceResource($price);
    }

    public function show(Request $request, Price $price): PriceResource
    {
        $this->authorize('view', $price);

        return new PriceResource($price);
    }

    public function update(
        PriceUpdateRequest $request,
        Price $price
    ): PriceResource {
        $this->authorize('update', $price);

        $validated = $request->validated();

        $price->update($validated);

        return new PriceResource($price);
    }

    public function destroy(Request $request, Price $price): Response
    {
        $this->authorize('delete', $price);

        $price->delete();

        return response()->noContent();
    }
}
