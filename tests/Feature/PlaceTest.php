<?php

use App\Models\Place;

use function Pest\Laravel\{get, post, patch, delete};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

test('lists all places without filters', function () {
    Place::factory()->count(3)->create();

    $response = get('/api/place', [
        'Accept' => 'application/json'
    ]);

    $response->assertOk();
    $response->assertJsonCount(3, 'data');
});

test('filter places by city, state and name', function () {
    Place::factory()->create(['city' => 'São Paulo', 'state' => 'SP', 'name' => 'Home']);
    Place::factory()->create(['city' => 'Rio de Janeiro', 'state' => 'RJ', 'name' => 'Office']);

    $response = get('/api/place?city=São Paulo&state=SP&name=Home', [
        'Accept' => 'application/json'
    ]);

    $response->assertOk();
    $response->assertJsonCount(1, 'data');
    $response->assertJsonFragment(['city' => 'São Paulo', 'state' => 'SP', 'name' => 'Home']);
});

test('returns paginated results', function () {
    Place::factory()->count(20)->create();

    $response = get('/api/place', [
        'Accept' => 'application/json'
    ]);

    $response->assertOk();
    $response->assertJsonStructure([
        'data',
        'links',
        'meta',
    ]);
    $response->assertJsonPath('meta.per_page', 15);
});

test('check if place does not exists when searching by id', function () {
    $response = get("/api/place/30", [
        'Accept' => 'application/json'
    ]);

    $response->assertNotFound();

    $response->assertJson([
        'message' => __('response.not_found', ['attribute' => 'Local'])
    ]);
});

test('returns place by id', function () {
    $place = Place::factory()->create();

    $response = get("/api/place/{$place->id}", [
        'Accept' => 'application/json'
    ]);

    $response->assertOk();
    $response->assertJsonFragment([
        'id' => $place->id,
        'name' => $place->name,
        'slug' => $place->slug,
        'city' => $place->city,
        'state' => $place->state,
    ]);
});

test('check if place was created', function () {
    $name = fake()->name();
    $city = fake()->city();
    $state = fake()->stateAbbr;

    $response = post('/api/place', [
        'name' => $name,
        'city' => $city,
        'state' => $state,
    ], [
        'Accept' => 'application/json'
    ]);

    $response->assertCreated();

    $response->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'slug',
            'city',
            'state',
            'created_at',
            'updated_at',
        ],
    ]);

    $response->assertJsonFragment([
        'name' => $name,
        'slug' => Str::slug($name),
        'city' => $city,
        'state' => $state,
    ]);
});

test('check if place does not exists when updating', function () {
    $response = patch("/api/place/30", [
        'name' => fake()->name(),
        'city' => fake()->city(),
        'state' => fake()->stateAbbr,
    ], [
        'Accept' => 'application/json'
    ]);

    $response->assertNotFound();

    $response->assertJson([
        'message' => __('response.not_found', ['attribute' => 'Local'])
    ]);
});

test('check if place was updated', function () {
    $place = Place::factory()->create();

    $newName = fake()->name();
    $newCity = fake()->city();
    $newState = fake()->stateAbbr;

    $response = patch("/api/place/{$place->id}", [
        'name' => $newName,
        'city' => $newCity,
        'state' => $newState,
    ], [
        'Accept' => 'application/json'
    ]);

    $response->assertOk();

    $response->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'slug',
            'city',
            'state',
            'created_at',
            'updated_at',
        ],
    ]);

    $response->assertJsonFragment([
        'name' => $newName,
        'slug' => Str::slug($newName),
        'city' => $newCity,
        'state' => $newState,
    ]);
});

test('check if place does not exists when deleting', function () {
    $response = delete("/api/place/30", [
        'name' => fake()->name(),
        'city' => fake()->city(),
        'state' => fake()->stateAbbr,
    ], [
        'Accept' => 'application/json'
    ]);

    $response->assertNotFound();

    $response->assertJson([
        'message' => __('response.not_found', ['attribute' => 'Local'])
    ]);
});

test('check if place was deleted', function () {
    $place = Place::factory()->create();

    $response = delete("/api/place/{$place->id}", [
        'Accept' => 'application/json'
    ]);

    $response->assertOk();

    $response->assertJson([
        'message' => __('response.deleted_success', ['attribute' => 'Local'])
    ]);
});
