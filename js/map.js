var latitude1 = 0;
var longitude1 = 0;
var latitude2 = 0;
var longitude2 = 0;



function initLocations() {
  var startPoint = $('#trip-from-select').val();
  var destination = $('#trip-to-select').val();
  if (startPoint === 'Alabang') {
    latitude1 = 14.4184;
    longitude1 = 121.0385;
  } else if (startPoint === 'Guinayangan') {
    latitude1 = 13.8377;
    longitude1 = 122.4694;
  }
  if (destination === 'Alabang') {
    latitude2 = 14.4184;
    longitude2 = 121.0385;
  } else if (destination === 'Alaminos') {
    latitude2 = 16.1505;
    longitude2 = 119.9856;
  } else if (destination === 'Atimonan') {
    latitude2 = 13.9966;
    longitude2 = 121.9180;
  } else if (destination === 'Calauag') {
    latitude2 = 14.0593;
    longitude2 = 122.3573;
  } else if (destination === 'Candelaria') {
    latitude2 = 13.9080;
    longitude2 = 121.4228;
  } else if (destination === 'Cubao') {
    latitude2 = 14.6178;
    longitude2 = 121.0572;
  } else if (destination === 'Guinayangan') {
    latitude2 = 13.8377;
    longitude2 = 122.4694;
  } else if (destination === 'Gumaca') {
    latitude2 = 13.8910;
    longitude2 = 122.1065;
  } else if (destination === 'Lopez') {
    latitude2 = 13.8001;
    longitude2 = 122.3108;
  } else if (destination === 'Lucena') {
    latitude2 = 13.9414;
    longitude2 = 121.6234;
  } else if (destination === 'Pagbilao') {
    latitude2 = 13.9849;
    longitude2 = 121.7423;
  } else if (destination === 'SanPablo') {
    latitude2 = 14.0642;
    longitude2 = 121.3233;
  } else if (destination === 'Sariaya') {
    latitude2 = 13.8949;
    longitude2 = 121.5142;
  } else if (destination === 'Siain') {
    latitude2 = 13.9511;
    longitude2 = 122.0200;
  } else if (destination === 'Sto.Tomas') {
    latitude2 = 14.0901;
    longitude2 = 121.1745;
  } else if (destination === 'Tiaong') {
    latitude2 = 13.9541;
    longitude2 = 121.3393;
  }
}

function initThisMap() {
  console.log("Hello");
  var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: (latitude1+latitude2)/2, lng: (longitude1+longitude2)/2},
      zoom: 8
    });

    var markerStart = new google.maps.Marker({
      position: {lat: latitude1, lng: longitude1},
      map: map,
      title: 'Start Point',
      icon: 'img/map-marker-2-24-1.png'
    });

    var markerEnd = new google.maps.Marker({
      position: {lat: latitude2, lng: longitude2},
      map: map,
      title: 'Destination',
      icon: 'img/map-marker-2-24-2.png'
    });
}

function initMap() {
  $('.map-link').click(function (e) {
    $('.gmap-container').css("visibility","visible");
    initLocations();
    initThisMap();
  });
  $('.close-button').click(function (e) {
    $('.gmap-container').css("visibility","hidden");
  });
  $('#map-outside').click(function (e) {
    $('.gmap-container').css("visibility","hidden");
  });
}
