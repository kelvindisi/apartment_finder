<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index()
    {
        //get all 
        $bookings = DB::table('users')
        ->join('apartments', 'users.id', '=', 'apartments.user_id')
        ->join('houses', 'apartments.id', '=', 'houses.apartment_id')
        ->join('bookings', 'houses.id', '=', 'bookings.house_id')
        ->SELECT('apartments.name', 'apartments.location', 'booking.status', 'booking.scheduled')
        ->WHERE('user.id', '=', Auth::user()->id)->get();
        
        dd($bookings);
    }
}
