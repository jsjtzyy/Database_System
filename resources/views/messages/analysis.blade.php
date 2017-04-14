@extends('app')
@section('content')	

<div align="center">
	<div style="height: 500px; width: 500px;">{!! Mapper::render () !!}</div>
</div>

<a class="more-link-custom" href="/dashboard"><span><i>Return</i></span></a>
<button onclick="cluster()"> Cluster </button>

<script>
	var sets = [[],[]];
	var locs = <?php echo json_encode($locs, JSON_HEX_TAG); ?>;
	var centers = [ [40.09, -88.26],
            		[40.12, -88.23]
            	  ];
    sets[0] = locs;

    var clusterMarkers = [];
    var globalMap = null;
    function deg2rad(deg){
    	return deg * Math.PI / 180;
    } 
    function distance(point1, point2) {
        var lat1 = point1[0];var lon1 = point1[1];
        var lat2 = point2[0];var lon2 = point2[1];
        var theta = lon1 - lon2;
        var dist = Math.sin(deg2rad(lat1)) * Math.sin(deg2rad(lat2)) +  Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * Math.cos(deg2rad(theta));
        dist = Math.acos(dist);
        dist = dist * 180 / Math.PI;
        var miles = dist * 60 * 1.1515;
        return miles;
    }

	function cluster() {
		console.log("Clustering !!");
		sets = [[],[]];
		var clusterNum = 2;
		var minDist = 100000000000;
		var minIndex = -1;
		var curDist = 0;
        for(var j = 0; j < locs.length; ++j){// assign points to centers
            minDist = 100000000000;
            minIndex = -1;
            for(var k = 0; k < clusterNum; k++){
                curDist = distance(locs[j], centers[k]);
                if(curDist < minDist){
                    minDist = curDist;
                    minIndex = k;
                }
            }
            sets[minIndex].push(locs[j]); // append
        }

        for(var k = 0; k < clusterNum; k++){ // update centers
            var xSum = 0; var ySum = 0;
            var arr = sets[k];
            if(arr.length == 0) continue;
            for( var i = 0; i < arr.length; ++i) {
                xSum += arr[i][0];
                ySum += arr[i][1];
            }
            var total = sets[k].length;
            centers[k] = [xSum/total, ySum/total];
        }
        showClustering(globalMap);
	}

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

    function setMapOnAll(map) {
        for (var i = 0; i < clusterMarkers.length; i++) {
          clusterMarkers[i].setMap(map);
        }
        if(map == null) clusterMarkers = [];
    }
	function showClustering(map){

		// var sets = res[0];
		// var centers = res[1];
		var cNum = sets.length;
		var colors = ["58D68D", "3498DB", "FFFF00"];
		var lat = 0, lon = 0;
		setMapOnAll(null);
		for(var i = 0 ; i < cNum; ++i){
			var pNum = sets[i].length;
			for(var j = 0; j < pNum; ++j){
				lat = sets[i][j][0];
				lon = sets[i][j][1];
				//console.log(lat);
				//console.log(lon);
	    		var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + colors[i],
		        new google.maps.Size(21, 34),
		        new google.maps.Point(0,0),
		        new google.maps.Point(10, 34));
				var marker = new google.maps.Marker({
	                position: new google.maps.LatLng(lat,lon), 
	                map: map,
	                icon: pinImage
	            });
	            clusterMarkers.push(marker);
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
            clusterMarkers.push(marker);
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
        globalMap = map;
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
