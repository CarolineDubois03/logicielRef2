<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Nom du service
        'description', // Description du service
    ];

    /**
     * Relation : un service a plusieurs utilisateurs.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_service');
    }

    /**
     * Relation : un service a plusieurs catégories.
     */
    public function categories()
    {
        return $this->hasMany(Category::class, 'id_service');
    }
}
