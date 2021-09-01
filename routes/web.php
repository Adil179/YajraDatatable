<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataTableAjaxCRUDController;
use App\Http\Controllers\ProductController;
use App\Http\Livewire\NotificationSweetAlert;
  
Route::resource('products', ProductController::class);

//yajra crud route
 
Route::get('ajax-crud-datatable', [DataTableAjaxCRUDController::class, 'index']);
Route::post('store-company', [DataTableAjaxCRUDController::class, 'store']);
Route::post('edit-company', [DataTableAjaxCRUDController::class, 'edit']);
Route::post('delete-company', [DataTableAjaxCRUDController::class, 'destroy']);

//end

//export

Route::get('export', [DataTableAjaxCRUDController::class, 'export'])->name('export');

//end


Route::get('/', function () {
    return view('welcome');
});


Route::get('/search', [ProductController::class])->name('search');
Route::post('/search/action', [ProductController::class,'action'])->name('search.action');


Route::get('notification-sweetalert', NotificationSweetAlert::class);