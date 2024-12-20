<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Imports\labours\LabourCustomImport;
use App\Http\Controllers\report\ReportExpireController;
use App\Http\Controllers\dashboards\dashboardController;
use App\Http\Controllers\checkAddress\checkAddressController;
use App\Http\Controllers\ExpireController;
use App\Http\Controllers\import_custom\createFormImportController;
use App\Http\Controllers\file_import_excel\ImportLabourCustomController;
use App\Http\Controllers\TotalLabourController;

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
Auth::routes();

// Route::get('/', function () {
//     return view('welcome');
// });
// Auth::routes();


// Dashboard::
Route::get('/',[dashboardController::class,'index'])->name('/');
Route::get('/dashboard/Modalshow/passport/{company}',[dashboardController::class,'ModalshowPassport'])->name('dashboard.Modalshow.passport');
Route::get('/dashboard/Modalshow/visa/{company}',[dashboardController::class,'ModalshowVisa'])->name('dashboard.Modalshow.visa');
Route::get('/dashboard/Modalshow/work/{company}',[dashboardController::class,'ModalshowWork'])->name('dashboard.Modalshow.work');
Route::get('/dashboard/Modalshow/ninety/{company}',[dashboardController::class,'ModalshowNinety'])->name('dashboard.Modalshow.ninety');
Route::get('/dashboard/alert/notify',[dashboardController::class,'alertNotifyAction'])->name('dashboard.alertNotifyAction');



Route::get('/home',[\App\Http\Controllers\labours\LabourController::class,'index'])->name('home');

Route::get('labours',[\App\Http\Controllers\labours\LabourController::class,'index'])->name('labour.index');

Route::get('labour/form-add',[\App\Http\Controllers\labours\LabourController::class,'create'])->name('labour.create');
Route::post('labour/store',[\App\Http\Controllers\labours\LabourController::class,'store'])->name('labour.store');
Route::get('labour/edit/{labourModel}',[\App\Http\Controllers\labours\LabourController::class,'edit'])->name('labour.edit');
Route::put('labour/update/{labourModel}',[\App\Http\Controllers\labours\LabourController::class,'update'])->name('labour.update');

//Address Select

Route::get('/address/select/provinces',[\App\Http\Controllers\AddressSelect\AddressSelectController::class, 'provinces'])->name('address.provinces');
Route::get('/address/select/amphures',  [\App\Http\Controllers\AddressSelect\AddressSelectController::class, 'amphures'])->name('address.amphures');
Route::get('/address/select/districts', [\App\Http\Controllers\AddressSelect\AddressSelectController::class, 'districts'])->name('address.districts');


//Address Show
Route::get('address/show',[\App\Http\Controllers\AddressShow\AddressShowController::class,'address'])->name('address.show');


// Report All Controller
Route::get('labour/report/form/all',[\App\Http\Controllers\report\ReportLabourAllCOntroller::class,'index'])->name('report.reportAll');
//Export 
Route::post('labour/report/excel/labour/all',[\App\Http\Controllers\report\ReportLabourAllCOntroller::class,'exportLabours'])->name('reportLabour.exportLabours');

// Report CPF
Route::get('labour/report/cpf',[\App\Http\Controllers\report\ReportLabourCpfController::class,'index'])->name('report.cpf');
//Export
Route::post('labour/report/cpf/excel',[\App\Http\Controllers\report\ReportLabourCpfController::class,'exportCPF01'])->name('report.exportCPF01');



// Import Group
Route::get('importgroup/',[\App\Http\Controllers\importGroup\importGroupController::class,'index'])->name('importgroup.index');
Route::get('importgroup/edit/{importGroupModel}',[\App\Http\Controllers\importGroup\importGroupController::class,'edit'])->name('importgroup.edit');
Route::put('importgroup/update/{importGroupModel}',[\App\Http\Controllers\importGroup\importGroupController::class,'update'])->name('importgroup.update');
Route::get('importgroup/delete/{importGroupModel}',[\App\Http\Controllers\importGroup\importGroupController::class,'destroy'])->name('importgroup.delete');
Route::get('importgroup/modal/add',[\App\Http\Controllers\importGroup\importGroupController::class,'modalAdd'])->name('importgroup.modalAdd');
Route::post('importgroup/modal/store',[\App\Http\Controllers\importGroup\importGroupController::class,'modalStore'])->name('importgroup.modalStore');

//Excel import Labour

Route::get('import/excel/labour',[\App\Http\Controllers\file_import_excel\labourImportExcel::class,'index'])->name('excelImport.labour');
Route::get('import/excel/check',[\App\Http\Controllers\file_import_excel\labourImportExcel::class,'checkLabour'])->name('excelImport.checkLabour');
Route::post('import/excel/import',[\App\Http\Controllers\file_import_excel\labourImportExcel::class,'import'])->name('excelImport.import');
//excel import department employeeID
Route::get('import/excel/department/employee/id',[\App\Http\Controllers\file_import_excel\labourDepartmantEmployeeIDExcel::class,'index'])->name('department.employee.id');;
Route::post('import/excel/department/employee/id/import',[\App\Http\Controllers\file_import_excel\labourDepartmantEmployeeIDExcel::class,'import'])->name('import.department.employee.id');
Route::post('import/excel/department/employee/update', [\App\Http\Controllers\file_import_excel\labourDepartmantEmployeeIDExcel::class, 'update'])->name('import.department.employee.update');

//Update 90 Day
Route::get('import/upadte90day/form',[\App\Http\Controllers\file_import_excel\update90dayExcel::class,'index'])->name('import.update90day'); 
Route::post('import/upadte90day/import',[\App\Http\Controllers\file_import_excel\update90dayExcel::class,'import'])->name('import.update90day.import'); 
Route::post('import/upadte90day/update90day',[\App\Http\Controllers\file_import_excel\update90dayExcel::class,'update90day'])->name('import.update90day.update90day'); 

//Address Labour
Route::get('import/address/labour/form',[\App\Http\Controllers\file_import_excel\AddressLabourExcel::class,'index'])->name('addressLabour.index');
Route::post('import/address/labour/import',[\App\Http\Controllers\file_import_excel\AddressLabourExcel::class,'import'])->name('addressLabour.import');
Route::post('import/address/labour/store',[\App\Http\Controllers\file_import_excel\AddressLabourExcel::class,'store'])->name('addressLabour.store');

//Customer
Route::get('customer',[\App\Http\Controllers\customer\CustomerController::class,'index'])->name('customer.index');
Route::get('customer/form',[\App\Http\Controllers\customer\CustomerController::class,'create'])->name('customer.create');
Route::post('customer/form/store',[\App\Http\Controllers\customer\CustomerController::class,'store'])->name('customer.store');
Route::get('customer/form/edit/{customer}',[\App\Http\Controllers\customer\CustomerController::class,'edit'])->name('customer.edit');
Route::get('customer/show/edit/{customer}',[\App\Http\Controllers\customer\CustomerController::class,'show'])->name('customer.show');
Route::put('customer/form/update/{customer}',[\App\Http\Controllers\customer\CustomerController::class,'update'])->name('customer.update');
Route::get('customer/form/delete/{customer}',[\App\Http\Controllers\customer\CustomerController::class,'delete'])->name('customer.delete');
// Report Customer
Route::get('report/customer',[\App\Http\Controllers\report\ReportCustomerController::class, 'index'])->name('report.customer');
Route::post('report/customer/download',[\App\Http\Controllers\report\ReportCustomerController::class, 'export'])->name('report.customer.download');

//LogFIle
Route::get('logfile/labour',[\App\Http\Controllers\logfile\labourLogController::class,'index'])->name('logfile.labour');

//Check Address
Route::post('checkaddress',[checkAddressController::class,'check'])->name('checkaddress');

//Report Expire
Route::get('report/reportexpire/{expireType}/{company}',[ReportExpireController::class,'exportExpire'])->name('report.exportExpire');

//Custom Form Import
Route::get('custom//create/form',[createFormImportController::class,'index'])->name('customFormImport.index');
Route::post('custom/form/export',[createFormImportController::class,'export'])->name('customFormImport.export');

//Import File Excel 
Route::post('import/custom/file/excel',[ImportLabourCustomController::class,"import"])->name('import.customLabourExcel');
Route::get('import/custom/return/form',[ImportLabourCustomController::class,"returnForm"])->name('import.returnForm');

//Expire

Route::get('labour/expire/custom',[ExpireController::class,"index"])->name('expire.index');
 
//Total Export

Route::get('report/labour/total',[TotalLabourController::class,"index"])->name('report.total.index');
Route::get('report/labour/export',[TotalLabourController::class,"export"])->name('report.total.export');