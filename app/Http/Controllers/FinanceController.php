<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFinanceRequest;
use App\Http\Requests\UpdateFinanceRequest;
use App\Models\Finance;
use App\Models\Goal;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $finances = Finance::where('user_id', '=', auth()->user()->id)->get();
        $goals = Goal::where('user_id', '=', auth()->user()->id)->get();
        return view('finances.index', compact('finances','goals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finances.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFinanceRequest $request)
    {
        dump('roblox');
        dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Finance $finance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Finance $finance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFinanceRequest $request, Finance $finance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Finance $finance)
    {
        //
    }
}
