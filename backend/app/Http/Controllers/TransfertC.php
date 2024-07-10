<?php

namespace App\Http\Controllers;
use App\Models\Transfert;
use Illuminate\Http\Request;

class TransfertC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Transfert::getAllPatTrans();
    }

    public function showP()
    {
        return Transfert::PatSerC();
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
            "service"=>"required",
            "patient"=>"required",
        ]);

        $transfert = new Transfert();
        $transfert->id_pat=$request->patient;
        $transfert->id_ser=$request->service;
        $transfert->id_pers=$request->idper;
        $transfert->etat_transf='Envoyé';
        $transfert->motif=$request->motif;
        $transfert->date_envoi=date("Y-m-d");
        $transfert->save();
        return($transfert);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Transfert::PatSer($id);
        // $count = Transfert::countser($id);

        // $response = [
        //     'patser'=>$ser,
        //     'countser'=>$count,
        // ];

        // return($response);
    }
    public function search(string $id, $search)
    {
        return Transfert::SearchPatSer($id,$search);
        // $count = Transfert::countser($id);

        // $response = [
        //     'patser'=>$ser,
        //     'countser'=>$count,
        // ];

        // return($response);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Transfert::countser($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $transfert = Transfert::find($id);
        $transfert->id_ser=$request->service;
        $transfert->motif=$request->motif;
        $transfert->save();
        return($transfert);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Transfert::destroy($id);
    }
}
