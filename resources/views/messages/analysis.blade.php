@extends('app')
@section('content')	

<div align="center">
	<div style="height: 500px; width: 500px;">{!! Mapper::render () !!}</div>
</div>

<a class="more-link-custom" href="/dashboard"><span><i>Return</i></span></a>

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
    }
</script>
@endsection
