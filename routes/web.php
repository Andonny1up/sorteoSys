<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Voyager\RaffleController;

use App\Http\Controllers\PrizeController;

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
        Route::get('raffle/{raffle}/draw', 'drawGame')->name('raffle.draw')->middleware('auth');
        Route::get('raffle/{raffle}/participants', 'getParticipants')->name('raffle.participants')->middleware('auth');
        Route::get('raffle/{raffle}/selectRandomParticipant', 'selectRandomParticipant')->name('raffle.selectRandomParticipant')->middleware('auth');
        Route::get('raffle/{raffle}/participants/selected', 'getParticipantsSelected')->name('raffle.participants.selected')->middleware('auth');
        
        //para añadir a todas las personas activas:
        Route::post('raffle/{raffle}/addActivePeopleToRaffle', 'addActivePeopleToRaffle')->name('raffle.addActivePeopleToRaffle')->middleware('auth');
    
        //para reiniciar el sorteo:
        Route::post('raffle/{raffle}/resetRaffle', 'resetRaffle')->name('raffle.resetRaffle')->middleware('auth');
    
    }
);


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    // añadir premios a un sorteo
    Route::get('raffle/{raffle}/prizes/create', [PrizeController::class, 'create'])->name('prizes.create')->middleware('auth');
    Route::post('raffle/{raffle}/prizes/store', [PrizeController::class, 'store'])->name('prizes.store')->middleware('auth');
});
