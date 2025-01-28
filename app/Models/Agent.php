<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name'];

    /**
     * Relation many-to-many avec les courriers.
     */
    public function couriers()
    {
        return $this->belongsToMany(Courier::class, 'courier_agent');
    }
}
