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

    public function projetAssignees()
    {
        return $this->hasMany(ProjetAssignee::class, 'utilisateur_id', 'utilisateur_id');
    }

    public function typeCompte()
    {
        return $this->hasOne(TypeCompte::class, 'utilisateur_id', 'utilisateur_id');
    }

    public function hasRole(string $role): bool
    {
        return $this->type === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->type, $roles);
    }
    public function taches()
    {
        return $this->hasMany(Tache::class, 'utilisateur_id', 'utilisateur_id');
    }

    public function chefProjets()
    {
        return $this->hasMany(Projet::class, 'chefprojet_id', 'utilisateur_id');
    }

}
