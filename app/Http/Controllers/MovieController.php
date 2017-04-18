<?php

namespace App\Http\Controllers;

use App\Dao\Movie;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Mockery\CountValidator\Exception;

class MovieController extends Controller
{
	//create page
	public function create(){
		return view("movies.create");
	}

	//store actions
	public function store(Request $request){
		$this -> validate($request,[
			'movie_name'     => 'required|string',
			'movie_category' => 'required|string', 
			'content'		 => 'required|string',
			'location'		 =>	'required|string', 
			'Email'			 => 'required|email',
			'phone_number'   => 'required|digits:10',
			'date' 	   		 => 'required|date',
		]);
		$data = $request -> all();
		$data = array_only($data,['movie_name','movie_category','content','location','phone_number','Email']);
		$user = Auth::user();
		$data['userID'] = $user->id;
		$data['start_at'] = $request['date'].' '.$request['time'];
		$data['start_at'] = Carbon::parse($data['start_at']);

		Movie::create($data);
		return Redirect::route('movie.index');
	}

	//list page
	public function index(Request $request){
		$startDate = $request['start_date'];
		$movieName = $request['movie_name'];
		$movies = Movie::search($startDate,$movieName);
		return view('movies.index')->with('movies',$movies);
	}

	//show page
	public function show(Request $request, $id){
		if(!is_numeric($id)){
			throw new Exception("Please input a number!");
		}
		$movie = Movie::find($id);
		return view('movies.show')->with('movie',$movie);
	}

	//edit page
	public function edit($id){
		$user = Auth::user();
		$movie = Movie::find($id);
		if( $movie->userID != $user->id){
			throw new Exception(412,"Please do not edit others model");
		}
		return view('movies.edit')->with('movie',$movie);
	}

    //update page
    public function update(Request $request){
    	$this->validate($request,[
    		'id'             => 'required|integer',
            'movie_name'     => 'required|string',
            'movie_category' => 'required|string',
            'content'        => 'required|string',
            'location'       => 'required|string',
            'Email'          => 'required|email',
            'phone_number'   => 'required|digits:10',
            'date'           => 'required|date',
            'time'           => 'required|string', 
    		]);
    	 $id = $request['id'];

    	 $user = Auth::user();
    	 $movie = Movie::find($id);
    	 if ($movie->userID != $user->id){
    	 	throw new Exception(412,"Please do not edit others model!");
    	 }
    	 $data = $request->all();
    	 $data = array_only($data,['movie_name','movie_category','content','location','phone_number','Email','id']);
    	 $data['start_at'] = $request['date'].' '.$request['time'];
    	 $data['start_at'] = Carbon::parse($data['start_at']);
    	 Movie::edit($data);
    	 return Redirect::route('movie.index');
	}

	//delete post
	public function destroy ($id){
		$user = Auth::user();
		$movie = Movie::find($id);
		if($movie->userID != $user->id){
			throw new Exception(412,"Please do not delete others model!");
		}
		Movie::destroy($id);
		return Redirect::route('movie.index');
		
	}
}