<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Image;
// use Session;

class UserController extends Controller
{
    //
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

    public function profile($id) {
        $user = DB::select('SELECT * FROM users WHERE id = ?', [$id]);
        $ride = DB::select('SELECT * FROM messageOfferRide WHERE userID = ? and (category = ? or category = ?) ORDER BY msgID', 
                            [$id, 'offerRide', 'requestRide']);
        $movie = DB::select('SELECT * FROM movies WHERE userID = ? ORDER BY id', 
                            [$id]);
        $restaurant = DB::select('SELECT * FROM restaurants WHERE userID = ? ORDER BY id', 
                                [$id]);
            
        $matchUsers = DB::select('SELECT users.id AS id, users.name AS name, m2.category AS category
                                  FROM messageOfferRide m1 JOIN messageOfferRide m2 JOIN users ON m1.destination = m2.destination AND users.id = m2.userID
                                  WHERE m1.userID = ? AND ((m1.category = ? AND m2.category = ? AND m1.seatsNumber >= m2.seatsNumber) OR (m1.category = ? AND m2.category = ? AND m1.seatsNumber <= m2.seatsNumber)) AND m1.date = m2.date',[$id,'offerRide','requestRide','requestRide','offerRide']);
        
        $simUsers = DB::select('SELECT T.ID, T.name, 2*T.Cnt / ((SELECT SUM(T1.num) FROM
                                (SELECT userID, POWER(Count(*),2) as num FROM posts GROUP BY userID, post_category) as T1 WHERE T1.userID = ?) 
                              + (SELECT SUM(T2.num) FROM 
                                (SELECT userID, POWER(Count(*),2) as num FROM posts GROUP BY userID, post_category) as T2 WHERE T2.userID = T.ID)) AS sim
                                FROM (SELECT m2.userID as ID, COUNT(*) as Cnt, u.name as name FROM posts m1, posts m2, users u
                                WHERE m2.userID <> m1.userID AND m1.post_category = m2.post_category AND m1.userID = ?  AND m2.userID = u.id Group BY m2.userID) as T 
                                Group by T.ID ORDER BY sim DESC LIMIT 5', [$id, $id]);

        if (Auth::check()) {
            return view('profiles.profile', array('user' => $user[0], 'rides' => $ride, 'movies' => $movie, 'restaurants' => $restaurant, 'simusers' => $simUsers, 'matchusers' => $matchUsers));
        } else {
            return view('auth.login');
        }
    }

}
