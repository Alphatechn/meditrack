<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\Medicament;
use Illuminate\Http\Request;
use App\Models\Element;

class Autocomplete extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    // Dans votre contrôleur
    public function getData()
    {
        $elementData = Element::select('libelle', 'montant')->get();
        $examenData = Examen::select('libelle', 'prix_examen')->get();
        $medicamentData = Medicament::select('libelle', 'prix')->get();

        $data = collect();
        foreach ($examenData as $examen) {
            $data->push([
                'libelle' => $examen->libelle,
                'montant' => $examen->prix_examen
            ]);
        }

        foreach ($medicamentData as $medicament) {
            $data->push([
                'libelle' => $medicament->libelle,
                'montant' => $medicament->prix
            ]);
        }

        foreach ($elementData as $element) {
            $data->push([
                'libelle' => $element->libelle,
                'montant' => $element->montant
            ]);
        }


        return response()->json($data->toArray());
    }

    public function getDataExam()
    {
        $examenData = Examen::select('libelle', 'prix_examen')->get();

        $data = collect();
        foreach ($examenData as $examen) {
            $data->push([
                'libelle' => $examen->libelle,
                'montant' => $examen->prix_examen
            ]);
        }

        return response()->json($data->toArray());
    }

    public function getDataMed()
    {
        $medicamentData = Medicament::select('libelle', 'prix')->get();

        $data = collect();

        foreach ($medicamentData as $medicament) {
            $data->push([
                'libelle' => $medicament->libelle,
                'montant' => $medicament->prix
            ]);
        }

        return response()->json($data->toArray());
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
