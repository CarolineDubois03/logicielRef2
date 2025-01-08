<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'annual_id',
        'recipient',
        'date',
        'object',
        'id_handling_user',
        'copy_to',
        'category',
        'document_path',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($courier) {
            $currentYear = date('Y');
            $courier->year = $currentYear;

            $lastCourier = static::where('year', $currentYear)->orderBy('annual_id', 'desc')->first();
            $courier->annual_id = $lastCourier ? $lastCourier->annual_id + 1 : 1;
        });
    }

    public function handlingUser()
    {
        return $this->belongsTo(User::class, 'id_handling_user');
    }

    public function couriersType()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function copiedUsers()
    {
    return $this->belongsToMany(User::class, 'courier_user');

    }
    public function recipients()
    {
        return $this->belongsToMany(Recipient::class, 'courier_recipient');
    }


}
