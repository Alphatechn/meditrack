<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;

class CategorieC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Categorie::where('status','!=','1')->get();
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
        $fields= $request->validate([
            "libelle"=>"required|string",
        ]);
       $cat=new Categorie();
       $cat->libelle=$fields['libelle'];
       $cat->save();
       $response = [
        'cat'=>$cat,
    ];
    return($response);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Categorie::find($id);
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
        $fields= $request->validate([
            "libelle"=>"required|string",
        ]);
       $cat=Categorie::find($id);
       $cat->libelle=$fields['libelle'];
       $cat->save();
       $response = [
        'cat'=>$cat,
    ];
    return($response);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cat = Categorie::find($id);
        $cat->status=1;
        $cat->save();
        return($cat);
    }
}
