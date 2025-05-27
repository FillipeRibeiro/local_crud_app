<?php

namespace App\Http\Controllers;

use App\Actions\Place\CreatePlaceActions;
use App\Actions\Place\DeletePlaceActions;
use App\Actions\Place\UpdatePlaceActions;
use App\Http\Requests\CreatePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Http\Resources\PlaceResource;
use App\Services\Place\PlaceServices;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PlaceController extends Controller
{
    public function __construct(
        private CreatePlaceActions $createPlaceAction,
        private UpdatePlaceActions $updatePlaceAction,
        private DeletePlaceActions $deletePlaceAction,
        private PlaceServices $placeServices,
    ) {}

    public function list(Request $request): AnonymousResourceCollection
    {
        $places = $this->placeServices->getPlaces($request);

        return PlaceResource::collection($places);
    }

    public function create(CreatePlaceRequest $request): PlaceResource
    {
        $placeCreated = $this->createPlaceAction->handle($request->validated());

        return new PlaceResource($placeCreated);
    }

    public function show(int $id): PlaceResource
    {
        $place = $this->placeServices->getPlaceById($id);

        return new PlaceResource($place);
    }

    public function update(UpdatePlaceRequest $request, int $id): PlaceResource
    {
        $placeUpdated = $this->updatePlaceAction->handle($id, $request->validated());

        return new PlaceResource($placeUpdated);
    }

    public function delete(int $id)
    {
        $this->deletePlaceAction->handle($id);

        return response()->json([
            'message' => __('response.deleted_success', ['attribute' => 'Local'])
        ], Response::HTTP_OK);
    }
}
