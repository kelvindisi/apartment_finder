<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;
use App\Models\User;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $apartments = $user->apartments;
        return view('landlord.apartments.index')->with(['apartments' => $apartments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('landlord.apartments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //name, location, phone, email, description
        $input = $request->validate([
            'name' => 'required',
            'location' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'description' => 'required'
        ]);
        // $input = array_merge($input, ['landlord_id' => Auth::user()->id]);
        $created = Auth::user()->apartments()->create($input);
        if ($created)
            return redirect(route("apartments.index"))->with('success', 'Created apartment successfully');
        return redirect()->back()->with("error", "Failed to save apartment details.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apartment = Auth::user()->apartments()->where(['id'=>$id])->first();
        if ($apartment == null) {
            return redirect(route("apartments.index"))
            ->with("error", "APARTMENT YOU'RE LOOKING FOR IS NOT AVAILABLE");
        }
        return view("landlord.apartments.details", ['apartment' => $apartment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $apartment = Auth::user()->apartments()->where(['id'=>$id])->first();
        if ($apartment == null)
            return redirect(route("apartments.index"))->with("error", "Not available for editing.");
        // dd($apartment);
        return view('landlord.apartments.update')->with(["apartment" => $apartment]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->validate([
            'name' => 'required',
            'location' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'description' => 'required'
        ]);
        $apartment = Auth::user()->apartments()->where(['id'=>$id])->first();
        if ($apartment->update($input))
            return redirect(route('apartments.index'))->with('success', 'Updated successfully.');
        return redirect()->back()->with("error", "failed to update");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $apartment = Auth::user()->apartments()->where(['id'=>$id])->first();
        if ($apartment != null)
        {
            if ($apartment->delete())
                return redirect(route("apartments.index"))->with("success", "Deleted apartment successfully.");
        }
        return redirect(route("apartments.index"))->with("error", "Cannot delete apartment.");
    }
}
