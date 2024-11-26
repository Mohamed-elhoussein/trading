<?php

use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\admin\WalletController;
use App\Http\Controllers\Admin\Mt5\TradingController;
use App\Http\Controllers\Admin\OrderHistoryController;
use App\Http\Controllers\Admin\Mt5\GoldPriceController;
use App\Http\Controllers\admin\WalleHistorytController;
use App\Http\Controllers\Admin\Mt5\MetaTraderController;
use App\Http\Controllers\Admin\Mt5\mt5ConnictionSubscribeController;

Route::prefix("trading")->group(function(){
    Route::get('/getPrice',    [MetaTraderController::class, 'GetPriceGoldSeliver']);
    Route::get('/GetId',       [mt5ConnictionSubscribeController::class, 'connectToAPI']);
    Route::get('/getPrice',    [mt5ConnictionSubscribeController::class, 'getPrice']);
    Route::get("/getOrder",    [OrdersController::class, 'index']);
    Route::post("/CreateOrder",    [OrdersController::class, 'store']);
    Route::put("/UpdateOrder",     [OrdersController::class, 'update']);
    Route::get("orderHistory/{id}",[OrderHistoryController::class,"getOrderHistory"])->name("order.History");
    Route::resource("wallet",WalletController::class);
    Route::get("walletHistory/{id}",[WalleHistorytController::class,"getWalletHistory"])->name("Wallet.History");

    Route::controller(TradingController::class)->prefix("mt5")->group(function(){
        Route::post("openOrder","sendOrder")->name("Trading/sendOrder");
        Route::post("closeOrder","closeOrder")->name("Trading/closeOrder");
    });

});












// Route::prefix("trading")->group(function(){
//     Route::get('/connect-mt5', [MetaTraderController::class, 'connect']);
//     Route::get('/open-buy',    [MetaTraderController::class, 'openBuy']);
//     Route::get('/open-sell',   [MetaTraderController::class, 'openSell']);
//     Route::get('/balance',     [MetaTraderController::class, 'getBalance']);

// });














Route::controller(GoldPriceController::class)->prefix("trading")->group(function () {
    Route::get("index","index")->name("gold-price.index");
});
Route::post('/api/update-prices', [GoldPriceController::class, 'updatePrices'])->name('gold-price.update');
