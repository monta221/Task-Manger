<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjetAssignee extends Model
{
    protected $table = 'projet_assignees';

    protected $fillable = [
        'utilisateur_id',
        'projet_id',
        'date_assigned', 
        'statut',        
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id', 'projet_id');
    }
}
