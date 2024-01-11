<?php

namespace App\Http\Controllers\Voyager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use App\Models\Raffle;
use App\Models\Person;
use App\Models\Prize;

class RaffleController extends VoyagerBaseController
{
    //
    public function drawGame(Raffle $raffle)
    {
        $participants = $raffle->people()->get();
        $participantsSelected = $raffle->people()->wherePivot('selected', true)->withPivot('status', 'updated_at')->orderBy('pivot_updated_at', 'desc')->get();
        $total_participants = $participants->count();

        $prizes_remaining = $raffle->prizes()->where('remaining', '>', 0)->get();

        return view('raffle.draw_game', compact(['raffle', 'participants','participantsSelected', 'total_participants','prizes_remaining']));
    }

    public function getParticipants(Raffle $raffle)
    {
        $participants = $raffle->people()->wherePivot('selected', false)->inRandomOrder()->get();
        return response()->json($participants);
    }

    public function getParticipantsSelected(Raffle $raffle)
    {
        $participantsSelected = $raffle->people()->wherePivot('selected', true)->withPivot('status', 'updated_at')->orderBy('pivot_updated_at', 'desc')->get();
        return response()->json($participantsSelected);
    }

    public function selectRandomParticipant(Request $request,Raffle $raffle)
    {
        $selectState = $request->input('selectValue');
        $selectPrize = $request->input('selectPrize');
        if ($selectState == 1) {
            $participant = $raffle->people()->wherePivot('selected', false)->wherePivot('is_winner', true)->inRandomOrder()->first();
            if (!$participant) {
                $participant = $raffle->people()->wherePivot('selected', false)->inRandomOrder()->first();
            }else{
                $raffle->people()->updateExistingPivot($participant->id, ['is_winner' => false]);
            }
        }else{
            $participant = $raffle->people()->wherePivot('selected', false)->inRandomOrder()->first();
        }

        
        if ($participant) {


            $status = $selectState == 1 ? 'Ganador' : 'Descartado';

            $pivotData = ['selected' => true, 'status' => $status,'updated_at' => now()];
            if ($selectPrize && $selectState == 1) {
                $pivotData['prize_id'] = $selectPrize;
                $prize = Prize::find($selectPrize);
                if ($prize) {
                    $prize->decrement('remaining');
                }
            }

            $raffle->people()->updateExistingPivot($participant->id,$pivotData);
        }else{
            $participant = null;
        }
        return response()->json($participant);
    }

    //para añadir a todas las personas activas:
    public function addActivePeopleToRaffle($raffleId)
    {
        // Encuentra el sorteo por su ID
        $raffle = Raffle::find($raffleId);

        if (!$raffle) {
            // Si el sorteo no existe, redirige o maneja el error como prefieras
            return redirect()->back()->with('error', 'Raffle not found');
        }

        // Encuentra todas las personas con 'active' en true
        $people = Person::where('active', true)->get();

        // Agrega todas las personas al sorteo
        foreach ($people as $person) {
            $raffle->people()->syncWithoutDetaching($person->id);
        }

        // Redirige o maneja el éxito como prefieras
        return redirect()->back()->with('success', 'Active people added to raffle');
    }
    
    //Para reiniciar el sorteo:
    public function resetRaffle(Raffle $raffle)
    {
        // Encuentra todas las personas del sorteo que tienen 'selected' en true
        $selectedPeople = $raffle->people()->wherePivot('selected', true)->get();

        // Actualiza 'selected' a false y 'status' a 'none' para cada persona seleccionada
        foreach ($selectedPeople as $person) {
            $raffle->people()->updateExistingPivot($person->id, ['selected' => false, 'status' => 'none', 'prize_id'=>null]);
        }
        // Encuentra todos los premios del sorteo
        $prizes = $raffle->prizes;

        // Actualiza 'remaining' a ser igual a 'quantity' para cada premio
        foreach ($prizes as $prize) {
            $prize->remaining = $prize->quantity;
            $prize->save();
        }

        // Redirige o maneja el éxito como prefieras
        return redirect()->back()->with('success', 'Raffle has been reset');
    }

    // funcion para traer los premios de un sorteo
    public function getPrizes(Raffle $raffle)
    {
        $prizes = $raffle->prizes()->where('remaining', '>', 0)->get();
        return response()->json($prizes);
    }

}
