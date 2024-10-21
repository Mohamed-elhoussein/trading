<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BanksController;
use App\Http\Controllers\Admin\CountryController ;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProgramsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CurranciesController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\PeriodGlobalController;
use App\Http\Controllers\Admin\InterestCalcsController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
        Route::prefix('/dashboard')->group(function(){
        Route::get('/',[DashboardController::class,'index'])->name('dashboard.index');



        Route::prefix('period/global')->group(function(){
            Route::get('/index',[PeriodGlobalController::class,'index'])->name('period.global.index');
            Route::get('/dataTable',[PeriodGlobalController::class,'getData'])->name('period.global.dataTable');
            Route::get('/create',[PeriodGlobalController::class,'create'])->name('period.global.create');
            Route::post('/store',[PeriodGlobalController::class,'store'])->name('period.global.store');
            Route::get('/edit/{PeroidGlobel}',[PeriodGlobalController::class,'edit'])->name('period.global.edit');
            Route::post('/update',[PeriodGlobalController::class,'update'])->name('period.global.update');
            Route::get('/archive/{PeroidGlobel}',[PeriodGlobalController::class,'archive'])->name('period.global.archive');
            Route::get('/archiveList',[PeriodGlobalController::class,'archiveList'])->name('period.global.archived');
            Route::get('/getArchived',[PeriodGlobalController::class,'getArchived'])->name('period.global.archivedData');
            Route::get('/restore/{id}',[PeriodGlobalController::class,'restore'])->name('period.global.restore');
        });
        Route::prefix('interest/calculator')->group(function(){
            Route::get('/index',[InterestCalcsController::class,'index'])->name('interest.calculator.index');
            Route::get('/dataTable',[InterestCalcsController::class,'getData'])->name('interest.calculator.dataTable');
            Route::post('/store',[InterestCalcsController::class,'store'])->name('interest.calculator.store');
            Route::post('/update',[InterestCalcsController::class,'update'])->name('interest.calculator.update');
            Route::get('/delete/{InterestCalc}',[InterestCalcsController::class,'delete'])->name('interest.calculator.delete');
        });

        Route::prefix('programs')->group(function(){
            ////////types start
            Route::prefix('types')->group(function(){
                Route::get('/list',[ProgramsController::class,'types_index'])->name('programs.types.index');
                Route::get('/dataTable',[ProgramsController::class,'types_getData'])->name('programs.types.dataTable');
                Route::post('/store',[ProgramsController::class,'types_store'])->name('programs.types.store');
                Route::post('/update',[ProgramsController::class,'types_update'])->name('programs.types.update');
                Route::get('/delete/{ProgramTypes}',[ProgramsController::class,'types_delete'])->name('programs.types.delete');
            });

            ////types end
                  ////////fields start
                  Route::prefix('fields')->group(function(){
                    Route::get('/list',[ProgramsController::class,'fields_index'])->name('fields.index');
                    Route::get('/dataTable',[ProgramsController::class,'fields_getData'])->name('fields.dataTable');
                    Route::post('/store',[ProgramsController::class,'fields_store'])->name('fields.store');
                    Route::post('/update',[ProgramsController::class,'fields_update'])->name('fields.update');
                    Route::get('/delete/{Fields}',[ProgramsController::class,'fields_delete'])->name('fields.delete');
                });

            ////fields end

            ////start programs
            Route::get('/index',[ProgramsController::class,'index'])->name('programs.index');
            Route::get('/dataTable',[ProgramsController::class,'getData'])->name('programs.dataTable');
            Route::get('/create',[ProgramsController::class,'create'])->name('programs.create');
            Route::post('/store',[ProgramsController::class,'store'])->name('programs.store');
            Route::get('/edit/{program}',[ProgramsController::class,'edit'])->name('programs.edit');
            Route::post('/update',[ProgramsController::class,'update'])->name('programs.update');
            Route::get('/archive/{program}',[ProgramsController::class,'archive'])->name('programs.archive');
            Route::get('/archiveList',[ProgramsController::class,'archiveList'])->name('programs.archived');
            Route::get('/getArchived',[ProgramsController::class,'getArchived'])->name('programs.archivedData');
            Route::get('/restore/{id}',[ProgramsController::class,'restore'])->name('programs.restore');

            ////program period start
            Route::get('/periods/list/{program}',[ProgramsController::class,'period_list'])->name('period.list');
            Route::get('/periods/dataTable/{id}',[ProgramsController::class,'period_getData'])->name('period.dataTable');
            Route::post('/period/store',[ProgramsController::class,'period_store'])->name('period.store');
            Route::post('/period/update',[ProgramsController::class,'period_update'])->name('period.update');
            Route::get('/delete/{Program_period}',[ProgramsController::class,'period_delete'])->name('period.delete');

            //// program period end
            //// contract start
            Route::get('/contract/list/{program}',[ProgramsController::class,'contract_list'])->name('contract.list');
            Route::get('/contract/dataTable/{id}',[ProgramsController::class,'contract_getData'])->name('contract.dataTable');
            Route::post('/contract/store',[ProgramsController::class,'contract_store'])->name('contract.store');
            Route::post('/contract/update',[ProgramsController::class,'contract_update'])->name('contract.update');
            Route::get('/contract/delete/{ContractProgram}',[ProgramsController::class,'contract_delete'])->name('contract.delete');




            //// contract end


            //end programs


        });
        Route::prefix('currency')->group(function(){
            Route::get('/list',[CurranciesController::class,'index'])->name('currency.index');
            Route::get('/dataTable',[CurranciesController::class,'getData'])->name('currency.dataTable');
            Route::post('/store',[CurranciesController::class,'store'])->name('currency.store');
            Route::post('/update',[CurranciesController::class,'update'])->name('currency.update');
            Route::get('/delete/{currency}',[CurranciesController::class,'delete'])->name('currency.delete');
            Route::put('/status/change', [CurranciesController::class, 'status'])->name('currency.status');

        });
        Route::prefix('country')->group(function(){
            Route::get('/list',[CountryController::class,'index'])->name('country.index');
            Route::get('/dataTable',[CountryController::class,'getData'])->name('country.dataTable');
            Route::post('/store',[CountryController::class,'store'])->name('country.store');
            Route::post('/update',[CountryController::class,'update'])->name('country.update');
            Route::get('/delete/{country}',[CountryController::class,'delete'])->name('country.delete');
            Route::put('/status/change', [CountryController::class, 'status'])->name('country.status');

        });

        Route::prefix('order/status')->group(function(){
            Route::get('/list',[OrderStatusController::class,'index'])->name('order.status.index');
            Route::get('/dataTable',[OrderStatusController::class,'getData'])->name('order.status.dataTable');
            Route::post('/store',[OrderStatusController::class,'store'])->name('order.status.store');
            Route::post('/update',[OrderStatusController::class,'update'])->name('order.status.update');
            Route::get('/delete/{orderStatu}',[OrderStatusController::class,'delete'])->name('order.status.delete');
        });


        Route::prefix('orders')->group(function(){
            Route::get('/list',[OrdersController::class,'index'])->name('orders.index');
            Route::get('/dataTable/{id?}',[OrdersController::class,'getData'])->name('order.dataTable');
            Route::get('/details/{id}', [OrdersController::class, 'order_details'])->name('order.details');
            Route::post('/change/status/order/{id}',[OrdersController::class, 'order_status'])->name('order.status');
            Route::get('/month/installment',[OrdersController::class,'installment'])->name('get.month.installment');
            Route::get('/month/installmen/datatable',[OrdersController::class,'installment_datatable'])->name('get.month.installment.datatable');
            Route::get('/month/installmen/status/{id}',[OrdersController::class,'installment_status'])->name('get.month.installment.status');
            Route::get('/installmen/History',[OrdersController::class,'installment_history'])->name('get.installment.history');
            Route::get('/installmen/History/datatable',[OrdersController::class,'installment_history_datatable'])->name('get.installment.datatable.history');

        });
        Route::prefix('Customer')->group(function(){
            Route::get('/list',[CustomerController::class,'index'])->name('customer.index');
            Route::get('/dataTable/{id?}',[CustomerController::class,'getData'])->name('customer.dataTable');
            Route::get('/is_verified/{id}', [CustomerController::class, 'is_verified'])->name('customer.is_verified');
            Route::get('/is_approve_id/{id}', [CustomerController::class, 'is_approve_id'])->name('customer.is_approve_id');

        });

        Route::prefix('User')->group(function(){
            Route::get('/list',[UsersController::class,'index'])->name('user.index');
            Route::get('/dataTable/{id?}',[UsersController::class,'getData'])->name('user.dataTable');
            Route::put('/status/change', [UsersController::class, 'status'])->name('user.status');
            Route::post('/store',[UsersController::class,'store'])->name('user.store');
            Route::post('/update',[UsersController::class,'update'])->name('user.update');

        });



        });

    });
