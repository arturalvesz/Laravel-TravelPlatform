<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'timeframe',
        'experience_id',
        'max_people',
        'people_registered',
    ];
    
    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }
    
}
