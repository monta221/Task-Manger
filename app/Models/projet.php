<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $table = 'projets';

    protected $primaryKey = 'projet_id';
    public $incrementing = true;

    protected $fillable = [
        'titreProjet',
        'description',
        'dateDebut',
        'dateFin',
        'note',  
        'etat',
    ];

    public function utilisateurs()
    {
        return $this->belongsToMany(
            Utilisateur::class, 
            'projet_assignees', 
            'projet_id', 
            'utilisateur_id'
        )
        ->withPivot('date_assigned', 'statut')
        ->withTimestamps();
    }

    public function taches()
    {
        return $this->hasMany(Tache::class, 'projet_id', 'projet_id');
    }
}
