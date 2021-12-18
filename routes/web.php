<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TxtConvertController;
use App\Http\Controllers\TradierOptionChainController;
use App\Http\Controllers\OpenStatusController;
use App\Http\Controllers\AddDataController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\ERDataController;

Route::prefix('userpage')->group(function () {
    Route::get('/', UserController::class)->middleware('checkuser')->middleware('visitor');
    Route::get('/{id}', [UserController::class, 'show'])->middleware('checkuser')->middleware('visitor');
    Route::get('/{id}/{data}', [UserController::class, 'searchField'])
        ->name('userpage.searchField')
        ->middleware('checkuser')->middleware('visitor');
});

Route::prefix('adminpage')->group(function () {
    // Route::group(['middleware' => ['checkuser', 'permission']], function() {
    //     //your restricted routes here
    //   });
    Route::get('/', AdminController::class)
        ->name('adminpage.home')
        ->middleware('checkadmin')->middleware('visitor');
    Route::get('/{id}', [AdminController::class, 'show'])
        ->name('adminpage.show')
        ->middleware('checkadmin');
    Route::get('/{id}/{data}', [AdminController::class, 'searchField'])
        ->name('adminpage.searchField')
        ->middleware('checkadmin');
    Route::get('/refresh_price/{id}/{data}', [AdminController::class, 'refreshWithPrice'])
        ->name('adminpage.refreshWithPrice')
        ->middleware('checkadmin');
    Route::get('show_adminpage/{categories}/{fields}/{select_category}', [AdminController::class, 'show_adminpage'])
        ->name('adminpage.showAdminPage')
        ->middleware('checkadmin');
    Route::post('edit_field', [AdminController::class, 'editFeild'])
        ->name('adminpage.editField')
        ->middleware('checkadmin');

    Route::post('activate_record', [AdminController::class, 'activeRecord'])
        ->name('adminpage.activeRecord')
        ->middleware('checkadmin');
    Route::post('activate_record2', [AdminController::class, 'activeRecord2'])
        ->name('adminpage.activeRecord2')
        ->middleware('checkadmin');

    Route::post('add_field', [AdminController::class, 'addField'])
        ->name('adminpage.postField')
        ->middleware('checkadmin');
    
    Route::post('add_cat', [AdminController::class, 'addCat'])
        ->name('adminpage.addCat')
        ->middleware('checkadmin');
    Route::post('delete_cat', [AdminController::class, 'deleteCat'])
        ->name('adminpage.deleteCat')
        ->middleware('checkadmin');
    Route::post('delete_field', [AdminController::class, 'deleteFeild'])
        ->name('adminpage.deleteField')
        ->middleware('checkadmin');
    Route::post('check_new_users', [AdminController::class, 'checkNewUser'])
        ->name('adminpage.checkNewUsers')
        ->middleware('checkadmin');
    Route::post('file-import', [AdminController::class, 'fileImport'])
        ->name('adminpage.file-import')
        ->middleware('checkadmin');
    
});

Route::get('file-import-export', [AdminController::class, 'fileImportExport'])
    ->name('adminpage.fileimportexport')
    ->middleware('checkuser');

Route::get('file-export/{id}/{data}', [AdminController::class, 'fileExport'])
    ->name('adminpage.file-export')
    ->middleware('checkuser');
Route::get('file-export-pdf/{id}/{data}', [AdminController::class, 'fileExportAsPdf'])
    ->name('adminpage.file-export-pdf')
    ->middleware('checkuser');

Route::prefix('get-options')->group(function () {
    Route::get('/', TradierOptionChainController::class)
        ->name('getoptions.home')
        ->middleware('checkadmin');
});

Route::get('/', [AuthController::class, 'index']);
Route::get('login', [AuthController::class, 'index']);
//Route::get('adminpage', [AuthController::class, 'dashboard']); 
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'doLogin'])->name('login.custom'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register-user');
Route::post('registration', [AuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [AuthController::class, 'signOut'])->name('signout');

Route::get('txt-convert', TxtConvertController::class)
    ->name('txt_convert')
    ->middleware('checkadmin');
Route::post('txt-convert', [TxtConvertController::class, 'convert'])
    ->name('txt_convert')
    ->middleware('checkadmin');

Route::get('open-status', OpenStatusController::class)->name('open_status')->middleware('checkadmin');

Route::prefix('adddata')->group(function () {
    Route::get('/', AddDataController::class)->name('add_data')->middleware('checkadmin');
    Route::post('add', [AddDataController::class, 'addData'])->name('add_contact')->middleware('checkadmin');
    Route::post('delete_contact', [AddDataController::class, 'deleteContact'])->name('delete_contact')->middleware('checkadmin');
    Route::post('import_bulk_contacts', [AddDataController::class, 'addBulkContacts'])->name('add_bulk_contacts')->middleware('checkadmin');
    Route::post('add_new_category', [AddDataController::class, 'addNewCategory'])->name('add_new_category')->middleware('checkadmin');
    Route::post('add_edit_category', [AddDataController::class, 'addEditCategory'])->name('add_edit_category')->middleware('checkadmin');
    Route::post('delete_mail', [AddDataController::class, 'deleteMail'])->name('delete_mail')->middleware('checkadmin');
    //
});
Route::get('send_mail/{category}/{mailers}', [SendMailController::class, 'show'])->name('view_send_mailers')->middleware('checkadmin');
Route::get('send_mail', [SendMailController::class])->name('view_send_mail')->middleware('checkadmin');
Route::post('send_mail', [SendMailController::class, 'sendEmail'])->name('send_email')->middleware('checkadmin');
//Route::post('delete_mail', [SendMailController::class, 'deleteMail'])->name('send_email')->middleware('checkadmin');
//Route::get('txt-convert', [AuthController::class, 'signOut'])->name('txt_convert');

Route::prefix('erdata')->group(function () {
    Route::get('/', ERDataController::class)->name('erdata')->middleware('checkadmin');
    Route::post('add', [ERDataController::class, 'add'])->name('erdata.add')->middleware('checkadmin');
    Route::post('delete', [ERDataController::class, 'delete'])->name('erdata.delete')->middleware('checkadmin');
    Route::post('/import_csv', [ERDataController::class, 'importFromCSV'])->name('erdata.importFromCSV')->middleware('checkadmin');
    Route::get('/export_pdf', [ERDataController::class, 'exportAsPdf'])->name('erdata.exportAsPdf')->middleware('checkadmin');
    Route::get('/export_csv', [ERDataController::class, 'exportAsCsv'])->name('erdata.exportAsCsv')->middleware('checkadmin');
    
    //
});
