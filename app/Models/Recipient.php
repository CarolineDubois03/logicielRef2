<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;

    protected $fillable = ['label'];

    /**
     * Relation many-to-many avec les courriers.
     */
    public function couriers()
    {
        return $this->belongsToMany(Courier::class, 'courier_recipient');
    }
}
