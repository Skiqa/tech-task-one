<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1 as V1;

Route::prefix('v1')->group(function () {
    Route::prefix('organizations')->group(function () {
        Route::get('/search', [V1\OrganizationController::class, 'search']);
        Route::get('/{organization}', [V1\OrganizationController::class, 'show']);
        Route::get('/near', [OrganizationController::class, 'nearBy']);
        Route::get('/{building}/buildings', [V1\OrganizationController::class, 'listOfBuilding']);
        Route::get('/{activity}/activities', [V1\OrganizationController::class, 'listOfActivity']);
    });
});