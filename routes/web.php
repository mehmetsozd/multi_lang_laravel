<?php

use App\Http\Controllers\Admin\AdminAuthController;
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





Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    Route::get('/', function () { return view('admin.login'); });
    Route::get('/login', function () { return view('admin.login'); })->name('adminLogin');
    Route::post('/login', [AdminAuthController::class, 'postLogin']);
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('adminLogout');


    Route::middleware(['admin'])->group(function () {

        $multiLang = config('app.multi_lang', false);

        if ($multiLang) {
            Route::group(['prefix' => 'language'], function (){
                Route::get('/', [App\Http\Controllers\Admin\LanguageController::class, 'index'])->name('adminLanguage');
                Route::post('/list', [App\Http\Controllers\Admin\LanguageController::class, 'list']);
                Route::get('/edit', [App\Http\Controllers\Admin\LanguageController::class, 'edit']);
                Route::post('/update', [App\Http\Controllers\Admin\LanguageController::class, 'update']);
                Route::delete('/delete', [App\Http\Controllers\Admin\LanguageController::class, 'delete']);
                Route::put('/defualt ', [App\Http\Controllers\Admin\LanguageController::class, 'defualt']);
            });
    
            Route::group(['prefix' => 'translate'], function (){
                Route::get('/', [App\Http\Controllers\Admin\TranslateController::class, 'index'])->name('adminTranslate');
                Route::post('/list', [App\Http\Controllers\Admin\TranslateController::class, 'list']);
                Route::get('/edit', [App\Http\Controllers\Admin\TranslateController::class, 'edit']);
                Route::post('/update', [App\Http\Controllers\Admin\TranslateController::class, 'update']);
            });
        }

        
        Route::group(['prefix'=> 'user'], function () {
            Route::get('/', function () { return view('admin.users'); })->name('adminUsers');
            Route::post('/list', [App\Http\Controllers\Admin\AdminUserController::class, 'users']);
            Route::get('/search', [App\Http\Controllers\Admin\AdminUserController::class, 'searchUsers']);
            Route::put('/admin', [App\Http\Controllers\Admin\AdminUserController::class, 'updateAdmin']);
        });
    });



});
Route::get('/{slug}', [HomeController::class, 'indexslug']);