<?php

namespace App\Models;

use App\Models\Car;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RentCar extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_car',
        'start_date',
        'end_date',
        'total',
        'status',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'id_car');
    }
}
