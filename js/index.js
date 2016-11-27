$('.form').find('input, textarea').on('keyup blur focus', function (e) {

  var $this = $(this),
      label = $this.prev('label');

	  if (e.type === 'keyup') {
			if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
    	if( $this.val() === '' ) {
    		label.removeClass('active highlight');
			} else {
		    label.removeClass('highlight');
			}
    } else if (e.type === 'focus') {

      if( $this.val() === '' ) {
    		label.removeClass('highlight');
			}
      else if( $this.val() !== '' ) {
		    label.addClass('highlight');
			}
    }

});

$('.tab a').on('click', function (e) {

  e.preventDefault();
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  target = $(this).attr('href');
  $('.tab-content > div').not(target).hide();
  $(target).fadeIn(600);

});

function initMap() {
  var latitude1 = 14.4184;
  var longitude1 = 121.0385;
  var latitude2 = 13.8377;
  var longitude2 = 122.4694;
  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer;
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: (latitude1+latitude2)/2, lng: (longitude1+longitude2)/2},
    zoom: 8,
    draggable: false,
    scrollwheel: false
  });

  directionsDisplay.setMap(map);
  calculateAndDisplayRoute(directionsService, directionsDisplay);
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
  var guinayangan = new google.maps.LatLng(13.8377, 122.4694);
  var tiaong = new google.maps.LatLng(13.9541, 121.3393);
  var alabang = new google.maps.LatLng(14.4184, 121.0385);
  var waypnt = [{location: tiaong, stopover: false}];

  directionsService.route({
    origin: guinayangan,
    destination: alabang,
    waypoints: waypnt,
    optimizeWaypoints: false,
     provideRouteAlternatives: false,
    travelMode: 'DRIVING'
  },
  function(response, status) {
    if (status === 'OK') {
      directionsDisplay.setDirections(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}
