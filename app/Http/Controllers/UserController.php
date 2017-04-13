<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Image;
// use Session;

class UserController extends Controller
{
    //
    public function profile() {
    	if (Auth::check()) {
    		return view('profiles.profile', array('user' => Auth::user()));
    	} else {
    		return view('auth.login');
    	}
    }

    public function edit()
    {
    	if (Auth::check()) {
        	return view('profiles.edit', array('user' => Auth::user()));
        } else {
        	return view('auth.login');
        }
    }

    public function update(Request $request){
    	// Handle the user upload of avatar
    	if($request->hasFile('avatar')){
    		$avatar = $request->file('avatar');
    		$filename = time() . '.' . $avatar->getClientOriginalExtension();
    		Image::make($avatar)->resize(300, 300)->save( public_path('media/avatars/' . $filename ) );
    		$user = Auth::user();
    		$user->avatar = $filename;
    		$user->save();
    	}
    	// Session::flash('success', 'Profile image updated.');
    	// return view('profiles.profile', array('user' => Auth::user()));
    	return redirect()->route('profile', array('user' => Auth::user()))
    					 ->with('success','Avatar updated.');
    }
}
