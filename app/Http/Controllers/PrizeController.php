<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use App\Models\Prize;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Raffle $raffle)
    {
        //
        $prizes = $raffle->prizes;

        return view('prizes.create', compact('raffle','prizes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Raffle $raffle)
    {
        //
        $request->validate([
            'name' => 'required',
            'quantity' => 'required',
        ]);

        $prize = new Prize();
        $prize->name = $request->name;
        $prize->quantity = $request->quantity;
        $prize->remaining = $request->quantity;
        $prize->raffle_id = $raffle->id;
        $prize->save();

        // Return al back
        return redirect()->route('prizes.create', $raffle->id)->with('success', 'Prize created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //eliminar premio
        $prize = Prize::find($id);
        $prize->delete();

        return redirect()->route('prizes.create', $prize->raffle_id)->with('success', 'Prize deleted successfully.');
    }
}
