<?php

namespace App\Http\Controllers\Voyager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use App\Models\Raffle;
use App\Models\Person;

class RaffleController extends VoyagerBaseController
{
    //
    public function drawGame(Raffle $raffle)
    {
        $participants = $raffle->people()->get();
        $participantsSelected = $raffle->people()->wherePivot('selected', true)->withPivot('status')->get();
        $total_participants = $participants->count();
        return view('raffle.draw_game', compact(['raffle', 'participants','participantsSelected', 'total_participants']));
    }
    public function getParticipants(Raffle $raffle)
    {
        $participants = $raffle->people()->wherePivot('selected', false)->inRandomOrder()->get();
        return response()->json($participants);
    }
    public function getParticipantsSelected(Raffle $raffle)
    {
        $participantsSelected = $raffle->people()->wherePivot('selected', true)->withPivot('status')->get();
        return response()->json($participantsSelected);
    }

    public function selectRandomParticipant(Request $request,Raffle $raffle)
    {
        $selectState = $request->input('selectValue');
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
            $raffle->people()->updateExistingPivot($participant->id, ['selected' => true, 'status' => $status]);
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
}
