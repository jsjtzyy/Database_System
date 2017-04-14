@extends('app')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h1>Create a New Post</h1>
    {!! Form::open(['url'=>'message/store']) !!}

	<div class="form-group">
       {!! Form::label('destination','Destination:') !!}
       {!! Form::text('destination',null,['class'=>'form-control']) !!}
   	</div>
   	<div class="form-group">
       {!! Form::label('content','Content:') !!}
       {!! Form::textarea('content',null,['class'=>'form-control']) !!}
   	</div>
    <div class="form-group">
        {!! Form::label('category','Category:') !!}
        {!! Form::select('category',['offerRide' => 'Offer a Ride', 'requestRide' => 'Request a Ride', 
            'Mo' => 'Movie', 'Re' => 'Restaurant'] ,null, 
        		['class' => 'form-control', 'placeholder' => 'Please select a category']) !!}
    </div> 
    <div class="form-group" >
        {!! Form::label('date','Date:') !!}
        {!! Form::text('date',null,['class'=>'form-control', 'data-provide' => 'datepicker', 
                                    'data-date-format' => 'yyyy-mm-dd']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('time','Time:') !!}
        {!! Form::text('time',null,['class'=>'form-control', 'data-provide' => 'timepicker', 
                                    'data-show-meridian' => 'false', 'data-show-seconds' => 'true']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('seatsNumber','Number of Seats:') !!}
        {!! Form::select('seatsNumber',['1' => '1', '2' => '2', '3' => '3', '4' => '4'] ,null, 
        		['class' => 'form-control', 'placeholder' => 'Please select a number']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('curLocation','Current Location:') !!}
        {!! Form::text('curLocation', $curLocation,['class'=>'form-control']) !!}
    </div>
   	<div class="form-group">
       {!! Form::submit('SUBMIT',['class'=>'btn btn-success form-control']) !!}
   	</div>

    {!! Form::close() !!}

    @if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <a class="more-link-custom" href="/dashboard"><span><i>CANCEL</i></span></a>
    <div align="center">
      <div style="height: 500px; width: 500px;">{!! Mapper::render () !!}</div>
    </div>


<!-- <button type="button" onclick="window.location='{{ url("message/createIP") }}'">Use your location</button>
 -->
<button onclick="getLocation()"> Use your current location </button>
{!! Form::open(['url'=>'message/createIII']) !!}
{!! Form::text('data', '', array('id' => 'data')) !!}
{!! Form::submit('Update', array('class'=>'send-btn')) !!}
{!! Form::close() !!}


 <!-- ************************************************************ -->
<script type="text/javascript">

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

var globalMap = null;
var res = null;

function getLocation(){
    var map = globalMap;
    console.log("w3c");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
          var str = "(" + pos.lat + "," + pos.lng + ")";
          document.getElementById('data').setAttribute('value', str);
          map.setCenter(pos);
          coordinate = new google.maps.LatLng(pos.lat,pos.lng);
          if(map.markers == null){
             map.markers = new google.maps.Marker({
                 position: coordinate, 
                 map: map,
                 draggable:true
             });
          }else{
            map.markers.setPosition(coordinate);
          }
        }, function() {
          console.log("do nothing");
        });
      } else {
        // Browser doesn't support Geolocation
        console.log("Browser fails to support Geolocation");
      }
}


function listenMap(map){
  var data = <?php echo json_encode($loc, JSON_HEX_TAG); ?>;
  globalMap = map;
  if(data != null){
     map.markers = new google.maps.Marker({
        position: new google.maps.LatLng(data[0],data[1]), 
        map: map,
        draggable:true
    });
    //marker.setMap(map);
  }
  google.maps.event.addListener(map, 'click', function(event) {
    if(map.markers == null){

       map.markers = new google.maps.Marker({
           position: event.latLng, 
           map: map,
           draggable:true
       });
       res = map.markers.getPosition().toString();
      console.log(res);
      document.getElementById('data').setAttribute('value', res);
      //document.getElementById('whatever-the-id-is').value = res;
    }else{
      map.markers.setPosition(event.latLng);
      res = map.markers.getPosition().toString();
      console.log(event.latLng);
      document.getElementById('data').setAttribute('value', res);
    }
  });
}

</script>  
@endsection