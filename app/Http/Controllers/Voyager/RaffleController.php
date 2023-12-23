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
        $total_participants = $participants->count();
        return view('raffle.draw_game', compact(['raffle', 'participants', 'total_participants']));
    }
    public function getParticipants(Raffle $raffle)
    {
        $participants = $raffle->people()->wherePivot('selected', false)->inRandomOrder()->get();
        return response()->json($participants);
    }

    public function selectRandomParticipant(Raffle $raffle)
    {
        $participant = $raffle->people()->wherePivot('selected', false)->inRandomOrder()->first();
        if ($participant) {
            $raffle->people()->updateExistingPivot($participant->id, ['selected' => true]);
        }
        return response()->json($participant);
    }
}
