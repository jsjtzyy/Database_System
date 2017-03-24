<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Request;
use Auth;
use Carbon\Carbon;
use App\MessageOfferRide;   // important;
use laravelcollective\html;
class MessageController extends Controller
{
    public function index()
    {
        //$articles = Article::all();
        $messages = DB::select('SELECT * FROM messageOfferRide ORDER BY msgID');
        $matchUserPairs = 
        DB::select('SELECT m1.userID AS provider, m2.userID AS requestor FROM messageOfferRide m1 JOIN messageOfferRide m2 ON 		m1.destination = m2.destination
        WHERE m1.category = ? AND m2.category = ? AND m1.seatsNumber >= m2.seatsNumber AND m1.date = m2.date',['offerRide','requestRide']);
        //$articles = Article::latest()->get();
        if (Auth::check()) {
          return view('messages.index',compact('messages', 'matchUserPairs'));//, 'matchUserPairs'
        } else {
          return view('auth.login');
        }
    }

    public function search()
    {
    	if (Auth::check()) {
        	return view('messages.search');
        } else {
        	return view('auth.login');
        }
    }

    public function result()
    {
        $input = Request::all();
        if(is_null($input)){
            return redirect('message/search');
        }
        $dest = Request::get('destination');
        $date = Request::get('date');
        $seatsNum = Request::get('seatsNumber');
        $messages = DB::select('SELECT * FROM messageOfferRide WHERE destination = ? AND date = ? AND seatsNumber >= ? AND category = ?', [$dest, $date, $seatsNum, 'offerRide']);
        $users = DB::select('SELECT * FROM users 
                              WHERE id IN (
                                SELECT userID FROM messageOfferRide
                                WHERE category = ? AND destination = ? AND date = ? AND seatsNumber >= ?
                              )', ['offerRide', $dest, $date, $seatsNum]);
        if (Auth::check()) {
        	return view('messages.searchResults',compact('messages', 'users'));
        } else {
        	return view('auth.login');
        }
        //return redirect('/');
    }

    public function show($id)
    {
        $messages = DB::select('SELECT * FROM messageOfferRide WHERE msgID = ?', [$id]);
        if(is_null($messages)){
            abort(404);
        }
        if (Auth::check()) {
        	return view('messages.show',compact('messages'));
        } else {
        	return view('auth.login');
        }
    }

    public function create()
    {
    	if (Auth::check()) {
        	return view('messages.create');
        } else {
        	return view('auth.login');
        }
    }

    public function store(Requests\MessageRequest $request)
    {

        DB::insert('insert into messageOfferRide (destination, content, category, date, time, seatsNumber, curLocation, userID) 
            values (?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $request->get('destination'), $request->get('content'), $request->get('category'),
                $request->get('date'), $request->get('time'), $request->get('seatsNumber'), $request->get('curLocation'), Auth::user()->id
            ]);
        if (Auth::check()) {
        	return redirect('/');
        } else {
        	return view('auth.login');
        }
    }

    public function edit($id)
    {
        $messages =  DB::select('SELECT * FROM messageOfferRide WHERE msgID = ?', [$id]);
        if(is_null($messages)){
            redirect('/');
        }
        if (Auth::check()) {
        	return view('messages.edit',compact('messages'));
        } else {
        	return view('auth.login');
        }
    }

    public function update(Requests\MessageRequest $request)
    {
        DB::update('UPDATE messageOfferRide set destination = ?, content = ?, category = ?, date = ?, time = ?, seatsNumber = ?, curLocation = ? WHERE msgID = ?',
            [
                $request->get('destination'),$request->get('content'), $request->get('category'), $request->get('date'),
                $request->get('time'), $request->get('seatsNumber'), $request->get('curLocation'), $request->get('msgID')
            ]);
       /* $matchUserPair = DB::select('SELECT m1.userID AS provider, m2.userID AS requester FROM messageOfferRide m1 JOIN messageOfferRide m2 ON m1.destination = m2.destination
        				WHERE m1.category = ? AND m2.category = ? AND m1.seatsNumber >= m2.seatsNumber',['offerRide','requestRide']);
        				*/
        if (Auth::check()) {
        	return redirect('/');
        } else {
        	return view('auth.login');
        }
    }
    public function delete($id){
        //$message = MessageOfferRide::findOrFail($id);
        DB::delete('delete from messageOfferRide WHERE msgID = ?',[$id]);
        //$message -> delete();
        if (Auth::check()) {
        	return redirect('/');
        } else {
        	return view('auth.login');
        }
    }

}
