var HEIGHT = 30;
var WIDTH = 32;
var seatHeight = parseInt($('.seat').css('height'));
var seatWidth = parseInt($('.seat').css('width'));
var selected = [];
var passengerTypeSelected = [];
var reservedSeatsCount = 0;
var departureTime;
var totalSeats = 55;
var tripCode;
var seatPlan45 = "ssassssassssassssassssassssassssassssassssassssasssssss";
var seatPlan55 = "sssasssssasssssasssssasssssasssssasssssasssssasssssasssssasssssss";
var currentBusDetails = {};
var currentBusTripCode = {};
var lastSelectedSeatPassengerType = '';

function initFunc() {
  setSeatPlanContainerSize();
  // Build the seatplan
  updateSelect();
  updateBusSelect();
  updateMiscInfo();
  buildSeatPlan();
}

function initVar() {
  selected = [];
  reservedSeatsCount = 0;
  currentBusDetails = {};
  currentBusTripCode = {};
  lastSelectedSeatPassengerType = '';
}

function initAnimations() {
  //easeIn($("#price-container"));
  //easeIn($(".reserve-btn-container"));
  easeOut($("#price-container"));
  easeOut($(".reserve-btn-container"));
}

function addSeatListener() {
  
  // Add click event listener to each seat.
  $(".seat").click(function (e) {
    if ($(this).hasClass('occupied'))
      return;
    var index = parseInt($(this).attr('value'));
    var i = selected.indexOf(index);
    
    $(this).blur(function () {
      $(this).popover('hide');
    });
    if (i === -1) {
        if ($(this).hasClass('pwd')) {
          var b = togglePWDConfirm();
          b.then(function (c) {
            lastSelectedSeatPassengerType = "PWD";
            selected.push(index);
            passengerTypeSelected.push(lastSelectedSeatPassengerType);
            $(e.target).addClass("selected PWD"); // Include div in 'selected' class
            updateMiscInfo();
            updateInfos();
          });
        }
        $(this).popover('show');
        $('.popover-content div').click(function (f) {
          f.preventDefault();
          lastSelectedSeatPassengerType = $(this).text();
          selected.push(index);
          passengerTypeSelected.push(lastSelectedSeatPassengerType);
          $(e.target).addClass("selected "+lastSelectedSeatPassengerType); // Include div in 'selected' class
          updateMiscInfo();
          updateInfos();
        });
    } else {
      $(this).popover('hide');
      $(e.target).removeClass("selected "+passengerTypeSelected[i]); // Remove div in 'selected' class
      selected.splice(i, 1);
      passengerTypeSelected.splice(i, 1);
    }
    updateMiscInfo();
    updateInfos();
  });
  // Enable popovers on reserved seats
  $('.occupied').popover();
  // Enable popovers on pwd seats
  $('.pwd').popover();
  // Enable popovers on available seats
  $('.seat').popover({
    content: $(".seat-dropdown").html(),
    html: true,
    trigger: 'click'
  });
}

function initListeners() {

  addSeatListener();

  $('input[name=bus-type]').change(function (e) {
    initVar();
    updateSelect();
    updateBusSelect();
    buildSeatPlan();
    addSeatListener();
    updateMiscInfo();
  });
  $('#trip-from-select').change(function (e) {
    updateSelect();
    updateBusSelect();
    buildSeatPlan();
    addSeatListener();
  });
  $('#trip-to-select').click(function (e) {
    checkDestSelect();
    updateBusSelect();
    buildSeatPlan();
    addSeatListener();
    updateMiscInfo();
  });

  $('#departure-time-select, .date-input').change(function (e) {
    updateBusSelect();
    buildSeatPlan();
    addSeatListener();
  });

  $('#bus-select').change(function (e) {
    buildSeatPlan();
    addSeatListener();
  });

  $('#reset').click(function(e) {
    buildSeatPlan();
    addSeatListener();
    easeOut($("#price-container"));
    easeOut($(".reserve-btn-container"));
  });

  $('#reserve-btn').click(function (e) {
    var str = exportSeatPlan();
    var str2 = exportPassengerTypes();
    var str3 = exportListedPassengerTypes();
    $('.reserved-seats-after').attr('value', str);
    $('.passenger-type-after').attr('value', str2);
    $('.passenger-type-listed-after').attr('value', str3);
    $('.total-seats').attr('value', totalSeats);
    $('.trip-code').attr('value', tripCode);
    if (selected.length === 0) {
      $('#empty-selection-alert').show();
      return false;
    } else {
      return true;
    }
  });

  $('.close').click(function (e) {
    $('#empty-selection-alert').hide();
  });
}

function setSeatPlanContainerSize() {
  var seatCol = parseInt($('.seat-col').val());
  $('.seatplan-container').css('min-width', WIDTH*(seatCol+1));
}

function buildSeatPlan() {
  var specialPositioning;
  var seatDetails;
  var seatCol = 6;
  var busType = $('input:radio[name=bus-type]:checked').val();
  var busNo = $('#bus-select').val();
  var reservedSeats = updateSeatPlan().split(",");
  var ordinary45SpecialPositioning = [7, 8, 11, 12, 15, 16, 19, 20, 23, 24];
  var ordinary55SpecialPositioning = [9, 10, 14, 15, 19, 20, 24, 25, 29, 30];
  var seatNum = 0;
  reservedSeatsCount = 0;
  selected = [];
  // Get total seats
  totalSeats = parseInt(currentBusDetails[busNo]);
  tripCode = currentBusTripCode[busNo];
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
          box.attr('data-toggle',   'popover');  //
          box.attr('data-trigger',    'hover');  // Add popovers to reserved seat
          box.attr('data-placement',    'top');  //
          box.attr('data-content', 'Reserved');
          reservedSeatsCount++;
        } else {
          box.attr('class', 'seat');
          box.attr('tabindex', 0);
          box.attr('value', seatNum); // Set the number of the seat
        }
        // Add PWD designation in seats 0, 1, 2.
        if (seatNum < 3) {
          box.addClass("pwd");
          if (!box.hasClass("occupied")) {
            box.attr('data-toggle',   'popover');  //
            box.attr('data-trigger',    'hover');  // Add popovers to reserved seat
            box.attr('data-placement',    'top');  //
            box.attr('data-content', 'For PWD only');
          }
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
  updateInfos();
}

function updateInfos() {
  $(".free-seats-info").text("Free seats: " + (totalSeats - reservedSeatsCount - selected.length));
  $(".reserved-seats-info").text("Reserved seats: " + reservedSeatsCount);
  $(".selected-seats-info").text("Selected seats: " + (selected.length));
}
/*
* Export current seatplan into string sequence of seat numbers
* seperated by commas.
# Returns string
*/
function exportSeatPlan() {
  var str = "";
  for (var i = 0; i < selected.length; i++) {
    str += selected[i]+',';
  }
  return str.substring(0, str.length - 1);
}
/*
* Export current seatplan passenger types into string sequence
* seperated by commas.
# Returns string
*/
function exportPassengerTypes() {
  var st = "", pwd = 0, regular = 0, senior = 0, student = 0;
  for (var i = 0; i < passengerTypeSelected.length; i++) {
    if (passengerTypeSelected[i] === "Regular")
      regular++;
    else if (passengerTypeSelected[i] === "Student")
      student++;
    else if (passengerTypeSelected[i] === "Senior")
      senior++;
    else if (passengerTypeSelected[i] === "PWD")
      pwd++;
  }
  if (regular > 0)
    st += "reg"+regular+",";
  if (student > 0)
    st += "stu"+student+",";
  if (senior > 0)
    st += "sen"+senior+",";
  if (pwd > 0)
    st += "pwd"+pwd+",";
  return st.substring(0, st.length-1);
}

function exportListedPassengerTypes() {
  var str = "";
  for (var i = 0; i < passengerTypeSelected.length; i++) {
    str += passengerTypeSelected[i]+',';
  }
  return str.substring(0, str.length - 1);
}
/*
* Update select options when bus-type radio buttons 
* and trip-from select changed, filtering options that
* are not available.
*/
function updateSelect() {
  var busType = $('input:radio[name=bus-type]:checked').val();
  var from = $("#trip-from-select").val();
  var destinationSelect = $("#trip-to-select");
  var timeSelect = $("#departure-time-select");
  var index; // To be used in priceArray
  if (from === "Alabang")
    index = 1;
  else
    index = 0;
  // Update destination select options
  destinationSelect.empty();
  for (var i = 0; i < priceArray.length; i++) {
    // priceArray: [ From_G,   From_A,   O_Price,   A_price]
    var option = new Option(priceArray[i][index], priceArray[i][index]);
    // Filter out blank (null) entries
    if (priceArray[i][index] != "")
      // Filter Cubao trip
      if ((priceArray[i][index] != "Cubao")||(busType != "Ordinary"))
        destinationSelect.append(option);
  }
  // Update time select options
  timeSelect.empty();
  var tripFromObj = mainObject[busType];
  var tripCodeObj = tripFromObj[from];
  for (var tc in tripCodeObj) {
    var time = tripCodeObj[tc]["depTime"];
    timeSelect.append($("<option></option>")
                      .attr("value", time)
                      .text(convertToStandard(time)));
  }
  // Remove duplicate options in time select
  timeSelect.children().each(function() {
    $(this).siblings("[value='"+ this.value+"']").remove();
  });
}
/*
* Check if the destination selected option is 'Cubao'
* to filter out unavailable options.
*/
function checkDestSelect() {
  var dest = $("#trip-to-select").val();

  if (dest === "Cubao") {
    var depTime = $("#departure-time-select").val();
    var timeSelect = $("#departure-time-select");
    var from = $("#trip-from-select").val();
    var busSelect = $('#bus-select');
    timeSelect.empty();

    for (var tc in cubaoCustomSelectObj) {
      var time = cubaoCustomSelectObj[tc]["depTime"];
      timeSelect.append($("<option></option>")
                        .attr("value", time)
                      .text(convertToStandard(time)));
    }

  }
}

function updateBusSelect() {
  var depTime = $("#departure-time-select").val();
  var dest = $("#trip-to-select").val();
  var busType = $('input:radio[name=bus-type]:checked').val();
  var from = $("#trip-from-select").val();
  var busSelect = $('#bus-select');
  var tripFromObj;
  var tripCodeObj;
  busSelect.empty();
  currentBusDetails = {};
  currentBusTripCode = {};
  // Check if selected destination is custom
  if (dest === "Cubao") {
    tripCodeObj = cubaoCustomSelectObj;
  } else {
    tripFromObj = mainObject[busType];
    tripCodeObj = tripFromObj[from];
  }
  for (var tc in tripCodeObj) {
    var time = tripCodeObj[tc]["depTime"];
    var bus = tripCodeObj[tc]["busNo"];
    if (time === depTime) {
      busSelect.append($("<option></option>")
                        .attr("value", bus)
                        .text(bus));
      currentBusDetails[bus] = tripCodeObj[tc]["totalSeats"];
      currentBusTripCode[bus] = tc;
    }
  }
}

function updateSeatPlan() {
  var busNum = $('#bus-select').val();
  var date = $('.date-input').val();
  var time = $('#departure-time-select').val();
  var seatplan = '';
  /*  Structure of seatPlanObj
   *
   * seatPlan = [{
   *   busNo:
   *   depTime:
   *   rDate:
   *   seatPlan:
   * }]
  **/
  for (var i = 0; i < seatPlanArr.length; i++) {
    var sp = seatPlanArr[i];
    if((sp.busNo === busNum) && (sp.depTime === time) &&
       (sp.date === date)) {
         seatplan += sp.seatplan + ",";
         tripCode = sp.tripCode;
       }
  }
  seatplan = seatplan.substring(0, seatplan.length - 1);
  return seatplan;
}

function updateMiscInfo() {
  var busType = $('input:radio[name=bus-type]:checked').val();
  var start = $("#trip-from-select").val();
  var dest = $("#trip-to-select").val();
  var j, k, priceTotal = 0, priceStudent = 0, pricePWD = 0, priceSenior = 0, priceReg = 0, priceEach;
  var numOfReg = 0, numOfStudents = 0, numOfPWD = 0, numOfSenior = 0;
  // index: [   0       1       2        3    ]
  //        (From_G, From_A, O_Price, A_Price);
  if (start === 'Guinayangan')  j = 0;
  else  j = 1;
  if (busType === 'Ordinary')  k = 2;
  else  k = 3;
  for (var i = 0; i < priceArray.length; i++) {
    if (dest === priceArray[i][j]) {
      priceEach = parseInt(priceArray[i][k]);
    }
  }
  for (var i = 0; i < selected.length; i++) {
    if (passengerTypeSelected[i] === "Regular") {
      priceReg += priceEach;
      numOfReg++;
    }
    else if (passengerTypeSelected[i] === "Student") {
      priceStudent += priceEach*(0.8);
      numOfStudents++;
    }
    else if (passengerTypeSelected[i] === "PWD") {
      pricePWD += priceEach*(0.8);
      numOfPWD++;
    }
    else if (passengerTypeSelected[i] === "Senior") {
      priceSenior += priceEach*(0.8);
      numOfSenior++;
    }
  }
  // Empty selection guard
  if (selected.length < 1) {
    easeOut($(".reserve-btn-container"));
    easeOut($("#price-container"));
  } else {
    easeIn($(".reserve-btn-container"));
    easeIn($("#price-container"));
  }
  // Regular
  if (priceReg <= 0) {
    easeOut($(".price-reg"));
  } else {
    var st = "seat";
    if (numOfReg > 1)
      st = "seats";
    $(".price-reg").text("Regular: "+numOfReg + " " + st + " × P" + priceEach);
    easeIn($(".price-reg"));
  }
  // Student
  if (priceStudent <= 0) {
    easeOut($(".price-student"));
  } else {
    var st = "seat";
    if (numOfStudents > 1)
      st = "seats";
    $(".price-student").text("Student: "+numOfStudents + " " + st + " × P" + (priceEach*0.8));
    easeIn($(".price-student"));
  }
    // Senior
  if (priceSenior <= 0) {
    easeOut($(".price-senior"));
  } else {
    var st = "seat";
    if (numOfSenior > 1)
      st = "seats";
    $(".price-senior").text("Senior: "+ numOfSenior + " " + st + " × P" + (priceEach*0.8));
    easeIn($(".price-senior"));
  }
  // PWD
  if (pricePWD <= 0) {
    easeOut($(".price-pwd"));
  } else {
    var st = "seat";
    if (numOfSenior > 1)
      st = "seats";
    $(".price-pwd").text("PWD: "+ numOfPWD + " " + st + " × P" + (priceEach*0.8));
    easeIn($(".price-pwd"));
  }
  $(".price-total").text("Total: P"+(pricePWD+priceReg+priceSenior+priceStudent));
  $("#price-input").attr("value", (pricePWD+priceReg+priceSenior+priceStudent));
}

function convertToStandard(militaryTime) {
  var timeArr = militaryTime.split(":");
  var standardTime = "";
  var hour = parseInt(timeArr[0]);
  var minute = parseInt(timeArr[1]);
  var period;
  if (hour > 12)
    standardTime = (hour-12);
  else
    standardTime = (hour);
  if (hour >= 12)
    period = "pm";
  else
    period = "am";
  if (hour === 0) {
    standardTime = "12";
    period = "am";
  }
  if (minute === 0)
    minute = "00";

  return standardTime+":"+minute+" "+period;
}

function togglePWDConfirm() {
  var dfd = jQuery.Deferred();
  var thisModal = $("#modal-pwd");
  thisModal.modal('show');
  $("#modal-yes-button").click(function (e) {
    thisModal.modal('hide');
    dfd.resolve(1);
    return 1;
  });
  $("#modal-no-button").click(function (e) {
    thisModal.modal('hide');
    return 0;
  });
  return dfd.promise();
}

function easeIn(element) {
  element.removeClass("hidden");
  element.fadeIn(200);
}

function easeOut(element) {
  element.fadeOut(200);
  window.setTimeout(300, function (e) {
    element.addClass("hidden");
  });
}

function resetView() {
  initVar();
  initFunc();
  initListeners();
  initAnimations();
}

$(window).ready(function () {
  resetView();
});
