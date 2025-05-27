<?php

namespace App\Services\Place;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlaceServices
{
    public function getPlaceById(int $placeId): Place
    {
        $place = Place::find($placeId);

        abort_if(empty($place), Response::HTTP_NOT_FOUND, __('response.not_found', ['attribute' => 'Local']));

        return $place;
    }

    public function getPlaces(Request $request)
    {
        $places = Place::query()
            ->when($request->name, function ($query) use ($request) {
                return $query->where('name', 'like', "%{$request->name}%");
            })
            ->when($request->city, function ($query) use ($request) {
                return $query->where('city', 'like', "%{$request->city}%");
            })
            ->when($request->state, function ($query) use ($request) {
                return $query->where('state', 'like', "%{$request->state}%");
            })
            ->when($request->slug, function ($query) use ($request) {
                return $query->where('slug', 'like', "%{$request->slug}%");
            })->paginate(15);

        return $places;
    }
}
