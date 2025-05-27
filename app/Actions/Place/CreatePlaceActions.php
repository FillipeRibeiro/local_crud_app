<?php

namespace App\Actions\Place;

use App\Models\Place;
use Illuminate\Support\Str;

class CreatePlaceActions
{
    public function handle(array $data): Place
    {
        return Place::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'], '-'),
            'city' => $data['city'],
            'state' => $data['state'],
        ]);
    }
}
