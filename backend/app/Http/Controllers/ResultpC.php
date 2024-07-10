<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResultP;
use App\Models\Transfert;

class ResultpC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        return Transfert::PatPer($id);
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

        foreach ($request->items as $item) {
            $examinationItem = new ResultP();
            $examinationItem->exam = $item['libelle'];

            if (isset($item['image'])) {
                $imageName = time() . '.' . $item['image']->getClientOriginalExtension();
                $item['image']->move(public_path('images'), $imageName);
                $examinationItem->result_image = $imageName;
            }else{
                $examinationItem->result_text = $item['result_t'];
            }
            $examinationItem->id_cons = $request->id_consultation;
            $examinationItem->id_pat = $request->id_pat;
            $examinationItem->id_pers = $request->id_pers;
            $examinationItem->save();
        }
        $trans = Transfert::find($request->id_transfert);
        $trans->etat_transf = 'Reçu';
        $trans->date_recu = date("Y-m-d");
        $trans->id_pers_r = $request->id_pers;
        $trans->save();

        return ($examinationItem);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ResultP::getAllPatient($id);
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
    public function update(Request $request)
    {

        foreach ($request->examina as $itemm) {
            $examinationItem = ResultP::find($itemm['id']);
            $examinationItem->exam = $itemm['exam'];

            if (isset($itemm['imagem'])) {
                $imageName = time() . '.' . $itemm['imagem']->getClientOriginalExtension();
                $itemm['imagem']->move(public_path('images'), $imageName);
                $examinationItem->result_image = $imageName;
            }else{
                $examinationItem->result_text = $itemm['result_text'];
            }
            $examinationItem->save();
        }

        foreach ($request->items as $item) {
            $examinationItem = new ResultP();
            $examinationItem->exam = $item['libelle'];

            if (isset($item['image'])) {
                $imageName = time() . '.' . $item['image']->getClientOriginalExtension();
                $item['image']->move(public_path('images'), $imageName);
                $examinationItem->result_image = $imageName;
            }else{
                $examinationItem->result_text = $item['result_t'];
            }
            $examinationItem->id_cons = $request->id_consultation;
            $examinationItem->id_pat = $request->id_pat;
            $examinationItem->id_pers = $request->id_pers;
            $examinationItem->save();
        }
        return ($examinationItem);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
