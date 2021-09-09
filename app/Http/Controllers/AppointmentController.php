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
        $user_id = Auth::user()->id;
        $bookings = DB::table("users")
            ->select('bookings.*', 'users.email', 'users.name', 'apartments.id as apartment_id', 'houses.id as house_id')
            ->join('bookings', 'bookings.user_id', '=', 'users.id')
            ->join('houses', 'houses.id', '=', 'bookings.house_id')
            ->join('apartments', 'apartments.id', '=', 'houses.apartment_id')
            ->where('apartments.user_id', '=', $user_id)
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
    public function comment(Request $request, Booking $booking)
    {
        $input = $request->validate([
            'rating' => 'required|numeric|min:0|max:10',
            'review' => 'required'
        ]);
        $user_id = Auth::user()->id;
        $booking_user_id = $booking->user_id;
        if ($user_id != $booking_user_id)
            return redirect()->back()->with("error", "Not permitted to post on this visit.");
        $booking->comments()->create($input);

        return redirect(route("booking.show", $booking->id))->with("success", "Review saved successfully.");
    }
}
