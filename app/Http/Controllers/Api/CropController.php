<?php

namespace App\Http\Controllers\Api;

use App\Models\Crop;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\CropResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CropCollection;
use App\Http\Requests\CropStoreRequest;
use App\Http\Requests\CropUpdateRequest;

class CropController extends Controller
{
    public function index(Request $request): CropCollection
    {
        $this->authorize('view-any', Crop::class);

        $search = $request->get('search', '');

        $crops = Crop::search($search)
            ->latest()
            ->paginate();

        return new CropCollection($crops);
    }

    public function store(CropStoreRequest $request): CropResource
    {
        $this->authorize('create', Crop::class);

        $validated = $request->validated();

        $crop = Crop::create($validated);

        return new CropResource($crop);
    }

    public function show(Request $request, Crop $crop): CropResource
    {
        $this->authorize('view', $crop);

        return new CropResource($crop);
    }

    public function update(CropUpdateRequest $request, Crop $crop): CropResource
    {
        $this->authorize('update', $crop);

        $validated = $request->validated();

        $crop->update($validated);

        return new CropResource($crop);
    }

    public function destroy(Request $request, Crop $crop): Response
    {
        $this->authorize('delete', $crop);

        $crop->delete();

        return response()->noContent();
    }
}
