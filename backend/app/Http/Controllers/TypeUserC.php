<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Type_user;
class TypeUserC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Type_user::all();
    }

    public function showall()
    {
        return Type_user::where('id', '!=', 6)->get();
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
            "role"=>"required",
            "libelle"=>"required",
        ]);

        $typeuser = new Type_user();
        $typeuser->libelle=$request->libelle;
        $typeuser->role=$request->role;
        $typeuser->save();
        return($typeuser);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Type_user::find($id);
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
            "role"=>"required",
            "libelle"=>"required",
        ]);

        $typeuser = Type_user::find($id);
        $typeuser->libelle=$request->libelle;
        $typeuser->role=$request->role;
        $typeuser->save();
        return($typeuser);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Type_user::destroy($id);
    }

    public function search($libelle)
    {
        return Type_user::where('libelle','like','%'.$libelle.'%')->get();
    }
}
