<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'id_service'];
    
    public function couriersType()
    {
        return $this->hasMany(Courier::class, 'category');
    }

}