<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Voyager\RaffleController;

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
Route::get('/login',function(){
    return redirect()->route('voyager.login');
})->name('login');

Route::get('/', function () {
    return view('welcome');
    
});
Route::controller(RaffleController::class)->group(
    function () {
        Route::get('{raffle}/draw', 'drawGame')->name('raffle.draw');
        Route::get('raffle/{raffle}/participants', 'getParticipants')->name('raffle.participants');
        Route::get('raffle/{raffle}/selectRandomParticipant', 'selectRandomParticipant')->name('raffle.selectRandomParticipant');
    }
);


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
