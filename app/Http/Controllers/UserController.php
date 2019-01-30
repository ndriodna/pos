<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\User;

class UserController extends Controller
{
    public function index()
    {
    	$user = User::orderBy('created_at','DESC')->paginate(10);
    	return view('users.index',compact('user'));
    }

    public function create()
    {
    	$role = Role::orderBy('created_at','DESC')->get();
    	return view('users.create',compact('role'));
    }

    public function store(Request$request)
    {
    	$this->validate($request,[
    		'name' => 'required|string|max:100',
    		'email' => 'required|email|unique:users',
    		'password' => 'required|min:6',
    		'role' => 'required|string|exist:role,name'
    	]);

    	$user = User::findOrCreate([
    		'email' => $request->email
    	],[
    		'name' =>$request->name,
    		'password' => bcrypt($request->password),
    		'status' => true
    	]);
    	$user->assignRole($request->role);
    	return redirect(route('users.index'))->with(['success' => 'User: <strong>' . $user->name . '</strong> DiTambahkan']);
    }

    public function edit($id)
    {
    	$user = User::findOrFail($id);
    	return view('users.edit',compact('users'));
    }

    public function update(Request $request,$id)
    {
    	$this->validate($request,[
    		'name' => 'required|string|max:100',
    		'email' => 'required|email|exist:users,email',
    		'name' => 'nullable|min:6'
    	]);

    	$user = User::findOrFail($id);
    	$password = !empty($request->password) ? bcrypt($request->password):$user->password;
    	$user->update([
    		'name' => $request->name,
    		'password' => $password,
    	]);
    	return redirect(route('users.index'))->with(['success' => 'User: <strong>' .$user->name . '</strong> DiUbah']);
    }

    public function destroy($id)
    {
    	$user = User::findOrFail($id);
    	$user->delete();
    	return redirect()->back()->with(['success' => 'User: <strong>' .$user->name . '</strong> DiHapus']);
    }
}
