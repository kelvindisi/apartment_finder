<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\House;
use App\Models\HousePicture;
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

    /* Check logged user if is the owener of apartment */
    private function validateOwnership($apartment) {
        // dd($apartment->user);
        $owner = $apartment->user->id;
        if ($owner != Auth::user()->id)
            return redirect(route("apartments.index"))->with("error", "Not allowed");
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $apartment = Apartment::where(['id'=> $id])->first();
        $this->validateOwnership($apartment);
        $values = $request->validate([
            'room_no' => 'required|numeric|min:0',
            'bedrooms' => 'required|numeric|min:0',
            'bathrooms' => 'required|numeric|min:0',
            'image' => 'required|image',
            'description' => 'required'
        ]);
        
        $apartmentHasSameRoomNo = $apartment->houses()->where(["room_no" => $values["room_no"]])->count();
        if ($apartmentHasSameRoomNo > 0) {
            return redirect()->back()->withInput($values)->with("error", "Another room with same room no exists.");
        }

        $updloadedImage = $this->updloadHouseImage($request);
        unset($values["image"]);
        $house = $apartment->houses()->create($values);
        //if house created save uploaded picture to house pictures table
        if ($house){
            return $this->houseImageUploaded($house, $apartment->id, $updloadedImage);
        }
        return redirect()->back()->withInput($values)->with("error", "Failed to save new room(house) record.");
    }
    /* 
        Called when image has been uploaded 
        Saves to the database (house pictures table)
    */
    private function houseImageUploaded(House $house, $apartment_id, $updloadedImage)
    {
        $house->pictures()->create(['picture_file' => $updloadedImage]);
        return redirect(route("rooms.show", ['id' => $apartment_id, 'room'=> $house->id]))
            ->with("success", "Added room details successfully.");
    }
    /*
        Should upload and return the path of file
    */
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
    /*
        Should udate database and redirect user
    */
    public function userUploadImage($apartment_id, $room_id, Request $request)
    {
        $apartment = Apartment::where(["id" => $apartment_id])->first();
        $this->validateApartment($apartment);
        $this->validateOwnership($apartment);

        $house = $apartment->houses()->where(["id" => $room_id])->first();
        $this->validateHouse($house);
        
        $request->validate([
            'image' => 'required|image'
        ]);
        $updloadedImage = $this->updloadHouseImage($request);
        return $this->houseImageUploaded($house, $apartment_id, $updloadedImage);
    }
    private function createThumbnail($path) {
        $img = Image::make("storage/".$path);
        $filePath = public_path("storage");
        $img->resize(110, 110, function($const) {
            $const->aspectRatio();
        });
        $img->save($filePath.'/'.$path);
    }
    private function roomRedirector($message)
    {
        return redirect(route("apartments.index"))->with("error", $message);
    }
    private function validateHouse($house)
    {
        if ($house == null)
            $this->roomRedirector("House you wan't to upload pictures for is not available.");
    }
    private function validateApartment($apartment)
    {
        if ($apartment == null)
            $this->roomRedirector("Apartment you wan't to upload pictures for is not available.");
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
    public function edit(House $house)
    {
        $house = $house->first();
        return view("landlord.rooms.update",["room" => $house]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $id, House $room)
    {
        $apartment = $id;
        if ($apartment->id != $room->apartment->id)
            return redirect(route("aparment.show", $apartment->id))
            ->with("error", "Failed because of invalid update.");
        $input = $request->validate([
            'room_no' => 'required|numeric|min:0',
            'bedrooms' => 'required|numeric|min:0',
            'bathrooms' => 'required|numeric|min:0',
            'description' => 'required'
        ]);
        $params = [$apartment->id, $room->id];
        if (!$this->checkRoomValidity($room, $input["room_no"]))
            return redirect(route("rooms.edit", $params))
                ->withInput($input)->with("error", "House with same room number exists.");
        if ($room->update($input))
            return redirect(route("rooms.show", $params))->with("success", "Updated details successfully.");
        return redirect(route("rooms.edit", $params))
            ->withInput($input)->with("error", "Unable to update details.");
    }
    public function checkRoomValidity(House $room, $roomNo)
    {
        $fetchedRoom = House::where(["room_no" => $roomNo])->first();
        if ($fetchedRoom != null)
        {
            if ($fetchedRoom->id != $room->id)
                return false;
        }

        return true;
    }
    public function deleteImage(House $room, $id){
        $image = $room->pictures()->where(['id' => $id])->first();
        $params = ['id' => $room->apartment->id, 'room' => $room->id];
        if($image == null)
            return redirect(route("rooms.show", $params))->with("info", "Seems can't find the image.");
        $picture_file = $image->picture_file;
        $room = $image->house;
        $apartment = $room->apartment;
        $this->validateOwnership($image->house->apartment);
        Storage::delete([$image->picture_file, 'thumbs/'.$picture_file]);
        $image->delete();

        return redirect(route("rooms.show", $params))
            ->with("success", "Deleted image successfully.");
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
