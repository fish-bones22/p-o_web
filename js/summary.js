function buildSeatPlan() {
  var HEIGHT = 30;
  var WIDTH = 32;
  var seatPlan45 = "ssassssassssassssassssassssassssassssassssassssasssssss";
  var seatPlan55 = "sssasssssasssssasssssasssssasssssasssssasssssasssssasssssasssssss";
  var selected = [];
  var passengerType = [];
  if ($('#passenger-types-listed').val() !== undefined)
    passengerType = ($("#passenger-types-listed").val()).split(",");
  console.log(passengerType);
  var reservedSeatsCount = 0;
  var tripSelectOptions;
  var departureTime;
  var seatHeight = parseInt($('.seat').css('height'));
  var seatWidth = parseInt($('.seat').css('width'));
  var specialPositioning;
  var seatDetails;
  var totalSeats = parseInt($('#total-seats').val());
  var seatCol = 6;
  var busType = $('#bus-type').val();
  var reservedSeats = [];
  if ($('#reserved-seats').val() !== undefined)
    reservedSeats = $('#reserved-seats').val().split(",");
  console.log(reservedSeats);
  var ordinary45SpecialPositioning = [7, 8, 11, 12, 15, 16, 19, 20, 23, 24];
  var ordinary55SpecialPositioning = [9, 10, 14, 15, 19, 20, 24, 25, 29, 30];
  var seatNum = 0;

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
        var ind = reservedSeats.indexOf((seatNum)+"");
        if (ind >= 0) {
          console.log(ind)
          var str = passengerType[ind];
          box.attr('class', 'seat occupied '+str);
          box.attr('value', seatNum);
          box.attr('data-toggle', 'popover'); //
          box.attr('data-trigger', 'hover');  // Add popovers to reserved seat
          box.attr('data-placement', 'top');  //
          box.attr('data-content', seatNum+1);
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
    $('[data-toggle="popover"]').popover();
  }
}
// Send PDF
function genPDF() {
  var fname = $('#fname').val();
  var lname = $('#lname').val();
  var from = $('#trip-from').val();
  var to = $('#trip-to').val();
  var depDate = $('#departure-date').val();
  var depTime = $('#departure-time').val();
  var busType = $('#bus-type').val();
  var busNumber = $('#bus-number').val();
  var totalSeats = $('#total-seats').val();
  var price = $('#price').val();
  var reservation_num = $('#reservation_num').val();
  var passenger_ = $('#passenger-types').val();
  var img2, doc;
  var width = parseInt($('#screen-seatplan').css('width'));
  var height = parseInt($('.summary-container').css('height'));
  var initialMarginX = 10;
  var initialMarginY = 10;
  var x = 0;
  var y = 0;
  var offset = 4;
  // Format passenger type list
  passenger = passenger_.split(",");
  var regular, student, senior, pwd;
  for (var i = 0; i < passenger.length; i++) {
    if (passenger[i].substring(0, 3) === "reg")
      regular = parseInt(passenger[i].substring(3));
    else if (passenger[i].substring(0, 3) === "stu")
      student = parseInt(passenger[i].substring(3));
    else if (passenger[i].substring(0, 3) === "sen")
      senior = parseInt(passenger[i].substring(3));
    else if (passenger[i].substring(0, 3) === "pwd")
      pwd = parseInt(passenger[i].substring(3));
  }
  var passengerString = "";
  if (regular > 0)
    passengerString += regular+" reg, ";
  if (student > 0)
    passengerString += student+" student, ";
  if (senior > 0)
    passengerString += senior+" senior, ";
  if (pwd > 0)
    passengerString += pwd+" pwd, ";
  passengerString = passengerString.substring(0, passengerString.length - 2);
  doc = new jsPDF({
    orientation: 'portrait',
    unit: 'px',
    format: [490, 200]
  });
  doc.setFontSize(20);
  doc.text(10, 20, "P&O Transport Corp.");
  doc.setFontSize(18);
  doc.text(10, 40, "Summary of Transaction");
  doc.setFontSize(15);
  doc.text(30, 60, "Name: "+fname+" "+lname);
  doc.text(30, 80, "From: "+from);
  doc.text(30, 100, "To: "+to);
  doc.text(30, 120, "Date: "+depDate);
  doc.text(30, 140, "Time: "+depTime);
  doc.text(30, 160, "Bus Details:");
  doc.text(35, 180, busNumber+", "+busType+", "+totalSeats+" seats");
  doc.text(30, 200, "Price: P"+price);
  doc.text(30, 220, "Res Num: "+reservation_num);
  doc.text(30, 240, passengerString);
  html2canvas($('#screen-seatplan'), {
    onrendered: function(canvas){
      img2 = canvas.toDataURL("image/jpg");
      doc.addImage(img2,'JPEG', 10, 255);
      doc.save('reservation-'+getDateToday());
    }
  });
  setTimeout(function (e) {
    $('#summary-form').submit();
  }, 5000);
}

function getDateToday() {
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0!
  var yyyy = today.getFullYear();

  if(dd<10)
    dd='0'+dd;
  if(mm<10)
    mm='0'+mm;
  today = mm+'-'+dd+'-'+yyyy;
  return today;
}

$(window).ready(function () {
  buildSeatPlan();

  $('#confirm-reservation-btn').click(function (e) {
    e.preventDefault();
    setTimeout(genPDF, 0);
  });
});
