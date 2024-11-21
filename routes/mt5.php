<?php

use App\Http\Controllers\Admin\Mt5\GoldPriceController;
use App\Http\Controllers\Admin\Mt5\MetaTraderController;

Route::prefix("trading")->group(function(){
    Route::get('/connect-mt5', [MetaTraderController::class, 'connect']);
    Route::get('/open-buy',    [MetaTraderController::class, 'openBuy']);
    Route::get('/open-sell',   [MetaTraderController::class, 'openSell']);
    Route::get('/balance',     [MetaTraderController::class, 'getBalance']);
    Route::get('/getPrice',    [MetaTraderController::class, 'GetPriceGoldSeliver']);

});


Route::controller(GoldPriceController::class)->prefix("trading")->group(function () {
    Route::get("index","index")->name("gold-price.index");
});
Route::post('/api/update-prices', [GoldPriceController::class, 'updatePrices'])->name('gold-price.update');
