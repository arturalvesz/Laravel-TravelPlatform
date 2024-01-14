<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    /*protected $fillable = [
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
<<<<<<< HEAD
=======

    }*/

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderExperience()
    {
        return $this->belongsTo(OrderExperience::class, 'order_experience_id');
>>>>>>> f073c1b33e901446b1dc6d8beb95bbbbc0e17731
    }
}
