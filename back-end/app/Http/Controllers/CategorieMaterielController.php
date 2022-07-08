<?php

namespace App\Http\Controllers;

use App\Models\CategorieMateriel;
use Illuminate\Http\Request;

class CategorieMaterielController extends Controller
{
    public function index()
    {
        $categorieMateriels = CategorieMateriel::all();
        if ($categorieMateriels->isEmpty()) {
            return response()->json([
                'message' => 'No categorie materiel found',
            ], 404);
        }
        return response()->json(
            $categorieMateriels,
            200
        );
    }
    public function store(Request $request)
    {
        $categorieMateriel = CategorieMateriel::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => $request->user()->id,
        ]);
        if ($categorieMateriel) {
            return response()->json([
                'message' => 'Categorie materiel created',
                'categorieMateriel' => $categorieMateriel,
            ], 201);
        }
        return response()->json([
            'message' => 'Categorie materiel not created',
        ], 400);
    }
    public function destroy(Request $request, $id)
    {
        $categorieMateriel = CategorieMateriel::find($id);
        if ($categorieMateriel) {
            $categorieMateriel->delete();
            return response()->json([
                'message' => 'Categorie materiel deleted',
            ], 200);
        }
        return response()->json([
            'message' => 'Categorie materiel not found',
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $categorieMateriel = CategorieMateriel::find($id);
        if ($categorieMateriel) {
            $categorieMateriel->update([
                'name' => $request->name,
                'description' => $request->description,
                'created_by' => $request->user()->id,
            ]);
            return response()->json([
                'message' => 'Categorie materiel updated',
                'categorieMateriel' => $categorieMateriel,
            ], 200);
        }
        return response()->json([
            'message' => 'Categorie materiel not found',
        ], 404);
    }

}
