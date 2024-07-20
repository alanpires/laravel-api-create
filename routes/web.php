<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiViaCepController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/search/local/{values}', [ApiViaCepController::class, 'getAddresses']);