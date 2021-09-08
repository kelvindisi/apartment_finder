<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    // relationship
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function house() {
        return $this->belongsTo(House::class);
    }
    public function comments() {
        return $this->hasMany(Reviews::class);
    }
}
