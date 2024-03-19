<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['car_id', 'user_id', 'star_count', 'comment'];

    public function cars()
    {
        return $this->belongsTo(Car::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
