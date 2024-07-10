<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use Illuminate\Http\Request;

class ExamenC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Examen::all();
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
            "prix_examen"=>"required",
        ]);

        $examen = new Examen();
        $examen->libelle=$request->libelle;
        $examen->prix_examen=$request->prix_examen;
        $examen->save();
        return($examen);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Examen::find($id);
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
            "prix_examen"=>"required",
        ]);

        $examen = Examen::find($id);
        $examen->libelle=$request->libelle;
        $examen->prix_examen=$request->prix_examen;
        $examen->save();
        return($examen);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Examen::destroy($id);
    }

    public function search($libelle)
    {
        return Examen::where('libelle','like','%'.$libelle.'%')->get();
    }
}
