<?php
// app/Http/Controllers/DogController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;

class DogController extends Controller
{
    // GET /dogs?limit=N
    public function index(Request $request)
    {
        $limit = $request->query('limit');

        if ($limit && is_numeric($limit) && $limit > 0) {
            $dogs = Dog::limit($limit)->get();
        } else {
            $dogs = Dog::all();
        }

        return response()->json($dogs);
    }

    // POST /dogs
    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:50']);
        $dog = Dog::create($request->all());
        return response()->json($dog, 201);
    }

    // GET /dogs/{id} 
    public function show(string $id)
    {
        $dog = Dog::findOrFail($id);
        return response()->json($dog);
    }

    // PUT /dogs/{id} 
    public function update(Request $request, string $id)
    {
        $dog = Dog::findOrFail($id);
        $request->validate(['nombre' => 'required|string|max:50']);
        $dog->update($request->all());

        return response()->json($dog);
    }

    // DELETE /dogs/{id} 
    public function destroy(string $id)
    {
        $dog = Dog::findOrFail($id);
        $dog->delete();

        return response()->json(['message' => 'Perro eliminado correctamente']);
    }
}