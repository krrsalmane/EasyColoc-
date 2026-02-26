<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(){
        return view('profile.show',['user' => auth()->user()]);
    }

    public function edit(){
        return view ('profile.edit' , ['user' => auth()->user()]);
    }

    public function update(Request $request){
        $user = auth()->user();
        $request -> validate([
            'name' =>'required|string|max:233',
            'username' =>'nullable|string|max:250|unique:users,username,'.$user->id,
            'email' =>'required|email|unique:users,email,'.$user->id,
            'password'=>'nullable|string|min:9|confirmed',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',]);
        $user->name =$request->name;
        $user->username =$request->username;
        $user->email =$request->email;

        if($request ->filled('password')){
            $user->password = Hash::make($request->password);
        }

        if($request->hasFile('photo')){
            if($user->photo) Storage::disk('public')->delete($user->photo);
            $user->photo = $request->file('photo')->store('photos','public');

        }
        $user->save();
        return redirect()->route('profile.show')->with('success','Profile updated.');
    }
}
