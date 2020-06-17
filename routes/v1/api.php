<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes for V1
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication
Route::namespace('ApiLegacy')->middleware(['checkIp'])->group(function() {

    //** Auth routes
    Route::namespace('Auth')->group(function() {
        Route::name('api.legacy.login')->post('oauth/access-token', 'AuthController@login');
    });

    /**
     * Admin Routes
     */
    Route::middleware('admin')
        ->namespace('Admin')->group(function() {

        // Admin Client
        Route::prefix('clients')->group(function() {
            Route::name('api.legacy.admin.client')->get('', 'ClientController@index');
            Route::name('api.legacy.admin.client.search')->get('search', 'ClientController@search');
            Route::name('api.legacy.admin.client.destroy')->delete('{id}', 'ClientController@destroy');
        });

        // Admin patient
        Route::name('api.legacy.admin.patients')->get('patients', 'PatientController@index');

        // Admin batch
        Route::prefix('batches')->group(function () {
            Route::name('api.legacy.admin.batches')->get('', 'BatchController@index');
            Route::name('api.legacy.admin.batches.details')->get('{batchId}', 'BatchController@details');
            Route::name('api.legacy.admin.batches.update')->post('{batchId}', 'BatchController@update');
            Route::name('api.legacy.admin.batches.destroy')->delete('{batchId}', 'BatchController@destroy');
            Route::name('api.legacy.admin.batches.report.post')->post('{batchId}/reports', 'BatchController@details');
        });

        //** Transactions / BatchOrder
        Route::name('api.legacy.admin.transactions')->get('transactions/{transactionId}', 'BatchOrderController@index');
        Route::name('api.legacy.admin.transactions.update')->post('transactions/{transactionId}/status', 'BatchOrderController@update');

        //** White list
        Route::name('api.legacy.admin.white.list')->get('white-list/ips', 'WhiteListedIpController@index');
        Route::name('api.legacy.admin.white.list.post')->post('white-list/ips', 'WhiteListedIpController@store');
        Route::name('api.legacy.admin.white.list.destroy')->delete('white-list/ips/{whiteListId}', 'WhiteListedIpController@destroy');

        //** Services
        Route::name('api.legacy.admin.services.post')->post('service/prices', 'ServicesController@store');

    });

    /**
     * Authenticated Users Routes
     */
    Route::middleware('auth:api')
        ->namespace('Client')
        ->group(function() {

            /**
             * Client routes
             */
            Route::prefix('clients/{clientId}')
                ->group(function() {

                // Client Patient routes
                Route::prefix('patients')->group(function() {
                    Route::name('api.legacy.client.patient')->get('', 'PatientController@index');
                    Route::name('api.legacy.client.patient.search')->get('search', 'PatientController@search');
                });

                Route::name('api.legacy.client.batches.search')->get('batches/search', 'BatchController@search');
            });

            Route::name('api.legacy.client.patient.store')->post('patients', 'PatientController@store');
            Route::name('api.legacy.client.patient.update')->post('patients/{patientId}', 'PatientController@update');
            Route::name('api.legacy.client.patient.destroy')->delete('patients/{patientId}', 'PatientController@destroy');

            // Orders
            Route::name('api.legacy.client.orders.store')->post('orders', 'BatchOrderController@store');
            Route::name('api.legacy.client.orders.cancel')->put('orders/{orderId}/cancel', 'BatchOrderController@cancel');
            Route::name('api.legacy.client.orders.post')->put('orders/{orderId}/post', 'BatchOrderController@post');
            Route::name('api.legacy.client.orders.destroy')->delete('orders/{orderId}', 'BatchOrderController@destroy');

            //** END of client routes
    });

});
