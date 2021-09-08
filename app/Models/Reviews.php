<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    protected $guarded = [];

    // relationship
    public function booking() {
        return $this->belongsTo(Booking::class);
    }

}
