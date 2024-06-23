<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Nivel;
use Illuminate\Http\Request;

class NivelController extends Controller
{
    public function index()
    {
        $niveis = Nivel::all();

        // dd($niveis);

        if ($niveis->isEmpty()) {
            return response()->json(['message' => 'Nenhum nível encontrado.'], 404);
        }

        return response()->json($niveis, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nivel' => 'required|string|max:255',
        ]);

        $nivel = Nivel::create($validatedData);

        return response()->json($nivel, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nivel' => 'required|string|max:255',
        ]);

        $nivel = Nivel::find($id);

        if (!$nivel) {
            return response()->json(['message' => 'Nível não encontrado.'], 404);
        }

        $nivel->update($validatedData);

        return response()->json($nivel, 200);
    }

    public function destroy($id)
    {
        $nivel = Nivel::find($id);

        if (!$nivel) {
            return response()->json(['message' => 'Nível não encontrado.'], 404);
        }

        if ($nivel->desenvolvedores()->count() > 0) {
            return response()->json(['message' => 'Não é possível remover o nível, pois há desenvolvedores associados.'], 400);
        }

        $nivel->delete();

        return response()->json(null, 204);
    }
}


