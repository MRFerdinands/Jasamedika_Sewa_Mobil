<?php

namespace App\Models;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnCar extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_car',
        'return_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'id_car');
    }
}
