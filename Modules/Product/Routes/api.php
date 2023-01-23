<?php

Route::prefix('products')->group(function () {
    Route::apiResource('', 'ProductController')->parameters(['' => 'id']);
});