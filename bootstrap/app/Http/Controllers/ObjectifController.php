<?php

namespace App\Http\Controllers;

use App\Models\Objectif;
use App\Models\Categorie;
use App\Models\Progression;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ObjectifController extends Controller
{
    
    public function index()
    {
        $objectifs = Objectif::all();
        $categories = Categorie::all();
        $progressions = Progression::all();
        foreach ($objectifs as $objectif) {
            $objectif->progressionGlobale = $this->calculerProgressionGlobale($objectif);
        }
    
        return view('map', compact('objectifs', 'categories', 'progressions'));
    }

    // Crée un nouvel objectif (appelé par le formulaire AJAX)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'categorie' => 'nullable|string',
            'description' => 'nullable|string',
            'date_debut' => 'nullable|date',
            'date_limite' => 'nullable|date',
            'lieu' => 'nullable|string',
            'visibilite' => 'required|in:public,prive',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'progression' => 'nullable|numeric|min:0|max:100',
            'couleur' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['nom']) . '-' . uniqid();

        $objectif = Objectif::create($validated);

        if (!empty($validated['lieu'])) {
            $coords = http::get('https://nominatim.openstreetmap.org/search', [
                'q' => $validated['lieu'],
                'format' => 'json',
                'limit' => 1
            ]);
    
            if ($coords->successful() && count($coords->json()) > 0) {
                $objectif->latitude = $coords[0]['lat'];
                $objectif->longitude = $coords[0]['lon'];
            }
        }
    
        $objectif->save();
    
        return response()->json([
            'id' => $objectif->id,
            'nom' => $objectif->nom,
            'categorie' => $objectif->categorie,
            'progression' => $objectif->progression,
            'latitude' => $objectif->latitude,
            'longitude' => $objectif->longitude
        ]);
    }
    public function calculerProgressionGlobale(Objectif $objectif)
    {
        // Récupère les progressions de l'objectif
        $progressions = $objectif->progressions; // Cela utilise la relation définie dans le modèle
        
        // Si pas de progressions, retourne 0
        if ($progressions->isEmpty()) {
            return 0;
        }
    
        // Calculer la progression basée sur les étapes terminées et autres critères
        $totalProgression = 0;
        $totalSteps = $progressions->count();
    
        foreach ($progressions as $progression) {
            $stepProgress = $progression->progression; // Supposons que la progression de chaque étape est déjà calculée
            $totalProgression += $stepProgress;
        }
    
        // Calculer la progression globale en fonction du nombre d'étapes
        if ($totalSteps > 0) {
            return ($totalProgression / $totalSteps);
        }
    
        return 0;
    }
}

