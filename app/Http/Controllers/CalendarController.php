<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CalendarController extends Controller
{
    public function index()
    {
        return view('calendrier');
    }

    public function store(Request $request)
    {
        // Validation simple
        $request->validate([
            'selected_date' => 'required|date',
            'message' => 'nullable|string|max:255',
        ]);

        // Sauvegarder dans la base de données ou log (selon votre modèle)
        // Exemple simple :
        // CalendarEvent::create($request->all());

        return redirect()->route('calendrier.index')->with('success', 'Date enregistrée avec succès !');
    }
}

