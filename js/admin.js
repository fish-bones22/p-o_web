$(window).ready(function () {

	// transaction table
	var isEditingAbout = false;
	var isEditingPayment = false;
	var isEditingTrip = false;
	var confirmPendingList = [];
	var tempSmartVal = $('#smart-number-input').val();
	var tempMobileVal =  $('#mobile-number-input').val();
	var tempAboutVal = $('#about-input').text();
	var tempFBVal =  $('#fb-link-input').val();
	var tempEmailVal =  $('#email-input').val();

	$('.confirm-payment-btn').click(function (e) {
		var value = $(this).parent().parent().attr('id');
		$(this).siblings().removeClass('hidden');
		$(this).addClass('hidden');
		confirmPendingList.push(value);
		$('#reserve-number-length').val(confirmPendingList.length);
		var newInput = $(document.createElement('input'));
		newInput.attr('type', 'hidden');
		newInput.attr('name', 'reserve-number-'+(confirmPendingList.length-1));
		newInput.attr('class', 'reserve-number-inputs');
		newInput.attr('value', value);
		$('#hidden-inputs').append(newInput);

		var receipt;
		var fname = $('#'+value+'-fname').val();
		var lname = $('#'+value+'-lname').val();
		var busNumber = $('#'+value+'-busno').val();
		var email = $('#'+value+'-email').val();
		var number = $('#'+value+'-phone').val();
		var route = $('#'+value+'-route').val();
		var deptime = $('#'+value+'-time').val();
		var seatNum = $('#'+value+'-seat').val();

		var pdf = genPDF(value, receipt, fname, lname, busNumber, email, number, route, seatNum);
		saveFileToServer(pdf, value);
		console.log(fname);
		console.log(lname);
		console.log(busNumber);
		console.log(email);
		console.log(number);
		console.log(route);
		console.log(deptime);
		console.log(seatNum);
	});

	$('#reserve-cancel-btn').click(function (e) {
		$('.confirm-payment-btn').removeClass('hidden');
		$('.pending-label').addClass('hidden');
		confirmPendingList = [];
		$('#reserve-number-length').val(0);
		var inputs = $('.reserve-number-inputs');
		var parent = inputs.parent();
		inputs.remove();

		console.log(confirmPendingList);
	});

	//about
	$('#edit-about-btn').click(function () {
			// edit
		if (!isEditingAbout) {
			$('.front-page-settings-input').removeAttr('disabled');
			$('#edit-about-btn').html("<span class=\"glyphicon glyphicon-ok\"></span> Cancel");
			$('#edit-about-btn span').removeClass('glyphicon glyphicon-edit');
			$('#edit-about-btn span').addClass('glyphicon glyphicon-remove');
			$("#save-about-btn").removeClass('hidden');
			//cancel
		} else {
			$('.front-page-settings-input').attr('disabled', '');
			$('#edit-about-btn').html("<span class=\"glyphicon glyphicon-ok\"></span> Edit");
			$('#edit-about-btn span').removeClass('glyphicon glyphicon-remove');
			$('#edit-about-btn span').addClass('glyphicon glyphicon-edit');
			$('#save-about-btn').addClass('hidden');
			$('#about-input').val(tempAboutVal);
			$('#fb-link-input').val(tempFBVal);
			$('#email-input').val(tempEmailVal);
		}
		isEditingAbout = !isEditingAbout;
	});
	//trip
	$('#edit-trip-settings-btn').click(function () {
			// edit
		if (!isEditingTrip) {
			$('.trip-settings-input').removeAttr('disabled');
			$('#edit-trip-settings-btn').html("<span class=\"glyphicon glyphicon-ok\"></span> Cancel");
			$('#edit-trip-settings-btn span').removeClass('glyphicon glyphicon-edit');
			$('#edit-trip-settings-btn span').addClass('glyphicon glyphicon-remove');
			$("#save-trip-settings-btn").removeClass('hidden');
			//cancel
		} else {
			$('.trip-settings-input').attr('disabled', '');
			$('#edit-trip-settings-btn').html("<span class=\"glyphicon glyphicon-ok\"></span> Edit");
			$('#edit-trip-settings-btn span').removeClass('glyphicon glyphicon-remove');
			$('#edit-trip-settings-btn span').addClass('glyphicon glyphicon-edit');
			$('#save-trip-settings-btn').addClass('hidden');
		}
		isEditingTrip = !isEditingTrip;
	});
	//payment
	$('#edit-payment-settings-btn').click(function () {
			// edit
		if (!isEditingPayment) {
			$('.payment-settings-input').removeAttr('disabled');
			$('#edit-payment-settings-btn').html("<span class=\"glyphicon glyphicon-ok\"></span> Cancel");
			$('#edit-payment-settings-btn span').removeClass('glyphicon glyphicon-edit');
			$('#edit-payment-settings-btn span').addClass('glyphicon glyphicon-remove');
			$('#save-payment-settings-btn').removeClass('hidden');
			//cancel
		} else {
			$('.payment-settings-input').attr('disabled', '');
			$('#edit-payment-settings-btn').html("<span class=\"glyphicon glyphicon-ok\"></span> Edit");
			$('#edit-payment-settings-btn span').removeClass('glyphicon glyphicon-remove');
			$('#edit-payment-settings-btn span').addClass('glyphicon glyphicon-edit');
			$('#save-payment-settings-btn').addClass('hidden');
			$('#smart-number-input').val(tempSmartVal);
			$('#mobile-number-input').val(tempMobileVal);
		}
		isEditingPayment = !isEditingPayment;
	});

	// modal
	$('#modal-yes-button').click(function (e) {
		$('#mobile-number-input-after').attr('value', $('#mobile-number-input').val());
		$('#smart-number-input-after').attr('value', $('#smart-number-input').val());
		//$('#about-input-after').attr('value', $('#about-input').val());
		$('#fb-link-input-after').attr('value', $('#fb-link-input').val());
		$('#email-input-after').attr('value', $('#email-input').val());
		for (var i = 0; i < confirmPendingList.length; i++) {
			var newInput = $(document.createElement('input'));
			newInput.attr('name', "reserve-number-input-"+i);
			newInput.attr('type', 'hidden');
			newInput.attr('value', confirmPendingList[i]);
			$('#inputform').append(newInput);
		}
		$('#reserve-number-length').attr('value', confirmPendingList.length);
		console.log(confirmPendingList);
		$('#inputform').submit();
	});
});
// Send PDF
function genPDF(resnum, receipt, fname, lname, busNumber, email, number, route, seatNum) {
	var initialMarginX = 10;
	var initialMarginY = 10;
	var x = 0;
	var y = 0;
	var offset = 4;
	doc = new jsPDF({
		orientation: 'portrait',
		unit: 'px',
		format: [210, 200]
	});
	doc.setFontSize(20);
	doc.text(10, 20, "P&O Transport Corp.");
	doc.setFontSize(18);
	doc.text(10, 40, "Official Receipt");
	doc.setFontSize(15);
	doc.text(20, 60, "Name: "+fname+" "+lname);
	doc.text(20, 80, "Bus Number: "+busNumber);
	doc.text(20, 100, "eMail: "+email);
	doc.text(20, 120, "Number: " +number);
	doc.text(20, 140, "Route: "+route);
	doc.text(20, 160, "Reserved: "+seatNum);
	doc.text(20, 180, "Receipt #: " + resnum);
	return doc.output(); //returns raw body of resulting PDF returned as a string as per the plugin documentation.
}

function saveFileToServer(file, filename) {
	var obj = {
		output:file,
		name:filename
	};
	$.ajax({
		url:"php/upload.php",
		type:"post",
		data: {"file": JSON.stringify(obj)}
	});
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
