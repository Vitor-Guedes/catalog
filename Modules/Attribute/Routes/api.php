<?php

use Modules\Attribute\Http\Controllers\GroupController;

Route::prefix('attribute')->group(function () {
    Route::apiResource('families', 'FamilyController')->parameters(['families' =>'id']);
    Route::apiResource('groups', 'GroupController')->parameters(['groups' => 'id']);

    Route::prefix('groups')->group(function () {
        Route::post('mapping', [GroupController::class, 'mapping']);
        Route::post('mapping/ids', [GroupController::class, 'mappingIds']);
    });
});

Route::apiResource('attributes', 'AttributeController')->parameters(['attributes' => 'id']);