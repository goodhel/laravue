<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'auth:api'], function() {
    //Outlet
    Route::resource('/outlets', 'API\OutletController')->except(['show']);

    //Courier
    Route::resource('/couriers', 'API\UserController')->except(['create', 'show', 'update']);
    Route::post('/couriers/{id}', 'API\UserController@update')->name('couriers.update');

    //Product
    Route::resource('product', 'API\ProductController')->except(['create', 'show']);
    Route::get('/product/laundry-type', 'API\ProductController@getLaundryType');
    Route::post('/product/laundry-type', 'API\ProductController@storeLaundryType');

    //Role-permission
    Route::get('roles', 'API\RolePermissionController@getAllRole')->name('roles');
    Route::get('permissions', 'API\RolePermissionController@getAllPermission')->name('permission');
    Route::post('role-permission', 'API\RolePermissionController@getRolePermission')->name('role_permission');
    Route::post('set-role-permission', 'API\RolePermissionController@setRolePermission')->name('set_role_permission');
    Route::post('set-role-user', 'API\RolePermissionController@setRoleUser')->name('user.set_role');
    Route::get('user-authenticated', 'API\UserController@getUserLogin')->name('user.authenticated');
    Route::get('user-lists', 'API\UserController@userLists')->name('user.index');

    //Expense
    Route::resource('expenses', 'API\ExpensesController')->except(['create', 'show']);
    Route::post('expenses/accept', 'API\ExpensesController@accept')->name('expenses.accept');
    Route::post('expenses/cancel', 'API\ExpensesController@cancelRequest')->name('expenses.cancel');

    //Notification
    Route::resource('notification', 'API\NotificationController')->except(['create', 'destroy']);

    //Customer
    Route::resource('customer', 'API\CustomerController')->except(['create', 'show']);
    //Transaction
    Route::resource('transaction', 'API\TransactionController')->except(['create', 'show']);
    Route::post('transaction/complete-item', 'API\TransactionController@completeItem');
    Route::post('transaction/payment', 'API\TransactionController@makePayment');
    //Dashboard
    Route::get('chart', 'API\DashboardController@chart');
    Route::get('export', 'API\DashboardController@exportData');
});

Route::post('/login', 'Auth\LoginController@login');
