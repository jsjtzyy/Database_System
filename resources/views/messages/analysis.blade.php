@extends('app')
@section('content')	

<div align="center">
	<div style="height: 500px; width: 500px;">{!! Mapper::render () !!}</div>
</div>

<a class="more-link-custom" href="/dashboard"><span><i>Return</i></span></a>
<button onclick="cluster()"> Cluster </button>
<button onclick="match()"> Find potential passengers </button>
{!! Form::open(['url'=>'message/recommend']) !!}
{!! Form::hidden('data', '', array('id' => 'data')) !!}
{!! Form::submit('Generate path', array('class'=>'send-btn')) !!}
{!! Form::close() !!}
<button onclick="showRoute()"> Recommended Route </button>


<script>
	var locs = null;//<?php echo json_encode($riders, JSON_HEX_TAG); ?>;
    var drivers = null;//<?php echo json_encode($drivers, JSON_HEX_TAG); ?>;
    var requestNum = null;//<?php echo json_encode($requestNum, JSON_HEX_TAG); ?>;
    var offerNum = null;//<?php echo json_encode($offerNum, JSON_HEX_TAG); ?>;
    var type = null;//<?php echo json_encode($type, JSON_HEX_TAG); ?>;
    var sets = [];
    // Here we assume first driver is the current user
	var centers = [];
    // if(drivers != null){
    //     for(var i = 0; i < drivers.length; ++i){
    //         sets.push([]);
    //         centers.push(drivers[i]);
    //     }
    // }
    var path = null;
    var edges = null;
    var locationArray = null;
    var clusterMarkers = [];
    var globalMap = null;
    var displayArray = [];
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

    function match() {
        var minDist = 10000000000;
        var minIndex = -1;
        var tmp = 0;
        var user = null;
        setMapOnAll(null);
        if(type == "rider"){
            user = locs[0];

        }else{
            user = drivers[0];
        }
        for(var i = 0; i < centers.length; ++i){
            tmp  = distance(user, centers[i]);
            if(tmp < minDist){
                minDist = tmp;
                minIndex = i;
            }
        }
        var passengers = sets[minIndex];
        var res = "";
        for(var j = 0; j < passengers.length; ++j){
            lat = passengers[j][0];
            lon = passengers[j][1];
            var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + "E74C3C",
            new google.maps.Size(21, 34),
            new google.maps.Point(0,0),
            new google.maps.Point(10, 34));
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat,lon), 
                map: globalMap,
                icon: pinImage
            });
            clusterMarkers.push(marker);
            marker.setMap(globalMap);
            res += lat + "," + lon + "|";
        }
        lat = drivers[minIndex][0];
        lon = drivers[minIndex][1];
        var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + "FFFF00",
        new google.maps.Size(21, 34),
        new google.maps.Point(0,0),
        new google.maps.Point(10, 34));
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat,lon), 
            map: globalMap,
            icon: pinImage
        });
        clusterMarkers.push(marker);
        marker.setMap(globalMap);
        res += lat + "," + lon;

        if(type == 'rider'){
            var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/parking_lot_maps.png';
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(user[0],user[1]),
                animation: google.maps.Animation.DROP, 
                map: globalMap,
                icon: iconBase
            });
            clusterMarkers.push(marker);
            marker.setMap(globalMap);
        }
        document.getElementById('data').setAttribute('value', res); // last is driver
    }

	function cluster() {
		console.log("Clustering !!");
        sets = [];
        for(var i = 0; i < drivers.length; ++i){
            sets.push([]);
        }		
        var clusterNum = drivers.length;
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
		var cNum = sets.length;
		var colors = ["58D68D", "3498DB", "E74C3C", "FFFF00"];
		var lat = 0, lon = 0;
		setMapOnAll(null);
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
	            clusterMarkers.push(marker);
	            marker.setMap(map);
        	}
		}

		for(var i = 0; i < cNum; ++i){
			lat = centers[i][0];
			lon = centers[i][1];
    		var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + colors[3],
	        new google.maps.Size(21, 34),
	        new google.maps.Point(0, 0),
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


    function generate(map)
    {
        globalMap = map;
        var data = <?php echo json_encode($res, JSON_HEX_TAG); ?>;
        path = <?php echo json_encode($path, JSON_HEX_TAG); ?>;
        edges = data[0];
        locationArray = data[1];
        console.log(locationArray);
        clusterMarkers = [];
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
            //marker.setMap(map);
            clusterMarkers.push(marker);
            var arr = node2.split(",");
            var val1 = parseFloat(arr[0]);
            var val2 = parseFloat(arr[1]);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(val1,val2), 
                map: map
            });
            //marker.setMap(map);
            clusterMarkers.push(marker);
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
            displayArray.push(directionsDisplay);
            calculateAndDisplayRoute(directionsService, directionsDisplay, node1, node2);           
        }
    }

    function showRoute() 
    {
        //Clear 
        for(var i = 0; i < displayArray.length; ++i){
            displayArray[i].setMap(null);
        }
        //clusterMarkers[0].setMap(null);
        //clusterMarkers[1].setMap(null);

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
                    map: globalMap,
                    icon: image
                });
                marker.setMap(globalMap);
            }
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});
            directionsDisplay.setMap(globalMap);
            directionsDisplay.setOptions({
                polylineOptions: {
                    strokeWeight: 4,
                    strokeOpacity: 1,
                    strokeColor: 'blue'
                }
            });
            calculateAndDisplayRoute(directionsService, directionsDisplay, node1, node2);
        }
    }
    function styleMap(map)
    {
        locs = <?php echo json_encode($riders, JSON_HEX_TAG); ?>;
        drivers = <?php echo json_encode($drivers, JSON_HEX_TAG); ?>;
        requestNum = <?php echo json_encode($requestNum, JSON_HEX_TAG); ?>;
        offerNum = <?php echo json_encode($offerNum, JSON_HEX_TAG); ?>;
        type = <?php echo json_encode($type, JSON_HEX_TAG); ?>;
        for(var i = 0; i < drivers.length; ++i){
            sets.push([]);
            centers.push(drivers[i]);
        }
        sets[0] = locs;
        //var data = <?php echo json_encode($res, JSON_HEX_TAG); ?>;
        //var path = <?php echo json_encode($path, JSON_HEX_TAG); ?>;
 		// var edges = data[0];
 		// var locationArray = data[1];
 		//console.log(locationArray);
        /*
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
        */
        globalMap = map;
        //Display clustering result
        showClustering(map);
        /*
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
        */
    }
</script>
@endsection
