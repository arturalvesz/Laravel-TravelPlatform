<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'user_id',
        'price',
        'category_id',
        'duration',
        'location'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function day(){
        return $this->hasMany(Day::class);
    }

    public function photo(){
        return $this->hasMany(Photo::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
