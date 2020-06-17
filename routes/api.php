<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('Web')->middleware(['checkIp'])
    ->name('api.get.markdown')
    ->get('documentation/get', 'Web\ApiDocController@get');

// Authentication
Route::namespace('Api')->middleware(['checkIp'])->group(function() {
    //** Auth routes
    Route::prefix('auth')->namespace('Auth')->group(function() {
        Route::name('login')->post('login', 'AuthController@login');
        Route::name('register')->post('register', 'AuthController@register');

        Route::prefix('reset/password')->group(function() {
            Route::name('reset.password.send')->post('send', 'PasswordController@sendResetPassword');
            Route::name('reset.password.form')->get('{token}/form', 'PasswordController@resetPasswordForm');
            Route::name('reset.password')->post('', 'PasswordController@resetPassword');
        });

    });

    /**
     * Authenticated Users Routes
     */
    Route::middleware('auth:api')->group(function() {

        /**
         * User routes
         */
        Route::prefix('user')->namespace('User')->group(function() {
            Route::name('api.user.me')->get('me', 'IndexController@index');

            //** Announcement
            Route::prefix('announcement')->group(function() {
                Route::name('api.user.announcements.unread')->get('unread', 'NotificationController@announcementUnread');
                Route::name('api.user.announcements.all')->get('all', 'NotificationController@getAllNotifications');
                Route::name('api.user.announcements.update.read')->post('update/read', 'NotificationController@updateRead');
            });
        });

        /**
         * Client routes
         */
        Route::prefix('client')->namespace('Client')->middleware(['clientOrStaff'])->group(function() {

            //** Client dashboard
            Route::prefix('dashboard')->group(function() {
                Route::name('api.client.dashboard.batches_draft')->get('batches/draft', 'IndexController@batchDraft');
                Route::name('api.client.dashboard.batches_confirmed')->get('batches/confirmed', 'IndexController@batchConfirmed');
            });

            /**
             * Batch routes
             */
            Route::prefix('batch')->namespace('Batch')->group(function() {
                Route::name('api.client.batch')->get('', 'BatchController@index');
                Route::name('api.client.batch.store')->post('store', 'BatchController@store');
                Route::name('api.client.batch.update')->post('{id}/update', 'BatchController@update');
                Route::name('api.client.batch.destroy')->post('{id}/destroy', 'BatchController@destroy');
                Route::name('api.client.batch.search')->get('search/{key}', 'BatchController@search');
                Route::name('api.client.batch.details')->get('{id}/details', 'BatchController@details');
                Route::name('api.client.batch.done')->post('{id}/done', 'BatchController@setToDone');
                Route::name('api.client.batch.confirmed')->post('{id}/confirmed', 'BatchController@setToConfirmed');
                Route::name('api.client.batch.pdf')->get('{id}/pdf', 'BatchController@viewPdf');

                Route::prefix('order')->group(function() {
                    Route::name('api.client.batch.order')->get('{id}', 'BatchOrderController@index');
                    Route::name('api.client.batch.order.details')->get('{id}/details', 'BatchOrderController@details');
                    Route::name('api.client.batch.order.store')->post('store', 'BatchOrderController@store');
                    Route::name('api.client.batch.order.update')->post('{id}/update', 'BatchOrderController@update');
                    Route::name('api.client.batch.order.update.status')->post('{id}/update/status', 'BatchOrderController@updateStatus');
                    Route::name('api.client.batch.order.destroy')->post('{id}/destroy', 'BatchOrderController@destroy');
                });
            });

            // Client staff routes
            Route::prefix('staff')->middleware('client')->group(function() {
                Route::name('api.client.staff')->get('', 'StaffController@index');
                Route::name('api.client.staff.details')->get('{id}/details', 'StaffController@details');
                Route::name('api.client.staff.store')->post('store', 'StaffController@store');
                Route::name('api.client.staff.update')->post('{id}/update', 'StaffController@update');
                Route::name('api.client.staff.archive')->post('{id}/archive', 'StaffController@archive');
                Route::name('api.client.staff.search')->get('search/{key}', 'StaffController@search');
            });

            // Client Patient routes
            Route::prefix('patient')->group(function() {
                Route::name('api.client.patient')->get('', 'PatientController@index');
                Route::name('api.client.patient.details')->get('{id}/details', 'PatientController@details');
                Route::name('api.client.patient.store')->post('store', 'PatientController@store');
                Route::name('api.client.patient.update')->post('{id}/update', 'PatientController@update');
                Route::name('api.client.patient.search')->get('search/{key}', 'PatientController@search');
                Route::name('api.client.patient.archive')->post('{id}/archive', 'PatientController@archive');
            });

            // CLient settings
            Route::prefix('settings')->group(function() {

                // Client profile
                Route::prefix('profile')->group(function() {
                    Route::name('api.client.settings.profile')->get('', 'SettingsController@index');
                    Route::name('api.client.settings.update.profile')->post('update', 'SettingsController@updateDetails');
                    Route::name('api.client.settings.update.password')->post('password/update', 'SettingsController@updatePassword');
                });

                // Client clinician
                Route::prefix('clinician')->group(function() {
                    Route::name('api.client.settings.clinician')->get('', 'ClinicianController@index');
                    Route::name('api.client.settings.clinician.store')->post('store', 'ClinicianController@store');
                    Route::name('api.client.settings.clinician.update')->post('{id}/update', 'ClinicianController@update');
                    Route::name('api.client.settings.clinician.destroy')->post('{id}/destroy', 'ClinicianController@destroy');
                });
            });

            /**
             * Client other data
             */
            Route::name('api.client.sources')->get('sources', 'IndexController@sources');
            Route::name('api.client.patient_types')->get('patient-types', 'IndexController@patientTypes');
            Route::name('api.client.dispatchers')->get('dispatchers', 'IndexController@dispatchers');
            Route::name('api.client.services')->get('services', 'IndexController@services');

        });
        //** END of client routes

        /**
         * Admin Routes
         */
        Route::prefix('admin')
            ->middleware('admin')
            ->namespace('Admin')->group(function() {

            //** Dashboard
            Route::prefix('dashboard')->group(function() {
                Route::name('api.admin.dashboard.batches_draft')->get('batches/draft', 'IndexController@batchDraft');
                Route::name('api.admin.dashboard.batches_confirmed')->get('batches/confirmed', 'IndexController@batchConfirmed');
            });

            //** Notification
            Route::prefix('announcement')->namespace('Announcement')->group(function() {
                Route::name('api.admin.announcement')->get('', 'IndexController@index');
                Route::name('api.admin.announcement.store')->post('store', 'IndexController@store');
                Route::name('api.admin.announcement.update')->post('{batch_id}/update', 'IndexController@update');
                Route::name('api.admin.announcement.destroy')->post('{batch_id}/destroy', 'IndexController@destroy');
            });

            // Admin manage batch
            Route::prefix('batch')->namespace('Batch')->group(function() {
                Route::name('api.admin.batch')->get('', 'IndexController@index');
                Route::name('api.admin.batch.set.status')->post('{id}/done', 'IndexController@setToDone');
                Route::name('api.admin.batch.pdf')->get('{id}/pdf', 'IndexController@viewPdf');
            });

            // Admin Client
            Route::prefix('client')->namespace('Client')->group(function() {
                Route::name('api.admin.client')->get('', 'IndexController@index');
                Route::name('api.admin.client.store')->post('store', 'IndexController@store');
                Route::name('api.admin.client.update')->post('{id}/update', 'IndexController@update');
                Route::name('api.admin.client.destroy')->post('{id}/destroy', 'IndexController@destroy');
                Route::name('api.admin.client.search')->get('search/{key}', 'IndexController@search');

                //** Admin Manage individual `clients`
                Route::name('api.admin.client.details')->get('details/{code}', 'IndexController@details');
                Route::name('api.admin.client.update.payment_mode')->post('payment_mode/{code}/update', 'IndexController@updatePaymentMode');
                Route::name('api.admin.client.update.dispatcher')->post('dispatcher/{code}/update', 'IndexController@updateDispatcher');

                //** Admin Manage client sources
                Route::prefix('{id}/sources')->group(function() {
                    Route::name('api.admin.client.sources')->get('', 'SourcesController@index');
                    Route::name('api.admin.client.sources.store')->post('store', 'SourcesController@store');
                    Route::name('api.admin.client.sources.destroy')->post('{sourceId}/destroy', 'SourcesController@destroy');
                });

                //** Admin Manage client services
                Route::prefix('{id}/{sourceId}/services')->group(function() {
                    Route::name('api.admin.client.services')->get('', 'ServicesController@index');
                    Route::name('api.admin.client.services.store')->post('store', 'ServicesController@store');
                    Route::name('api.admin.client.services.update')->post('{serviceId}/update', 'ServicesController@update');
                    Route::name('api.admin.client.services.destroy')->post('{serviceId}/destroy', 'ServicesController@destroy');
                    Route::name('api.admin.client.services.import')->post('import', 'ServicesController@import');
                });
            });

            // Admin Manage Processor
            Route::prefix('processor')->group(function() {
                Route::name('api.admin.processor')->get('', 'ProcessorController@index');
                Route::name('api.admin.processor.search')->get('search/{key}', 'ProcessorController@search');
                Route::name('api.admin.processor.store')->post('store', 'ProcessorController@store');
                Route::name('api.admin.processor.update')->post('{id}/update', 'ProcessorController@update');
                Route::name('api.admin.processor.destroy')->post('{id}/destroy', 'ProcessorController@destroy');
            });

            // Admin Manage Services
            Route::prefix('services')->namespace('Service')->group(function() {
                Route::name('api.admin.services')->get('', 'IndexController@index');
                Route::name('api.admin.services.search')->get('search/{key}', 'IndexController@search');
                Route::name('api.admin.services.store')->post('store', 'IndexController@store');
                Route::name('api.admin.services.update')->post('{id}/update', 'IndexController@update');
                Route::name('api.admin.services.destroy')->post('{id}/destroy', 'IndexController@destroy');
                Route::name('api.admin.service.details')->get('details/{code}', 'IndexController@details');
                Route::name('api.admin.service.import')->post('import', 'IndexController@import');

                // Admin Manage Client servies routes
                Route::prefix('client')->group(function() {
                    Route::name('api.admin.service.client')->get('{id}', 'ClientController@index');
                    Route::name('api.admin.service.client.store')->post('store', 'ClientController@store');
                    Route::name('api.admin.service.client.update')->post('{id}/update', 'ClientController@update');
                    Route::name('api.admin.service.client.destroy')->post('{id}/destroy', 'ClientController@destroy');
                    Route::name('api.admin.service.client.archive')->post('{serviceId}/archive/{userId}', 'ClientController@archive');
                    Route::name('api.admin.service.client.update.price')->post('update/price', 'ClientController@updatePrice');
                });

            });

            // Admin Manage System
            Route::prefix('system')->namespace('System')->group(function() {

                // Admin manage `global_prefix`
                Route::prefix('global-prefix')->group(function() {
                    Route::name('api.admin.system.global_prefix')->get('', 'GlobalPrefixController@index');
                    Route::name('api.admin.system.global_prefix.update')->post('update', 'GlobalPrefixController@update');
                });

                // Admin Manage Source
                Route::prefix('source')->group(function() {
                    Route::name('api.admin.system.source')->get('', 'SourceController@index');
                    Route::name('api.admin.system.source.filter')->get('{id}/filter', 'SourceController@getClientSources');
                    Route::name('api.admin.system.source.search')->get('search/{key}', 'SourceController@search');
                    Route::name('api.admin.system.source.store')->post('store', 'SourceController@store');
                    Route::name('api.admin.system.source.update')->post('{id}/update', 'SourceController@update');
                    Route::name('api.admin.system.source.destroy')->post('{id}/destroy', 'SourceController@destroy');
                });

                // Admin Manage Dispatchers
                Route::prefix('dispatcher')->group(function() {
                    Route::name('api.admin.system.dispatcher')->get('', 'DispatcherController@index');
                    Route::name('api.admin.system.dispatcher.store')->post('store', 'DispatcherController@store');
                    Route::name('api.admin.system.dispatcher.update')->post('{id}/update', 'DispatcherController@update');
                    Route::name('api.admin.system.dispatcher.destroy')->post('{id}/destroy', 'DispatcherController@destroy');
                });

                // Admin Manage PatientType
                Route::prefix('patient-type')->group(function() {
                    Route::name('api.admin.system.patient_type')->get('', 'PatientTypeController@index');
                    Route::name('api.admin.system.patient_type.store')->post('store', 'PatientTypeController@store');
                    Route::name('api.admin.system.patient_type.update')->post('{id}/update', 'PatientTypeController@update');
                    Route::name('api.admin.system.patient_type.destroy')->post('{id}/destroy', 'PatientTypeController@destroy');
                });

                // Admin Manage WhitelistIps
                Route::prefix('white-listed-ip')->group(function() {
                    Route::name('api.admin.system.white_listed_ip')->get('', 'WhiteListedIpController@index');
                    Route::name('api.admin.system.white_listed_ip.store')->post('store', 'WhiteListedIpController@store');
                    Route::name('api.admin.system.white_listed_ip.update')->post('{id}/update', 'WhiteListedIpController@update');
                    Route::name('api.admin.system.white_listed_ip.destroy')->post('{id}/destroy', 'WhiteListedIpController@destroy');
                });
            });
        });

        Route::name('api.user.token')->get('auth/user/token', 'Auth\AuthController@userToken');
    });

});
