<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['status' => 'success', 'message' => 'Bem Vindo ao Backend!'], 200);
});
