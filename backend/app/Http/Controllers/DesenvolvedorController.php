<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Desenvolvedor;
use Illuminate\Http\Request;

class DesenvolvedorController extends Controller
{
    public function index()
    {
        $desenvolvedores = Desenvolvedor::with('nivel')->get();

        if ($desenvolvedores->isEmpty()) {
            return response()->json(['message' => 'Nenhum desenvolvedor encontrado.'], 404);
        }

        $desenvolvedores = $desenvolvedores->map(function ($desenvolvedor) {
            return [
                'id' => $desenvolvedor->id,
                'nome' => $desenvolvedor->nome,
                'sexo' => $desenvolvedor->sexo,
                'data_nascimento' => $desenvolvedor->data_nascimento,
                'idade' => \Carbon\Carbon::parse($desenvolvedor->data_nascimento)->age,
                'hobby' => $desenvolvedor->hobby,
                'nivel' => [
                    'id' => $desenvolvedor->nivel->id,
                    'nivel' => $desenvolvedor->nivel->nivel,
                ],
            ];
        });

        return response()->json($desenvolvedores, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nivel_id' => 'required|exists:niveis,id',
            'nome' => 'required|string|max:255',
            'sexo' => 'required|string|size:1',
            'data_nascimento' => 'required|date',
            'hobby' => 'nullable|string|max:255',
        ]);

        $desenvolvedor = Desenvolvedor::create($validatedData);

        return response()->json($desenvolvedor, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nivel_id' => 'required|exists:niveis,id',
            'nome' => 'required|string|max:255',
            'sexo' => 'required|string|size:1',
            'data_nascimento' => 'required|date',
            'hobby' => 'nullable|string|max:255',
        ]);

        $desenvolvedor = Desenvolvedor::find($id);

        if (!$desenvolvedor) {
            return response()->json(['message' => 'Desenvolvedor não encontrado.'], 404);
        }

        $desenvolvedor->update($validatedData);

        return response()->json($desenvolvedor, 200);
    }

    public function destroy($id)
    {
        $desenvolvedor = Desenvolvedor::find($id);

        if (!$desenvolvedor) {
            return response()->json(['message' => 'Desenvolvedor não encontrado.'], 404);
        }

        try {
            $desenvolvedor->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao remover o desenvolvedor.'], 400);
        }

        return response()->json(null, 204);
    }

    
}
