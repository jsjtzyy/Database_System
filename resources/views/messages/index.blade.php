@extends('layouts.app')
@section('content')
	
	@foreach($messages as $message)
	<article class="format-image group">
	    <h2 class="post-title pad">
	        <a href="/messages/{{ $message->msgID }}"> {{ $message->destination }}</a>
	    </h2>
	    <div class="post-inner">
	        <div class="post-deco">
	            <div class="hex hex-small">
	                <div class="hex-inner"><i class="fa"></i></div>
	                <div class="corner-1"></div>
	                <div class="corner-2"></div>
	            </div>
	        </div>
	        <div class="post-content pad">
	            <div class="entry custome">
	                {{ $message->content }}
	            </div>
				<a class="more-link-custom" href="message/edit/{{ $message->msgID }}"><span><i>Edit</i></span></a>
			</div>
	    </div>
	</article>
	<form action="{{ $message->msgID }}" method="POST">
		{{ csrf_field() }}
		{{ method_field('DELETE') }}
		<button type="submit" class="btn btn-danger">Delete</button>
	</form>
    @endforeach
	<a class="more-link-custom" href="/message/create"><span><i>NEW POST</i></span></a>
	<a class="more-link-custom" href="/message/search"><span><i>SEARCH</i></span></a>
	@foreach($matchUserPairs as $pair)
		<article class="format-image group">
			<h2 class="post-title pad"> Potential pairs:</h2>
			<div class="post-inner">
				<div class="post-content pad">
					<div class="entry custome">
						Provider userID: {{ $pair->provider }}; Requestor userID:  {{ $pair->requestor }}
					</div>
				</div>
			</div>
		</article>
	@endforeach

<div style="height: 500px; width: 500px;">{!! Mapper::render () !!}</div>

<script>
	function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
	  directionsService.route({
	    origin: pointA,
	    destination: pointB,
	    travelMode: google.maps.TravelMode.DRIVING
	  }, function(response, status) {
	    if (status == google.maps.DirectionsStatus.OK) {
	      directionsDisplay.setDirections(response);
	    } else {
	      window.alert('Directions request failed due to ' + status);
	    }
	  });
	}
	function showClustering(map){
		var res = <?php echo json_encode($sets, JSON_HEX_TAG); ?>;
		var sets = res[0];
		var centers = res[1];
		var cNum = sets.length;
		var colors = ["58D68D", "3498DB", "FFFF00"];
		var lat = 0, lon = 0;
		for(var i = 0 ; i < cNum; ++i){
			var pNum = sets[i].length;
			for(var j = 0; j < pNum; ++j){
				lat = sets[i][j][0];
				lon = sets[i][j][1];
	    		var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + colors[i],
		        new google.maps.Size(21, 34),
		        new google.maps.Point(0,0),
		        new google.maps.Point(10, 34));
				var marker = new google.maps.Marker({
	                position: new google.maps.LatLng(lat,lon), 
	                map: map,
	                icon: pinImage
	            });
	            marker.setMap(map);
        	}
		}
		for(var i = 0; i < 2; ++i){
			lat = centers[i][0];
			lon = centers[i][1];
    		var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + colors[2],
	        new google.maps.Size(21, 34),
	        new google.maps.Point(0,0),
	        new google.maps.Point(10, 34));
			var marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat,lon), 
                map: map,
                icon: pinImage
            });
            marker.setMap(map);
		}
	}
    function styleMap(map)
    {
    	/*
    	var pinColor = "300569";
    	var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
        new google.maps.Size(21, 34),
        new google.maps.Point(0,0),
        new google.maps.Point(10, 34));

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(40.21,-88.25), 
            map: map,
            icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'//pinImage
        });
        marker.setMap(map);
		*/
        /*var styles = [
        {"featureType":"all","elementType":"Marker","stylers":[{"saturation":36},{"color":"#010000"},{"lightness":40}]},
        */
        /*{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#100000"},{"lightness":16}]},
        {"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},
        {"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},
        {"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},
        {"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},
        {"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},
        {"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},
        {"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},
        {"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},
        {"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},
        {"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},
        {"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}
        */
        //];
        
        var data = <?php echo json_encode($res, JSON_HEX_TAG); ?>;
        var path = <?php echo json_encode($path, JSON_HEX_TAG); ?>;
 		var edges = data[0];
 		var locationArray = data[1];
 		console.log(locationArray);
        for (var i = 0; i < edges.length; i++) {
        	var edge = edges[i];
        	var node1 = locationArray[edge[0]];
        	var node2 = locationArray[edge[2]];
        	var arr = node1.split(",");
        	var val1 = parseFloat(arr[0]);
        	var val2 = parseFloat(arr[1]);
        	var marker = new google.maps.Marker({
                position: new google.maps.LatLng(val1,val2), 
                map: map
            });
            marker.setMap(map);
			var arr = node2.split(",");
            var val1 = parseFloat(arr[0]);
        	var val2 = parseFloat(arr[1]);
        	var marker = new google.maps.Marker({
                position: new google.maps.LatLng(val1,val2), 
                map: map
            });
            marker.setMap(map);
			var directionsService = new google.maps.DirectionsService;
        	var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});
        	directionsDisplay.setMap(map);
        	directionsDisplay.setOptions({
	            polylineOptions: {
	                strokeWeight: 4,
	                strokeOpacity: 1,
	                strokeColor: 'red'
	            }
        	});
			calculateAndDisplayRoute(directionsService, directionsDisplay, node1, node2);			
        }
        
        //Display clustering result
        showClustering(map);

        //Display TSP Route path
		for (var i = 0; i < path.length - 1; i++) {
			var node1 = locationArray[path[i]];
        	var node2 = locationArray[path[i+1]];
        	if(i == 0){
	        	var arr = node1.split(",");
	        	var val1 = parseFloat(arr[0]);
	        	var val2 = parseFloat(arr[1]);
	        	var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
	        	var marker = new google.maps.Marker({
	                position: new google.maps.LatLng(val1,val2), 
	                animation: google.maps.Animation.DROP,
	                map: map,
	                icon: image
	            });
	            marker.setMap(map);
        	}
			var directionsService = new google.maps.DirectionsService;
        	var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});
        	directionsDisplay.setMap(map);
        	directionsDisplay.setOptions({
	            polylineOptions: {
	                strokeWeight: 4,
	                strokeOpacity: 0.5,
	                strokeColor: 'blue'
	            }
        	});
			calculateAndDisplayRoute(directionsService, directionsDisplay, node1, node2);
		}

        // var start = ['40.11,-88.25', '40.11,-88.25'];
        // var end = ['40.07,-88.21', '40.15,-88.21'];
        // var directionsService = new google.maps.DirectionsService;
        // 	var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});
        // 	directionsDisplay.setMap(map);
        // 	     directionsDisplay.setOptions({
        //     polylineOptions: {
        //         strokeWeight: 4,
        //         strokeOpacity: 1,
        //         strokeColor: 'red'
        //     }
        // });
        	// directionsService.route({
		       //    origin: start,//'40.11,-88.25',//document.getElementById('start').value,
		       //    destination: end,//'40.07,-88.21',//document.getElementById('end').value,
		       //    travelMode: 'DRIVING',
		       //  	}, function(response, status) {
		       //    if (status === 'OK') {
		       //      directionsDisplay.setDirections(response);
		       //    } else {
		       //      window.alert('Directions request failed due to ' + status);
		       //    }
        	// }

        	// );
			
        	     //var directionsService = new google.maps.DirectionsService;
        	//var directionsDisplay = new google.maps.DirectionsRenderer;

        /*
        directionsService.route({
          origin: 'Capstone Quarters',//document.getElementById('start').value,
          destination: 'Illini Union',//document.getElementById('end').value,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });*/


        //marker.setOptions({styles: styles});
    }
</script>
<!--
<script type="text/javascript">

    function onMapLoad(map)
    {   
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    var marker = new google.maps.Marker({
                      position: pos,
                      map: map,
                      title: "Location found."
                    });

                    map.setCenter(pos);
                }
            );
        }
    }
</script>
-->
@endsection
