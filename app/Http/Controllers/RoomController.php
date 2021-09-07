<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\House;
use App\Models\Apartment;
use Image;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd("show all rooms");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $apartment = Auth::user()->apartments()->where(['id' => $id])->first();
        if ($apartment == null)
            return redirect(route('apartments.index'))
            ->with("info", "Apartment you want to add room for is not availalbe");
        return view('landlord.rooms.create', ['apartment' => $apartment]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Apartment $apartment, Request $request)
    {
        // room_no, bedrooms, bathrooms, image, description
        $apartment = $apartment->first();
        $owner = $apartment->user()->first()->id;
        if ($owner != Auth::user()->id)
            return redirect(route("apartments.index"))->with("error", "Not allowed");
        $values = $request->validate([
            'room_no' => 'required|numeric|min:0',
            'bedrooms' => 'required|numeric|min:0',
            'bathrooms' => 'required|numeric|min:0',
            'image' => 'required|image',
            'description' => 'required'
        ]);
        $apartmentHasSameRoomNo = $apartment->houses()->where(["room_no" => $values["room_no"]])->first();
        if ($apartmentHasSameRoomNo) {
            return redirect()->back()->with("error", "Another room with same room no exists.");
        }
        $updloadedImage = $this->updloadHouseImage($request);
        unset($values["image"]);
        $house = $apartment->houses()->create($values);
        //if house created save uploaded picture to house pictures table
        if ($house){
            $house->pictures()->create(['picture_file' => $updloadedImage]);
            return redirect(route("rooms.show", ['id' => $apartment->id, 'room'=> $house->id]))
            ->with("success", "Added room details successfully.");
        }
        return redirect()->back()->withInput($values)->with("error", "Failed to save new room(house) record.");
    }

    private function updloadHouseImage($request) {
        $path = $request->file("image")->store("houses", "public");
        $thumbPath = $request->file("image")->store("thumbs/houses", "public");
        $this->resizeImage($path);
        $this->createThumbnail($thumbPath);
        return $path;
    }
    private function resizeImage($path) {
        $img = Image::make("storage/".$path);
        $img->resize(1200, 600);
        $img->save();
    }
    private function createThumbnail($path) {
        $img = Image::make("storage/".$path);
        $filePath = public_path("storage");
        $img->resize(110, 110);
        $img->save($filePath.'/'.$path);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $id, House $room)
    {
        $apartment=$id;
        $user_id = $apartment->user->id;
        $a_user_id = Auth::user()->id;
        if ($user_id != $a_user_id)
            return redirect(route("apartments.show", $apartment->id))->with("error", "Not permitted");
        return view("landlord.rooms.details", ['room' => $room]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $room)
    {
        $user = Auth::user();
        $apartment = $user->apartments()->where(["id" => $id])->first();
        if ($apartment != null) {
            $house = $apartment->houses()->where(['id' => $room])->first();
            if ($house != null) {
                if ($house->delete())
                    return redirect(route("apartments.show", $id))->with("success", "Deleted house successfully.");
                else
                    $msg = "Unable to delete house details.";
            } else {
                $msg = "House not available for delete.";
            }
        } else {
            $msg = "Not available for deleting.";
        }
        

        return redirect(route("apartments.index", $id))->with("error", $msg);
    }
}
