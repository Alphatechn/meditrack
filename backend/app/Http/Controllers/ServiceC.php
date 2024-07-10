<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Service::where('status','!=',1)->get();
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
        ]);

        $service = new Service();
        $service->libelle=$request->libelle;
        $service->save();
        return($service);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Service::find($id);
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
        ]);

        $service = Service::find($id);
        $service->libelle=$request->libelle;
        $service->save();
        return($service);    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Service::destroy($id);
    }

    public function search($libelle)
    {
        return Service::where('libelle','like','%'.$libelle.'%')->get();
    }
}
