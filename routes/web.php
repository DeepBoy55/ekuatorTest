<?php

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

Route::get('/migrate', function(){
    Artisan::call('migrate:fresh', [
            '--force' => true
    ]);
    Artisan::call('db:seed', [
            '--force' => true
    ]);
    return 'Migration success!';
});

Route::get('/route-clear', function() {
    Artisan::call('route:clear');
    return 'Route cache cleared!';
});

Route::get('/config-clear', function() {
    Artisan::call('config:clear'); 
    return 'Configuration cache cleared!';
});

Route::get('/updateapp', function()
{
    Artisan::call('dump-autoload');
    echo 'dump-autoload complete';
});

