<?php

namespace App\Http\Controllers;

use App\Models\Prescrire;
use Illuminate\Http\Request;

class PrescrireC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        return Prescrire::getPres($id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "dose"=>"required",
            "prise"=>"required",
            "medicament"=>"required",
        ]);

        $prescrire = new Prescrire();
        $prescrire->dose=$request->dose;
        $prescrire->prise=$request->prise;
        $prescrire->medicament=$request->medicament;
        $prescrire->save();
        return($prescrire);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Prescrire::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "dose"=>"required",
            "prise"=>"required",
            "medicament"=>"required",
        ]);

        $prescrire = Prescrire::find($id);
        $prescrire->dose=$request->dose;
        $prescrire->prise=$request->prise;
        $prescrire->medicament=$request->medicament;
        $prescrire->save();
        return($prescrire);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Prescrire::destroy($id);
    }
}
