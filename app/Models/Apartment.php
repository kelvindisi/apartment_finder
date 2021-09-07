<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'phone',
        'email',
        'description',
    ];

    // relationships
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function houses() {
        return $this->hasMany(House::class);
    }
    public function apartmentPictures() {
        return $this->hasMany(ApartmentPicture::class);
    }
}
