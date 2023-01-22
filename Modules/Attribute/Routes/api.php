<?php

Route::prefix('attribute')->group(function () {
    Route::apiResource('families', 'FamilyController')->parameters(['families' =>'id']);
});