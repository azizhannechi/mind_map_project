<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objectif extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'categorie',
        'description',
        'date_debut',
        'date_limite',
        'lieu',
        'visibilite',
        'latitude',
        'longitude',
        'progression',
        'couleur',
    ];

public function progressions()
{
    return $this->hasMany(Progression::class);
}
}

