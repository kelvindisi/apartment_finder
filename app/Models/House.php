<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $guarded = [];

    // relationships
    public function apartment() {
        return $this->belongsTo(Apartment::class);
    }
    public function pictures() {
        return $this->hasMany(HousePicture::class);
    }
    public function reviews() {
        return $this->hasMany(Reviews::class);
    }
    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}
