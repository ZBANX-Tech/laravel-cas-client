<?php

use Illuminate\Support\Facades\Route;
use Zbanx\CasClient\Http\Controllers;


Route::get('routes', [Controllers\CommonController::class, 'routes']);
Route::post('login', [Controllers\AuthController::class, 'login']);
Route::post('logout', [Controllers\AuthController::class, 'logout']);

