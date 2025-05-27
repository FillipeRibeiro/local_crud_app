<?php

namespace App\Actions\Place;

use App\Models\Place;
use Illuminate\Http\Response;

class DeletePlaceActions
{
    public function handle(int $id): void
    {
        $place = Place::find($id);

        abort_if(empty($place), Response::HTTP_NOT_FOUND, __('response.not_found', ['attribute' => 'Local']));

        $place->delete();
    }
}
