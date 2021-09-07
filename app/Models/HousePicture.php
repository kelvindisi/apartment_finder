<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousePicture extends Model
{
    use HasFactory;
    protected $guarded = [];
    //relationship
    public function house() {
        return $this->belongsTo(House::class);
    }
}
