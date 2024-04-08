<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index')->with('users', $users);
    }

    public function create()
    {
        $roles = DB::table('roles')->get();
        return view('users.create')->with('roles', $roles);
    }
    public function signedusers()
    {
        $urlFirmada = URL::signedRoute('users.index');
        return redirect()->away($urlFirmada);
    }
    public function createusers(){
        $urlFirmada = URL::signedRoute('users.create');
        return redirect()->away($urlFirmada);
    }
    
    public function editusers(string $id){
        $urlFirmada = URL::signedRoute('usersedit',['id' => $id]);
        return redirect()->away($urlFirmada);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50|unique:users',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:8|max:30|confirmed',
            'roles' => 'required|exists:roles,name',
        ]);
        if($validator->fails()) {
            return redirect()->route('signedusers')->withErrors($validator->errors());
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->assignRole($request->roles);
        $user->save();
        return redirect()->route('signedusers')->with('success', 'User created successfully');
    }

    public function edit(String $id)
    {
        $user = User::find($id);
        $roles = DB::table('users')->select('roles.*')->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')->join('roles', 'model_has_roles.role_id', '=', 'roles.id')->where('users.id', '=', $id)->first();
        return view('users.edit')->with('user', $user)->with('roles', $roles);
    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'rol' => 'required|exists:roles,name',
        ]);
        if($validator->fails()) {
            return redirect()->route('signedusers')->withErrors($validator)->withInput();
        }
        $user->removeRole($user->roles->first());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->assignRole($request->rol);
        $user->save();
        return redirect()->route('signedusers')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if($user->id == auth()->user()->id) {
            return redirect()->route('signedusers')->with('error', 'You cannot delete yourself');
        }
        $user->delete();
        return redirect()->route('signedusers')->with('success', 'User deleted successfully');
    }
}
