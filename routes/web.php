<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return \view('home');
})->name('home');

Route::get('/failure', function () {
    return \view('failure');
})->name('failure');

Route::post('/payment/pay', 'PaymentController@makePayment')->name('payment');

Route::get('/payment/execute/{email}/{nickname}', 'PaymentExecutionController@executePayment')->name('paymentExecution');

Route::get('/paid_conference/create/{email}/{nickname}/{paymentId}', 'PaidConferenceController@createPaidConference')->name('paidConferenceCreation');
