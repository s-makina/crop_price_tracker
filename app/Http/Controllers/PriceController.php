<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Price;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PriceStoreRequest;
use App\Http\Requests\PriceUpdateRequest;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Price::class);

        $search = $request->get('search', '');

        $prices = Price::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.prices.index', compact('prices', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Price::class);

        $crops = Crop::pluck('name', 'id');

        return view('app.prices.create', compact('crops'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PriceStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Price::class);

        $validated = $request->validated();

        $price = Price::create($validated);

        return redirect()
            ->route('prices.edit', $price)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Price $price): View
    {
        $this->authorize('view', $price);

        return view('app.prices.show', compact('price'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Price $price): View
    {
        $this->authorize('update', $price);

        $crops = Crop::pluck('name', 'id');

        return view('app.prices.edit', compact('price', 'crops'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PriceUpdateRequest $request,
        Price $price
    ): RedirectResponse {
        $this->authorize('update', $price);

        $validated = $request->validated();

        $price->update($validated);

        return redirect()
            ->route('prices.edit', $price)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Price $price): RedirectResponse
    {
        $this->authorize('delete', $price);

        $price->delete();

        return redirect()
            ->route('prices.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
