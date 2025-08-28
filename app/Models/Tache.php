<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    protected $table = 'taches'; 
    protected $primaryKey = 'tache_id';
    public $incrementing = true;

    protected $fillable = [
        'projet_id',
        'utilisateur_id',
        'titreTache',
        'description',
        'etat',      
        'dateCreation',
        'dateFin',
        'note',
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id', 'projet_id');
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id', 'utilisateur_id');
    }
}
