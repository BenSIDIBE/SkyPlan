<?php

namespace App\Http\Controllers;

use App\Models\Poste;
use Illuminate\Http\Request;
use App\Http\Controllers\compact;

class PosteController extends Controller
{
    public function index()
    {
        $postes = Poste::all();
        return view('postes.index', compact('postes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Poste::create($request->all());

        return redirect()->back()->with('success', 'Poste ajouté avec succès.');
    }
    public function show($id)
{
    $poste = Poste::findOrFail($id);
    return view('postes.show', compact('poste'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $poste = Poste::findOrFail($id);
        $poste->update($request->all());

        return redirect()->back()->with('success', 'Poste mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $poste = Poste::findOrFail($id);
        $poste->delete();

        return redirect()->back()->with('success', 'Poste supprimé avec succès.');
    }
}
