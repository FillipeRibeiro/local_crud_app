<?php

use App\Http\Controllers\PlaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('place')->group(function () {
    Route::get('/', [PlaceController::class, 'list']);
    Route::post('/', [PlaceController::class, 'create']);

    Route::get('/{id}', [PlaceController::class, 'show'])->whereNumber('id');
    Route::patch('/{id}', [PlaceController::class, 'update'])->whereNumber('id');
    Route::delete('/{id}', [PlaceController::class, 'delete'])->whereNumber('id');
});
