<?php
// app/Http/Controllers/CatController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cat;

class CatController extends Controller
{
    // GET /cats?limit=N
    public function index(Request $request)
    {
        $limit = $request->query('limit');

        if ($limit && is_numeric($limit) && $limit > 0) {
            $cats = Cat::limit($limit)->get();
        } else {
            $cats = Cat::all();
        }

        return response()->json($cats);
    }

    // POST /cats
    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:50']);
        $cat = Cat::create($request->all());

        return response()->json($cat, 201);
    }

    // GET /cats/{id} (Devuelve 404 si no encuentra)
    public function show(string $id)
    {
        $cat = Cat::findOrFail($id);
        
        return response()->json($cat);
    }

    // PUT /cats/{id} (Actualiza o devuelve 404 si no encuentra)
    public function update(Request $request, string $id)
    {
        $cat = Cat::findOrFail($id);

        $request->validate(['nombre' => 'required|string|max:50']);
        $cat->update($request->all());

        return response()->json($cat);
    }

    // DELETE /cats/{id} (Elimina o devuelve 404 si no encuentra)
    public function destroy(string $id)
    {
        $cat = Cat::findOrFail($id);
        $cat->delete();

        return response()->json(['message' => 'Gato eliminado correctamente']);
    }
}