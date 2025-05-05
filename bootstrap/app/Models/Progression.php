<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progression extends Model
{
    use HasFactory;
    protected $fillable = ['objectif_id', 'step_id', 'progression', 'deadline', 'file_uploaded', 'image_uploaded'];

    public function objectif()
    {
        return $this->belongsTo(Objectif::class);
    }

}
