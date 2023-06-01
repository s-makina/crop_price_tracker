<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Market;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CropStoreRequest;
use App\Http\Requests\CropUpdateRequest;

class CropController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Crop::class);

        $search = $request->get('search', '');

        $crops = Crop::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.crops.index', compact('crops', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Crop::class);

        $markets = Market::pluck('name', 'id');

        return view('app.crops.create', compact('markets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CropStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Crop::class);

        $validated = $request->validated();

        $crop = Crop::create($validated);

        return redirect()
            ->route('crops.edit', $crop)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Crop $crop): View
    {
        $this->authorize('view', $crop);

        return view('app.crops.show', compact('crop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Crop $crop): View
    {
        $this->authorize('update', $crop);

        $markets = Market::pluck('name', 'id');

        return view('app.crops.edit', compact('crop', 'markets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CropUpdateRequest $request,
        Crop $crop
    ): RedirectResponse {
        $this->authorize('update', $crop);

        $validated = $request->validated();

        $crop->update($validated);

        return redirect()
            ->route('crops.edit', $crop)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Crop $crop): RedirectResponse
    {
        $this->authorize('delete', $crop);

        $crop->delete();

        return redirect()
            ->route('crops.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
