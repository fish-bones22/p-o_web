var HEIGHT = 30;
var WIDTH = 32;
var seatHeight = parseInt($('.seat').css('height'));
var seatWidth = parseInt($('.seat').css('width'));
var selected = [];
var reservedSeatsCount = 0;
var tripSelectOptions;
var departureTime;
var busIndex = 0;
var busIndexArray = [0];
var totalSeatsArray = [];
var tripCodeArray = [];
var seatPlan45 = "ssassssassssassssassssassssassssassssassssassssasssssss";
var seatPlan55 = "sssasssssasssssasssssasssssasssssasssssasssssasssssasssssasssssss";

function initFunc() {
  setSeatPlanContainerSize();
  // Build the seatplan
  updateInfos();
  updateSelect();
  updateBusSelect();
  updateMiscInfo();
  buildSeatPlan();
}

function initVar() {
  selected = [];
  reservedSeatsCount = 0;
}

function addSeatListener() {

  // Add click event listener to each seats
  $(".seat").click(function (e) {
    if ($(this).hasClass('occupied')) {
      return;
    }
    var index = parseInt($(this).attr('value'));
    var i = selected.indexOf(index);
    console.log(i);
    if (i === -1) {
      selected.push(index);
      $(e.target).addClass("selected"); // Include div in 'selected' class
    } else {
      selected.splice(i, 1);
      $(e.target).removeClass("selected"); // Remove div in 'selected' class
    }
    updateMiscInfo();
  });
  // Enable popovers on reserved seats
  $('[data-toggle="popover"]').popover();
}

function initListeners() {

  addSeatListener();

  $('.bus-type-radio').change(resetView);
  // FOR DEBUG
  $('input[name=bus-type], #trip-from-select').change(function (e) {
    updateSelect();
    busIndex = $('#bus-select').prop('selectedIndex');
    buildSeatPlan();
    addSeatListener();
  });
  $('#trip-to-select').change(function (e) {
    updateBusSelect();
    busIndex = $('#bus-select').prop('selectedIndex');
    buildSeatPlan();
    addSeatListener();
  });

  $('#trip-to-select').change(function () {
    updateMiscInfo();
  });

  $('#departure-time-select, .date-input').change(function (e) {
    updateBusSelect();
    busIndex = $('#bus-select').prop('selectedIndex');
    buildSeatPlan();
    addSeatListener();
  });

  $('#bus-select').change(function (e) {
    busIndex = $('#bus-select').prop('selectedIndex');
    buildSeatPlan();
    addSeatListener();
  });

  $('#reserve-btn').click(function (e) {
    var str = exportSeatPlan();
    $('.reserved-seats-after').attr('value', str);
    $('.total-seats').attr('value', parseInt(totalSeatsArray[busIndex]));
    $('.trip-code').attr('value', tripCodeArray[busIndex]);
    if (selected.length === 0) {
      $('#empty-selection-alert').show();
      return false;
    } else {
      return true;
    }
  });

  $('.close').click(function (e) {
    $('#empty-selection-alert').hide();
  })
}

function setSeatPlanContainerSize() {
  var seatCol = parseInt($('.seat-col').val());
  $('.seatplan-container').css('min-width', WIDTH*(seatCol+1));
}

function buildSeatPlan() {
  var specialPositioning;
  var seatDetails;
  var totalSeats = parseInt(totalSeatsArray[busIndex]);
  var seatCol = 6;
  var busType = $('input:radio[name=bus-type]:checked').val();
  var reservedSeats = updateSeatPlan().split(",");
  var ordinary45SpecialPositioning = [7, 8, 11, 12, 15, 16, 19, 20, 23, 24];
  var ordinary55SpecialPositioning = [9, 10, 14, 15, 19, 20, 24, 25, 29, 30];
  var seatNum = 0;
  selected = [];
  // initialize special positionings
  if ((totalSeats === 45) && (busType === 'Ordinary'))
    specialPositioning = ordinary45SpecialPositioning;
  else if ((totalSeats === 55) && (busType === 'Ordinary'))
    specialPositioning = ordinary55SpecialPositioning;
  else
    specialPositioning = [];


  // initialize seat plans
  if (totalSeats === 45) {
    seatDetails = seatPlan45;
    seatCol = 5;
  } else {
    seatDetails = seatPlan55;
    seatCol = 6;
  }
  var seatRows = seatDetails.length/seatCol;
  $('.seatplan').empty();
  $('.seatplan').css('height', HEIGHT*seatRows);
  $('.seatplan').css('width', WIDTH*seatCol);
  for (var i = 0; i < seatRows; i++) {
    var row = $(document.createElement('div'));
    row.attr('class', 'bus-row');
    row.css('top', (i*HEIGHT)+'px');
    for (var j = 0; j < seatCol; j++) {
      var charToTest = seatDetails.charAt((i*seatCol)+j);
      var box = $(document.createElement('div'));
      if (charToTest === 's') {
        if (reservedSeats.indexOf(seatNum+"") >= 0) {
          box.attr('class', 'seat occupied');
          box.attr('value', seatNum);
          box.attr('data-toggle', 'popover'); //
          box.attr('data-trigger', 'hover');  // Add popovers to reserved seat
          box.attr('data-placement', 'top');  //
          box.attr('data-content', 'Reserved');
          reservedSeatsCount++;
        } else {
          box.attr('class', 'seat');
          box.attr('value', seatNum); // Set the number of the seat
        }
        seatNum++;
      } else if (charToTest === 'a')
        box.attr('class', 'space');
      // Change positioning of seats if bus type is 'ordinary'
      // before the middle door
      var specialSpacer = 0;
      if (specialPositioning.indexOf(seatNum) >= 0)
        specialSpacer = ((HEIGHT - seatHeight)-4) *i;
      else
        specialSpacer = 0;
      // Change last row positioning
      var widthTemp = WIDTH;
      var lastRowSpacer = 0;
      if ((i >= seatRows-1) && (totalSeats === 55)) {
        widthTemp = (WIDTH*seatCol)/5;
        lastRowSpacer = WIDTH - seatWidth;
      }
      box.css('top', (i*HEIGHT-specialSpacer)+'px');
      box.css('left', (j*widthTemp)+lastRowSpacer+'px');
      row.append(box);
    }
    $('.seatplan').append(row);
  }
}

function updateInfos() {
  var totalSeats = $('.total-seats').val();
  $(".free-seats-info").text("Free seats: " + (totalSeats - reservedSeatsCount - selected.length));
  $(".reserved-seats-info").text("Reserved seats: " + reservedSeatsCount);
  $(".selected-seats-info").text("Selected seats: " + (selected.length));
}

function exportSeatPlan() {
  var str = "";
  for (var i = 0; i < selected.length; i++) {
    str += selected[i]+',';
  }
  //console.log(str.substring(0, str.length - 1));
  return str.substring(0, str.length - 1);
}

function updateSelect() {
  var busType = $('input:radio[name=bus-type]:checked').val();
  var tripFrom = $('#trip-from-select').val();
  var tripTo = $('#trip-to-select').val();
  var firstElementTrip;
  var firstElementTime;
  $('.departure-time-option-guinayangan-a').addClass('hidden');
  $('.departure-time-option-guinayangan-b').addClass('hidden');
  $('.departure-time-option-alabang-a').addClass('hidden');
  $('.departure-time-option-alabang-b').addClass('hidden');
  $('.trip-to-option-alabang').addClass('hidden');
  $('.trip-to-option-guinayangan').addClass('hidden');
  if (tripFrom === "Guinayangan") {
    if (busType === "Aircon") {
      if (tripTo === "Cubao") {
        $('.cubao').removeClass('hidden');
        firstElementTime = $('.cubao').eq(0);
      } else {
        $('.departure-time-option-guinayangan-a').removeClass('hidden');
        firstElementTime = $('.departure-time-option-guinayangan-a').eq(0);
      }
    } else { // if bus is ordinary
      $('.departure-time-option-guinayangan-b').removeClass('hidden');
      $("select > option[value='Cubao']").addClass('hidden');
      firstElementTime = $('.departure-time-option-guinayangan-b').eq(0);
    }
    $('.trip-to-option-guinayangan').removeClass('hidden');
    firstElementTrip = $('.trip-to-option-guinayangan').eq(0);
  } else {
    if (busType === "Aircon") {
      $('.departure-time-option-alabang-a').removeClass('hidden');
      firstElementTime = $('.departure-time-option-alabang-a').eq(0);
    } else { // if bus is ordinary
      $('.departure-time-option-alabang-b').removeClass('hidden');
      firstElementTime = $('.departure-time-option-alabang-b').eq(0);
    }
    $('.trip-to-option-alabang').removeClass('hidden');
    firstElementTrip = $('.trip-to-option-alabang').eq(0);
  }
  $("#departure-time-select").val(firstElementTime.val());
  $("#trip-to-select").val(firstElementTrip.val());
  $("#departure-time-select option").each(function(){
    $(this).siblings("[value='"+ this.value+"']").remove();
  });
}

function updateBusSelect() {
  var depTime = $("#departure-time-select").val();
  var dest = $("#trip-from-select").val();
  var busType = $('input:radio[name=bus-type]:checked').val();
  $('#bus-select').empty();
  busIndexArray = [];
  totalSeatsArray = [];
  tripCodeArray = [];
  //console.log(busArray);
  // index: [    0       1       2      3       4          5      ]
  //        (Bus_No, Bus_Type, Seats, Dept_A, Dept_B, Trip_Code);
  for (var i = 0; i < busArray.length; i++) {
    //console.log(depTime);
    //console.log(busArray[i][4]);
    console.log(busType);
    console.log(busArray[i][1]);
    if (dest === 'Guinayangan') {
      if ((depTime+'' == busArray[i][3]) && (busType === busArray[i][1])) { // index 3 for guinayangan
        //console.log("ok");
        $('#bus-select').append("<option value="+busArray[i][0]+">"+busArray[i][0]+"</option>")
        busIndexArray.push(i);
        totalSeatsArray.push(busArray[i][2]);
        tripCodeArray.push(busArray[i][5]);
      }
    } else {
      if (depTime+'' == busArray[i][4]) { // index 4 for alabang
        //console.log("ok");
        $('#bus-select').append("<option value="+busArray[i][0]+">"+busArray[i][0]+"</option>")
        busIndexArray.push(i);
        totalSeatsArray.push(busArray[i][2]);
        tripCodeArray.push(busArray[i][5]);
      }
    }
  }
}

function updateSeatPlan() {
  var busNum = $('#bus-select').val();
  var dateSelect = $('.date-input').val();
  var timeSelect = $('#departure-time-select').val();
  var seatplan = '';
  // index: [    0     1       2       3        4     ]
  //        (Bus_No, date, DeptTime, status, seatplan);
  for (var i = 0; i < seatPlanArray.length; i++) {
    if ((seatPlanArray[i][0] === busNum) &&
        (seatPlanArray[i][1] === dateSelect) &&
        (seatPlanArray[i][2] === timeSelect)) {
          seatplan += seatPlanArray[i][4]+",";
        }
  }
  seatplan=seatplan.substring(0, seatplan.length - 1);
  return seatplan;
}

function updateMiscInfo() {
  var busType = $('input:radio[name=bus-type]:checked').val();
  var start = $("#trip-from-select").val();
  var dest = $("#trip-to-select").val();
  var j, k, price;
  // index: [   0       1       2        3    ]
  //        (From_G, From_A, O_Price, A_Price);
  if (start === 'Guinayangan')  j = 0;
  else  j = 1;
  if (busType === 'Ordinary')  k = 2;
  else  k = 3;
  for (var i = 0; i < priceArray.length; i++) {
    if (dest === priceArray[i][j])
      price = parseInt(priceArray[i][k])*selected.length;
  }
  $('#price-input').attr('value', price);
  $('.price-p').text('P'+price);
}

function resetView() {
  initVar();
  initFunc();
  initListeners();
}

$(window).ready(function () {
  resetView();
});
