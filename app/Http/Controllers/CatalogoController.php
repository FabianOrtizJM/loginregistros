<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogo;

class CatalogoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catalogos = Catalogo::all();
        return view('catalogo.index')->with('catalogos', $catalogos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('catalogo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $catalogos = new Catalogo();
        $catalogos->nombre = $request->get('nombre');
        $catalogos->categoria = $request->get('categoria');
        $catalogos->pais_origen = $request->get('region');
        $catalogos->m_copias = $request->get('copias');
        $catalogos->save();
        return redirect('/catalogo');
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
        $catalogo = Catalogo::find($id);
        return view('catalogo.edit')->with('catalogo', $catalogo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $catalogo = Catalogo::find($id);
        $catalogo->nombre = $request->get('nombre');
        $catalogo->categoria = $request->get('categoria');
        $catalogo->pais_origen = $request->get('region');
        $catalogo->m_copias = $request->get('copias');
        $catalogo->save();
        return redirect('/catalogo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $catalogo = Catalogo::find($id);
        $catalogo->delete();
        return redirect('/catalogo');
    }
}
