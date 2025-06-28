<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OpportunityController;

Route::apiResource('opportunities', OpportunityController::class);
