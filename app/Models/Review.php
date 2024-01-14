<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'starRating',
        'comment',
        'order_experience_id',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orderExperience(){
        return $this->belongsTo(orderExperience::class);
    }
}
