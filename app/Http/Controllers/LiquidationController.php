<?php

namespace App\Http\Controllers;

use App\Models\Liquidation;
use Illuminate\Http\Request;

class LiquidationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

     $liquidation = liquidation::all();


     return view('settlement.index')->with('liquidation', $liquidation);
       
    }

     public function commissions()
    {

    return view('settlement.history');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Liquidation  $liquidation
     * @return \Illuminate\Http\Response
     */
    public function show(Liquidation $liquidation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Liquidation  $liquidation
     * @return \Illuminate\Http\Response
     */
    public function edit(Liquidation $liquidation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Liquidation  $liquidation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Liquidation $liquidation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Liquidation  $liquidation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Liquidation $liquidation)
    {
        //
    }
}
