<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Torann\GeoIP\Facades\GeoIP;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Request;
use Input;
use Auth;
use SplPriorityQueue;
use Carbon\Carbon;
use App\MessageOfferRide;   // important;
use laravelcollective\html;

class PQtest extends SplPriorityQueue 
{ 
    public function compare($priority1, $priority2) 
    { 
        if ($priority1 === $priority2) return 0; 
        return $priority1 < $priority2 ? 1 : -1; 
    } 
} 


class MessageController extends Controller
{
    public function distance($point1, $point2, $unit) {
        $lat1 = $point1[0];$lon1 = $point1[1];
        $lat2 = $point2[0];$lon2 = $point2[1];
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    public function cluster(){  // k-means clustering
        $locs = array(
            array(40.05,-88.16), 
            array(40.11, -88.25),
            array(40.11, -88.20),
            array(40.03, -88.18),
            array(40.07, -88.17),
            array(40.15, -88.15),
            array(40.03, -88.26),
            array(40.08, -88.24),
            array(40.09, -88.16)
            );
        // $clusterNum = 2;
        // $centers = array(
        //     array(40.09, -88.26),
        //     array(40.12, -88.23)
        //     );
        // $iter = 2;
        // $pNum = count($locs);
        // for($i = 0; $i < $iter; ++$i){
        //     $sets = array();
        //     for($j = 0; $j < $pNum; ++$j){
        //         $minDist = 1E10;
        //         $minIndex = -1;
        //         for($k = 0; $k < $clusterNum; $k++){
        //             $curDist = $this->distance($locs[$j], $centers[$k], 'M');
        //             if($curDist < $minDist){
        //                 $minDist = $curDist;
        //                 $minIndex = $k;
        //             }
        //         }
        //         $sets[$minIndex][] = $locs[$j]; // append
        //     }

        //     for($k = 0; $k < $clusterNum; $k++){
        //         $xSum = 0; $ySum = 0;
        //         $arr = $sets[$k];
        //         foreach ( $arr as $point) {
        //             $xSum += $point[0];
        //             $ySum += $point[1];
        //         }
        //         $total = count($sets[$k]);
        //         $centers[$k] = array($xSum/$total, $ySum/$total);
        //     }
        // }
        //echo "<pre>"; print_r($centers); 
        //print_r($sets); echo "</pre>";
        return $locs;
        //return array($sets, $centers);
    }

    public function getDistance(){  // Kruscal MST Alogrithm
        // get distance between origin and destination
        $options = array(
                CURLOPT_RETURNTRANSFER => true,     // return web page
                CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            );
        /*
        $loc = Mapper::location('Siebel');
        $loc1 = strval($loc->getLatitude()) . "," . strval($loc->getLongitude());
        $loc = Mapper::location('Illini Union');
        $loc2 = strval($loc->getLatitude()) . "," . strval($loc->getLongitude());
        */
        $loc1 = "40.05,-88.16";
        $loc2 = "40.15,-88.20";
        $loc3 = "40.11,-88.30";
        $loc4 = "40.09,-88.22";
        $locs = $loc1 . "|" . $loc2 . "|" . $loc3 . "|" . $loc4 ."&";
        $url = "http://maps.googleapis.com/maps/api/distancematrix/json?";
        $url = $url . "origins=". $locs . "destinations=" . $locs . "mode=driving";
        $ch = curl_init($url);
        curl_setopt_array( $ch, $options );
        $request = curl_exec( $ch );
        curl_close( $ch );
        $details = json_decode($request, TRUE); // would be used for TSP problem
        $total = 4;
        $id = array();
        $size = array();
        $locationArray = array($loc1, $loc2, $loc3, $loc4);
        $objPQ = new PQtest(); 
        for ($i = 0; $i < $total; $i++) {
            for($j = $i + 1; $j < $total; $j++){
                $dist = $details['rows'][$i]['elements'][$j]['distance']['value'];
                $objPQ->insert(array($i, $dist, $j),$dist); 
            }
            $id[$i] = -1;
            $size[$i] = 1;
        }
        $res = array();
        $cnt = 0;
        while($cnt < $total - 1){
            $edge = $objPQ->current();
            $node1 = $edge[0];
            $node2 = $edge[2];
            while ( $id[$node1] != -1) {
                $node1 = $id[$node1];
            }
            while ( $id[$node2] != -1) {
                $node2 = $id[$node2];
            }
            if($node1 == $node2) {
                $objPQ->next();
                continue;
            }
            if($size[$node1]<= $size[$node2]){
                $id[$node1] = $node2;
                $size[$node2] += $size[$node1];
            }else{
                $id[$node2] = $node1;
                $size[$node1] += $size[$node2];
            }
            $res[$cnt] = $edge;
            $cnt += 1;
            $objPQ->next();
        }
        return array($res, $locationArray);
        //echo "<pre>"; print_r($details); echo "</pre>";
    }

    public function TSP($mst){ // travelling salesman problem
        $edges = $mst[0];
        $locations = $mst[1]; $locsNum = count($mst[1]);
        $root = 3; // 0, 1, 2, 3
        $path = array();
        $locsNeighbors = array();
        foreach ($edges as $edge) {
            $pt1 = $edge[0];
            $pt2 = $edge[2];
            $locsNeighbors[$pt1][] = $pt2;
            $locsNeighbors[$pt2][] = $pt1;
        }
        $cnt = 0;
        $cache = array($root);
        while($cnt < $locsNum){
            $node = array_pop($cache);
            $path[] = $node;
            ++$cnt;
            if($cnt == $locsNum) break;
            foreach ($locsNeighbors[$node] as $neighbor) {
                if(!in_array($neighbor, $path) && !in_array($neighbor, $cache)){
                    $cache[] = $neighbor;
                }
            }
        }
        //echo "<pre>"; print_r($path); echo "</pre>";
        return $path;
    }
//------------------------------------------------------------------------
//------------------------------------------------------------------------

    public function index()
    {
        $messages = DB::select('SELECT * FROM messageOfferRide ORDER BY msgID');
        $matchUserPairs = 
        DB::select('SELECT m1.userID AS provider, m2.userID AS requestor FROM messageOfferRide m1 JOIN messageOfferRide m2 ON       m1.destination = m2.destination
        WHERE m1.category = ? AND m2.category = ? AND m1.seatsNumber >= m2.seatsNumber AND m1.date = m2.date',['offerRide','requestRide']);
        if (Auth::check()) {
            // $sets = $this->cluster();
            // $res = $this->getDistance();
            // $path = $this -> TSP($res);
            // Mapper::map(
            //     40.11,
            //     -88.25,
            //     [
            //         'zoom' => 16,
            //         'draggable' => true,
            //         'marker' => false,
            //         'center' => true,
            //         'eventAfterLoad' => 'styleMap(maps[0].map);'
            //     ]
            // );
          return view('messages.index',compact('messages', 'matchUserPairs'));//, 'matchUserPairs'
        } else {
          return view('auth.login');
        }
    }

    public function analysis(){
        $locs = $this->cluster();
        $res = $this->getDistance();
        $path = $this -> TSP($res);
        Mapper::map(
            40.11,
            -88.25,
            [
                'zoom' => 16,
                'draggable' => true,
                'marker' => false,
                'center' => true,
                'eventAfterLoad' => 'styleMap(maps[0].map);'
            ]
        );

        return view('messages.analysis',compact('res', 'locs','path'));//
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
        //$option = 1;
        $curLocation = null;
        $loc = null;
        if (Auth::check()) {
            Mapper::map(
                40.11, -88.15,
                [
                    'zoom' => 16,
                    'draggable' => true,
                    'marker' => false,
                    'center' => true,
                    'eventAfterLoad' => 'listenMap(map);'
                ]
            );
            return view('messages.create', compact('curLocation', 'loc'));
        } else {
            return view('auth.login');
        }
    }

    public function createIII(Requests\MessageRequest $request) // get location by clicking on map
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        );
        $data = $request->get('data');
        $tmp = explode(",", $data);
        $dum1 = explode("(", $tmp[0]);
        $lat = $dum1[1];
        $dum1 = explode(")", $tmp[1]);
        $lon = $dum1[0];
        $latlng = strval(trim($lat)).",".strval(trim($lon));
        $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$latlng;
        $ch = curl_init($url);
        curl_setopt_array( $ch, $options );
        $query = curl_exec( $ch );
        curl_close( $ch );
        $details = json_decode($query, TRUE);
        $curLocation = $details['results'][0]['formatted_address'];
        Mapper::map(
                $lat, $lon,
                [
                    'zoom' => 16,
                    'draggable' => true,
                    'marker' => false,
                    'center' => true,
                    'eventAfterLoad' => 'listenMap(map);'
                ]
        );
        $loc = array($lat, $lon);
        return view('messages.create', compact('curLocation', 'loc'));
    }

    public function createIP() // get location by IP
    {

        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        );
        //$location = GeoIP::getLocation();
        //$lat = $location["lat"];
        //$lon = $location["lon"];
        $lat = 40.12;
        $lon = -88.25;
        $latlng = strval($lat).",".strval($lon);
        $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$latlng;
        $ch = curl_init($url);
        curl_setopt_array( $ch, $options );
        $request = curl_exec( $ch );
        curl_close( $ch );
        $details = json_decode($request, TRUE);
        $curLocation = $details['results'][0]['formatted_address'];
        Mapper::map(
                $lat, $lon,
                [
                    'zoom' => 16,
                    'draggable' => true,
                    'marker' => false,
                    'center' => true,
                    'eventAfterLoad' => 'listenMap(map);'
                ]
        );
        $loc = array($lat, $lon);
        return view('messages.create', compact('curLocation', 'loc'));
    }

    public function store(Requests\MessageRequest $request)
    {
        $inputLoc = $request->get('curLocation');
        $loc = Mapper::location($inputLoc);
        dd($loc);
        $coordinate = strval($loc->getLatitude()) . "," . strval($loc->getLongitude());

        DB::insert('insert into messageOfferRide (destination, content, category, date, time, seatsNumber, curLocation, coordinate, userID) 
            values (?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $request->get('destination'), $request->get('content'), $request->get('category'),
                $request->get('date'), $request->get('time'), $request->get('seatsNumber'), $request->get('curLocation'), $coordinate, Auth::user()->id
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
        $inputLoc = $request->get('curLocation');
        $loc = Mapper::location($inputLoc);
        $coordinate = strval($loc->getLatitude()) . "," . strval($loc->getLongitude());

        DB::update('UPDATE messageOfferRide set destination = ?, content = ?, category = ?, date = ?, time = ?, seatsNumber = ?, curLocation = ?, coordinate = ? WHERE msgID = ?',
            [
                $request->get('destination'),$request->get('content'), $request->get('category'), $request->get('date'),
                $request->get('time'), $request->get('seatsNumber'), $request->get('curLocation'), $coordinate, $request->get('msgID')
            ]);
        if (Auth::check()) {
            return redirect('/');
        } else {
            return view('auth.login');
        }
    }
    public function delete($id){
        DB::delete('delete from messageOfferRide WHERE msgID = ?',[$id]);
        if (Auth::check()) {
            return redirect('/');
        } else {
            return view('auth.login');
        }
    }

}
