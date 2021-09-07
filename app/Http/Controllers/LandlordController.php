<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LandlordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $landlords = User::where("userlevel", "landlord")->get();
        return view('admin.landlords.index')->with(["landlords" => $landlords]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.landlords.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users|numeric',
            'password' => 'required|confirmed|min:8'
        ]);
        $input['password'] = Hash::make($input['password']);
        $admin = User::create($input);
        $admin->userlevel = "landlord";
        $admin->update();
        return redirect(route('landlords.index'))->with('success', "Created lardlords account successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where("id", $id)->first();
        if (!$user)
            return redirect()->back()->with('error', "That user does not exist");
        return view("admin.landlords.details")->with(["user" => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where("id", $id)->first();
        return view("admin.landlords.update")->with("landlord", $user);
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
        $landlord = User::where("id", $id)->first();
        if (!$landlord)
            return redirect()->back()->with("landlord does not exist.");
        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => ''
        ]);
        if (isset($input['password']) && trim($input['password']) != ""){
            $input_pass = $request->validate(["password" => "min:8|confirmed"]);
            $landlord->password = Hash::make($input_pass["password"]);
        }
        if (!$this->validEmail($input['email'], $id))
            return redirect()->back()->with("error", "Email already taken.");
        if (!$this->validPhone($input['phone'], $id))
            return redirect()->back()->with("error", "Phone number already registered.");
        $landlord->name = $input["name"];
        $landlord->email = $input["email"];
        $landlord->phone = $input["phone"];
        if ($landlord->update())
            return redirect(route("landlords.show", $id))->with("success", "updated details successfully.");
        return redirect()->back()->with("error", "Failed to update landlord details.");
    }
    private function validPhone($email, $id) 
    {
        $user = User::where("email", $email)->first();
        if ($user) {
            if ($user->id != $id)
                return false;
        }
        
        return true;
    }
    private function validEmail($phone, $id)
    {
        $user = User::where("phone", $phone)->first();
        if ($user) {
            if ($user->id != $id)
                return false;
        }
        
        return true;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $landlordsCount = User::where("userlevel", "landlord")->count();
        if ($landlordsCount == 1) {
            return redirect()->back()->with("error", "You cannot delete the only landlord account.");
        }
        $landlord = User::where(["userlevel"=>"landlord", "id"=>$id])->first();
        if ($landlord->delete())
            return redirect(route("landlords.index"))->with("success", "Account deleted successfully");
        return redirect()->back()->with("error", "Failed to deleted account.");
    }
}
