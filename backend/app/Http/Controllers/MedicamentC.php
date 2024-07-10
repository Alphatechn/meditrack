<?php

namespace App\Http\Controllers;


use App\Models\Medicament;

use Illuminate\Http\Request;

class MedicamentC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Medicament::getAllMed();
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

            "categorie"=>"required",
            "libelle"=>"required",
        ]);
        $medicament = new Medicament();

        $medicament->id_cat=$request->categorie;
        $medicament->libelle=$request->libelle;
        $medicament->prix=$request->prix;
        $medicament->save();
        return($medicament);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Medicament::getSingleMed($id);

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

            "id_cat"=>"required",
            "libelle"=>"required",
        ]);

        $medicament = Medicament::find($id);

        $medicament->id_cat=$request->id_cat;
        $medicament->libelle=$request->libelle;
        $medicament->prix = $request->prix;
        $medicament->save();
        return($medicament);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Medicament::destroy($id);
    }
}
