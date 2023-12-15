<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'country',
        'district',
        'city',
        'street',
        'postal_code',
        'user_id'
    ];

    public function user(){

        return $this->belongsTo(User::class);
        
    }
}
