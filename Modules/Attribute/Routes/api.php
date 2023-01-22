<?php

Route::prefix('attribute')->group(function () {
    Route::apiResource('families', 'FamilyController')->parameters(['families' =>'id']);
    Route::apiResource('groups', 'GroupController')->parameters(['groups' => 'id']);
});

Route::apiResource('attributes', 'AttributeController')->parameters(['attributes' => 'id']);