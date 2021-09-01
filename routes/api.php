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
// Authentication routes
Route::post('login', 'AuthController@login');


Route::middleware('auth:api')
->get('/user', function(Request $request) {    
return $request->user();
});



Route::get('lead/generateQuotes/{id}', 'ProjectController@generateQuotes');


Route::group(
    [
        'middleware' => [],
    ],
    function () {
        
        // Leads
        

        Route::post('lead/create-lead', 'CustomerController@create');
        
        Route::post('lead/update-status/{id}', 'ProjectController@updateStatus');

        Route::post('lead/update_follow_up_date/{id}', 'ProjectController@update_follow_up_date');
        
        Route::get('lead/fetchAllLead', 'CustomerController@fetchAllLead');

        
        
        Route::get('user/getAllUser', 'UserController@index');
        
        Route::get('events/getAllEvents', 'EventMasterController@index');

        Route::post('logout', 'AuthController@logout');

        Route::get('lead/remainder', 'ProjectController@getAllRemainders');

        Route::post('lead/update/{id}', 'CustomerController@update');

        Route::get('lead/edit/{id}', 'CustomerController@show');

        Route::get('communication/{id}', 'CommunicationController@show');

        Route::post('communication/{id}', 'CommunicationController@update');

        
    }
);
Route::get('services/getAllServices', 'ServicesMasterController@index');

Route::post('lead_dashboard', 'DashboardController@lead_dashboard');

Route::get('project/fetchAllProject', 'CustomerController@fetchAllProject');
Route::post('employee/setDate', 'EmployeeController@setUnavailable');
Route::get('employee/getThisMonth', 'EmployeeController@getThisMonthNotAvailableDate');
Route::post('employee/assingEmp', 'EmployeeController@assignEmpService');
Route::post('/updatePayment', 'QuoteController@updatePayment');
Route::post('/startEndTimer', 'TaskTimeTackerController@startEndTimer');
Route::get('task/fetchEmployeeTask', 'TaskTimeTackerController@fetchEmployeeTask');

Route::get('task/fetchEachEmployeeTask', 'EmployeeController@fetchEachEmployeeTask');

Route::get('project/edit/{id}', 'ProjectController@show');

