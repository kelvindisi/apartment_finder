<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class AppointmentController extends Controller
{
    public function index()
    {
        $bookings = DB::table("users")
            ->select('bookings.*', 'users.email', 'users.name', 'apartments.id as apartment_id', 'houses.id as house_id')
            ->join('bookings', 'bookings.user_id', '=', 'users.id')
            ->join('houses', 'houses.id', '=', 'bookings.house_id')
            ->join('apartments', 'apartments.id', '=', 'houses.apartment_id')
            ->get();
        return view('landlord.schedules.index', ['bookings' => $bookings]);
    }
    public function show(Booking $booking)
    {
        return view('landlord.schedules.details', ['booking' => $booking]);
    }
    public function schedule(Request $request, Booking $booking)
    {
        $input = $request->validate([
            'date' => 'required|date|after:tomorrow'
        ]);
        $update = [
            'confirmed'=> 'confirmed',
            'scheduled_date' => $input['date']
        ];
        $booking->update($update);

        return redirect()->back()->with('success', "Updated status to 'Approved'.");
    }
    public function denieVisit(Booking $booking)
    {
        $booking->confirmed = 'rejected';
        $booking->save();

        return redirect()->back()->with('success', "Status changed to 'Not Approved'");
    }
}
