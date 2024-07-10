<?php

namespace App\Http\Controllers;

use App\Models\Soin;
use Illuminate\Http\Request;

class SoinC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Soin::all();

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
            "cout"=>"required",
            "traitement"=>"required",
        ]);

        $soin = new Soin();
        $soin->libelle=$request->libelle;
        $soin->cout=$request->cout;
        $soin->traitement=$request->traitement;
        $soin->save();
        return($soin);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Soin::find($id);
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
            "cout"=>"required",
            "traitement"=>"required",
        ]);

        $soin = Soin::find($id);
        $soin->libelle=$request->libelle;
        $soin->cout=$request->cout;
        $soin->traitement=$request->traitement;
        $soin->save();
        return($soin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Soin::destroy($id);
    }
}
