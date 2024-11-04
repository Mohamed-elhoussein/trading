<?php

use App\Http\Controllers\Admin\Mt5\GoldPriceController;



Route::controller(GoldPriceController::class)->prefix("trading")->group(function () {
    Route::get("index","index")->name("gold-price.index");
});
Route::post('/api/update-prices', [GoldPriceController::class, 'updatePrices'])->name('gold-price.update');
