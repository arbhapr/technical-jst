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

use App\Http\Controllers\EmployeeController;

Route::redirect('/', '/employees', 301);
// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/employees/jsonProvinces', 'EmployeeController@jsonProvinces');
    Route::get('/employees/jsonRegencies', 'EmployeeController@jsonRegencies');
    Route::get('/employees/jsonEmployee', 'EmployeeController@jsonEmployee');
    Route::resource('/employees', 'EmployeeController');
    Route::get('/home', 'HomeController@index')->name('home');
});
