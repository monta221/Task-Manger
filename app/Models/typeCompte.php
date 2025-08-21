<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeCompte extends Model
{
    protected $table = 'type_comptes';
    protected $primaryKey = 'compte_id';
    public $incrementing = true;

    protected $fillable = [
        'utilisateur_id',
        'label'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id', 'utilisateur_id');
    }
}
