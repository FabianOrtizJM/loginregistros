<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogo;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

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
    public function signed()
    {
        $urlFirmada = URL::signedRoute('catalogo');
        return redirect()->away($urlFirmada);
    }
    public function createcatalogo(){
        $urlFirmada = URL::signedRoute('create');
        return redirect()->away($urlFirmada);
    }
    public function editcatalogo(string $id){
        $urlFirmada = URL::signedRoute('users.edit',['id' => $id]);
        return redirect()->away($urlFirmada);
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
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
            'categoria' => 'required|max:50',
            'region' => 'required|max:50',
            'copias' => 'required|max:50',
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors();

            return redirect()->route('catalogo')->with(['error' => 'Datos no validos, vuelve a intentarlo']);
        }
        $catalogos = new Catalogo();
        $catalogos->nombre = $request->get('nombre');
        $catalogos->categoria = $request->get('categoria');
        $catalogos->pais_origen = $request->get('region');
        $catalogos->m_copias = $request->get('copias');
        $catalogos->save();
        return redirect('/signed');
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
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
            'categoria' => 'required|max:50',
            'region' => 'required|max:50',
            'copias' => 'required|max:50',
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors();

            return redirect()->route('catalogo')->with(['error' => 'Datos no validos, vuelve a intentarlo']);
        }
        $catalogo = Catalogo::find($id);
        $catalogo->nombre = $request->get('nombre');
        $catalogo->categoria = $request->get('categoria');
        $catalogo->pais_origen = $request->get('region');
        $catalogo->m_copias = $request->get('copias');
        $catalogo->save();
        return redirect('/signed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $catalogo = Catalogo::find($id);
        $catalogo->delete();
        return redirect('/signed');
    }
}
