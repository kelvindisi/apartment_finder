<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function _construct() {
        dd('constructor');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::where("userlevel", "admin")->get();
        return view('admin.admins.index')->with(["admins" => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admins.create');
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
        $admin->userlevel = "admin";
        $admin->update();
        return redirect(route('admins.index'))->with('success', "Created admin account successfully.");
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
        return view("admin.admins.details")->with(["user" => $user]);
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
        return view("admin.admins.update")->with("admin", $user);
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
        $admin = User::where("id", $id)->first();
        if (!$admin)
            return redirect()->back()->with("Admin does not exist.");
        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => ''
        ]);
        if (isset($input['password']) && trim($input['password']) != ""){
            $input_pass = $request->validate(["password" => "min:8|confirmed"]);
            $admin->password = Hash::make($input_pass["password"]);
        }
        if (!$this->validEmail($input['email'], $id))
            return redirect()->back()->with("error", "Email already taken.");
        if (!$this->validPhone($input['phone'], $id))
            return redirect()->back()->with("error", "Phone number already registered.");
        $admin->name = $input["name"];
        $admin->email = $input["email"];
        $admin->phone = $input["phone"];
        if ($admin->update())
            return redirect(route("admins.show", $id))->with("success", "updated details successfully.");
        return redirect()->back()->with("error", "Failed to update admin details.");
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
        $adminsCount = User::where("userlevel", "admin")->count();
        if ($adminsCount == 1) {
            return redirect()->back()->with("error", "You cannot delete the only admin account.");
        }
        $admin = User::where(["userlevel"=>"admin", "id"=>$id])->first();
        if ($admin->delete())
            return redirect(route("admins.index"))->with("success", "Account deleted successfully");
        return redirect()->back()->with("error", "Failed to deleted account.");
    }
}
