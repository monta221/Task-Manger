<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'utilisateurs';
    protected $primaryKey = 'utilisateur_id';
    public $incrementing = true;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Many-to-many relation with projets
    public function projets()
    {
        return $this->belongsToMany(
            Projet::class,
            'projet_assignees',
            'utilisateur_id',
            'projet_id'
        )
        ->withPivot('date_assigned', 'statut')
        ->withTimestamps();
    }

    // One-to-many relation with ProjetAssignee
    public function projetAssignees()
    {
        return $this->hasMany(ProjetAssignee::class, 'utilisateur_id', 'utilisateur_id');
    }

    // Relation to typeCompte
    public function typeCompte()
    {
        return $this->hasOne(TypeCompte::class, 'utilisateur_id', 'utilisateur_id');
    }

    // Role helper functions
    public function hasRole(string $role): bool
    {
        return $this->type === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->type, $roles);
    }
}
