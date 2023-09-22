<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/',[\App\Http\Controllers\labours\LabourController::class,'index'])->name('labours');
Route::get('labours',[\App\Http\Controllers\labours\LabourController::class,'index'])->name('labour.index');

Route::get('labour/form-add',[\App\Http\Controllers\labours\LabourController::class,'create'])->name('labour.create');
Route::post('labour/store',[\App\Http\Controllers\labours\LabourController::class,'store'])->name('labour.store');
Route::get('labour/edit/{labourModel}',[\App\Http\Controllers\labours\LabourController::class,'edit'])->name('labour.edit');
Route::put('labour/update/{labourModel}',[\App\Http\Controllers\labours\LabourController::class,'update'])->name('labour.update');

//Address Select
Route::get('/address/select/provinces', [App\Http\Controllers\AddressSelect\AddressSelectController::class, 'provinces'])->name('address.provinces');
Route::get('/address/select/amphures',  [App\Http\Controllers\AddressSelect\AddressSelectController::class, 'amphures'])->name('address.amphures');
Route::get('/address/select/districts', [App\Http\Controllers\AddressSelect\AddressSelectController::class, 'districts'])->name('address.districts');

//Address Show
Route::get('address/show',[\App\Http\Controllers\AddressShow\AddressShowController::class,'address'])->name('address.show');


// Report All
Route::get('labour/report/form/all',[\App\Http\Controllers\report\ReportLabourAllCOntroller::class,'index'])->name('report.reportAll');

//Export
Route::post('labour/report/excel/labour/all',[\App\Http\Controllers\report\ReportLabourAllCOntroller::class,'exportLabours'])->name('reportLabour.exportLabours');

// Import Group
Route::get('importgroup/',[\App\Http\Controllers\importGroup\importGroupController::class,'index'])->name('importgroup.index');
Route::get('importgroup/modal/add',[\App\Http\Controllers\importGroup\importGroupController::class,'modalAdd'])->name('importgroup.modalAdd');
Route::post('importgroup/modal/store',[\App\Http\Controllers\importGroup\importGroupController::class,'modalStore'])->name('importgroup.modalStore');
