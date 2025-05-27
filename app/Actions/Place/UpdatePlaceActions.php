<?php

namespace App\Actions\Place;

use App\Models\Place;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class UpdatePlaceActions
{
    public function handle(int $placeId, array $data): Place
    {
        $place = Place::find($placeId);

        abort_if(empty($place), Response::HTTP_NOT_FOUND, __('response.not_found', ['attribute' => 'Local']));

        $place->update([
            'name' => $data['name'] ?? $place->name,
            'slug' => Str::slug($data['name'], '-') ?? $place->slug,
            'city' => $data['city'] ?? $place->city,
            'state' => $data['state'] ?? $place->state,
        ]);

        return $place->fresh();
    }
}
