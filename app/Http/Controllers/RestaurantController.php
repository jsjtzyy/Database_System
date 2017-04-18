<?php

namespace App\Http\Controllers;

use App\Dao\Restaurant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Mockery\CountValidator\Exception;

class RestaurantController extends Controller
{
	//create page
	public function create(){
		return view("restaurants.create");
	}

	//store actions
	public function store(Request $request){
		$this -> validate($request,[
			'restaurant_name'     => 'required|string',
			'dish_category' => 'required|string', 
			'content'		 => 'required|string',
			'location'		 =>	'required|string', 
			'Email'			 => 'required|email',
			'phone_number'   => 'required|digits:10',
			'date' 	   		 => 'required|date',
		]);
		$data = $request -> all();
		$data = array_only($data,['restaurant_name','dish_category','content','location','phone_number','Email']);
		$user = Auth::user();
		$data['userID'] = $user->id;
		$data['start_at'] = $request['date'].' '.$request['time'];
		$data['start_at'] = Carbon::parse($data['start_at']);

		Restaurant::create($data);
		return Redirect::route('restaurant.index');
	}

	//list page
	public function index(Request $request){
		$startDate = $request['start_date'];
		$restaurantName = $request['restaurant_name'];
		$restaurants = Restaurant::search($startDate,$restaurantName);
		return view('restaurants.index')->with('restaurants',$restaurants);
	}

	//show page
	public function show(Request $request, $id){
		if(!is_numeric($id)){
			throw new Exception("Please input a number!");
		}
		$restaurant = Restaurant::find($id);
		return view('restaurants.show')->with('restaurant',$restaurant);
	}

	//edit page
	public function edit($id){
		$user = Auth::user();
		$restaurant = Restaurant::find($id);
		if( $restaurant->userID != $user->id){
			throw new Exception(412,"Please do not edit others model");
		}
		return view('restaurants.edit')->with('restaurant',$restaurant);
	}

    //update page
    public function update(Request $request){
    	$this->validate($request,[
    		'id'             => 'required|integer',
            'restaurant_name'     => 'required|string',
            'dish_category' => 'required|string',
            'content'        => 'required|string',
            'location'       => 'required|string',
            'Email'          => 'required|email',
            'phone_number'   => 'required|digits:10',
            'date'           => 'required|date',
            'time'           => 'required|string', 
    		]);
    	 $id = $request['id'];

    	 $user = Auth::user();
    	 $restaurant = Restaurant::find($id);
    	 if ($restaurant->userID != $user->id){
    	 	throw new Exception(412,"Please do not edit others model!");
    	 }
    	 $data = $request->all();
    	 $data = array_only($data,['restaurant_name','dish_category','content','location','phone_number','Email','id']);
    	 $data['start_at'] = $request['date'].' '.$request['time'];
    	 $data['start_at'] = Carbon::parse($data['start_at']);
    	 Restaurant::edit($data);
    	 return Redirect::route('restaurant.index');
	}

	//delete post
	public function destroy ($id){
		$user = Auth::user();
		$restaurant = Restaurant::find($id);
		if($restaurant->userID != $user->id){
			throw new Exception(412,"Please do not delete others model!");
		}
		Restaurant::destroy($id);
		return Redirect::route('restaurant.index');
		
	}
}