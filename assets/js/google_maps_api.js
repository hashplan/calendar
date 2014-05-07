// This requires consent to location sharing when prompted by browser. 
// If you see a blank space instead of the map, this is probably because permission was denied for location sharing.

var map;

function initialize() {
  var mapOptions = {
    zoom: 11,
	panControl: true,
	panControlOptions: {
        position: google.maps.ControlPosition.TOP_LEFT
		},
    zoomControl: true,
	zoomControlOptions: {
      style: google.maps.ZoomControlStyle.SMALL,
      position: google.maps.ControlPosition.LEFT_CENTER
	  },
    scaleControl: true,
	mapTypeControl: true,
	mapTypeControlOptions: {
      //style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
      style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
	  position: google.maps.ControlPosition.TOP_RIGHT
    },
	streetViewControl: true,
	streetViewControlOptions: {
        //position: google.maps.ControlPosition.TOP_LEFT
    },
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Try HTML5 geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
                                       position.coords.longitude);

      var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos,
        content: 'You!'
      });

      map.setCenter(pos);
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }
}

function handleNoGeolocation(errorFlag) {
  if (errorFlag) {
    var content = 'Error: The Geolocation service failed.';
  } else {
    var content = 'Error: Your browser doesn\'t support geolocation.';
  }

  var options = {
    map: map,
    position: new google.maps.LatLng(60, 105),
    content: content
  };

  var infowindow = new google.maps.InfoWindow(options);
  map.setCenter(options.position);
}

google.maps.event.addDomListener(window, 'load', initialize);