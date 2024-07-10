<?php

namespace App\Http\Controllers;

use App\Models\Element;
use Illuminate\Http\Request;

class ElementC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Element::all();
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
            "libelle"=>"required",
            "montant"=>"required",
        ]);

        $examen = new Element();
        $examen->libelle=$request->libelle;
        $examen->montant=$request->montant;
        $examen->save();
        return($examen);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Element::find($id);
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
            "libelle"=>"required",
            "montant"=>"required",
        ]);

        $examen = Element::find($id);
        $examen->libelle=$request->libelle;
        $examen->montant=$request->montant;
        $examen->save();
        return($examen);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Element::destroy($id);
    }

    public function search($libelle)
    {
        return Element::where('libelle','like','%'.$libelle.'%')->get();
    }
}
