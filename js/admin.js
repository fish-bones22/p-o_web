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
		var newVal = $('#'+value+'-resnum').val();
		$(this).siblings().removeClass('hidden');
		$(this).addClass('hidden');
		confirmPendingList.push(newVal);
		$('#reserve-number-length').val(confirmPendingList.length);
		var newInput = $(document.createElement('input'));
		newInput.attr('type', 'hidden');
		newInput.attr('name', 'reserve-number-'+(confirmPendingList.length-1));
		newInput.attr('class', 'reserve-number-inputs');
		newInput.attr('value', newVal);
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
		var driver = $('#'+value+'-driver').val();
		var conductor = $('#'+value+'-conductor').val();
		var pdf = genPDF(value, newVal, receipt, fname, lname, busNumber, email, number, route, seatNum, driver, conductor);
		saveFileToServer(pdf, newVal);
	});

	$('#reserve-cancel-btn').click(function (e) {
		$('.confirm-payment-btn').removeClass('hidden');
		$('.pending-label').addClass('hidden');
		confirmPendingList = [];
		$('#reserve-number-length').val(0);
		var inputs = $('.reserve-number-inputs');
		var parent = inputs.parent();
		inputs.remove();
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
		e.preventDefault();
		$('#mobile-number-input-after').attr('value', $('#mobile-number-input').val());
		$('#smart-number-input-after').attr('value', $('#smart-number-input').val());
		//$('#about-input-after').attr('value', $('#about-input').val());
		$('#fb-link-input-after').attr('value', $('#fb-link-input').val());
		$('#email-input-after').attr('value', $('#email-input').val());
		for(var i = 0; i < $('#trip-input-length').val(); i++) {
			// Generate hidden input for driver and conductor inside the modal
			var busCode = $('#bus-code-input-'+i).val();
			// For driver
			var newInput = $(document.createElement('input'));
			var inputBeforeValue = $('#driver-input-'+i).val();
			newInput.attr('name', "driver-input-after-"+i);
			newInput.attr('type', 'hidden');
			newInput.attr('value', inputBeforeValue);
			$('#inputform').append(newInput);
			// For conductor
			newInput = $(document.createElement('input'));
			inputBeforeValue = $('#conductor-input-'+i).val();
			newInput.attr('name', "conductor-input-after-"+i);
			newInput.attr('type', 'hidden');
			newInput.attr('value', inputBeforeValue);
			$('#inputform').append(newInput);
			// For buscode
			newInput = $(document.createElement('input'));
			newInput.attr('name', "bus-code-after-"+i);
			newInput.attr('type', 'hidden');
			newInput.attr('value', busCode);
			$('#inputform').append(newInput);
		}
		$('#reserve-number-length').attr('value', confirmPendingList.length);
		for (var i = 0; i < confirmPendingList.length; i++) {
			// Generate hidden input for confirmation inside the modal
			var newInput = $(document.createElement('input'));
			newInput.attr('name', "reserve-number-input-"+i);
			newInput.attr('type', 'hidden');
			newInput.attr('value', confirmPendingList[i]);
			$('#inputform').append(newInput);
		}
		$('#inputform').submit();
	});

	$(".reset-btn").click(function (e) {
		$(".cb-filter").removeAttr("checked");
		$(".cb-filter").change();
	});

	$("#export-btn").click(function (e) {
		e.preventDefault();
		var name = [], resNum = [], date = [], time = [], route = [], seat = [], price = [], busNum = [], mobile = [];
		$(".tr-reserve").each(function (e) {
			if (!$(this).hasClass("hidden")) {
				name.push($(this).children(".name").val());
				resNum.push($(this).children(".resnum").val());
				date.push($(this).children(".date").val());
				time.push($(this).children(".time").val());
				route.push($(this).children(".route").val());
				seat.push($(this).children(".seat").val());
				price.push($(this).children(".price").val());
				busNum.push($(this).children(".busno").val());
				mobile.push($(this).children(".phone").val());
			}
		});
		var offset = 45;
		var width = 520;
		var height = 50+(name.length*10);
		var doc = new jsPDF({
	    orientation: 'landscape',
	    unit: 'px',
	    format: [width, height]
	  });
	  doc.setFontSize(20);
		doc.text(10, 15, "List of Reservations");
	  doc.setFontSize(10);
		doc.text(10, 30, "Name");
		doc.text(85, 30, "Res#");
		doc.text(140, 30, "Date");
		doc.text(190, 30, "Time");
		doc.text(230, 30, "Route");
		doc.text(330, 30, "Seats");
		doc.text(400, 30, "Price");
		doc.text(425, 30, "Mobile");
		doc.text(480, 30, "Bus#");
		for (var i = 0; i < name.length; i++) {
			doc.text(10, offset+(i*10), name[i]);
			doc.text(85, offset+(i*10), resNum[i]);
			doc.text(140, offset+(i*10), date[i]);
			doc.text(190, offset+(i*10), time[i]);
			doc.text(230, offset+(i*10), route[i]);
			doc.text(330, offset+(i*10), seat[i]);
			doc.text(400, offset+(i*10), price[i]);
			doc.text(425, offset+(i*10), mobile[i]);
			doc.text(480, offset+(i*10), busNum[i]);
		}
		doc.save('transaction-'+getDateToday());
	});

	var filter = {
		select_filter_payment: "iterable",
		select_filter_terminal: "iterable",
		select_filter_bus_number: "iterable",
		select_filter_date: "iterable",
		select_filter_time: "iterable"
	};

	$(".cb-filter, .filter-select").change(function (e) {
		var select, cb;
		if ($(this).attr("type") === "checkbox") {
			cb = $(this);
			select = $(this).siblings("input, select");
		} else {
			cb = $(this).siblings(".cb-filter");
			select = $(this);
		}

		var option = select.val();
		if (cb.is(':checked')) {
			select.removeAttr("disabled");
			filter[select.attr("id")] = option;
		} else {
			select.attr("disabled", "");
			$(".tr-reserve").removeClass("hidden");
			filter[select.attr("id")] = "iterable";
		}
		checkFilter(filter);
	});
});

function checkFilter(filter) {
	$(".tr-reserve").addClass("hidden");
	$(".tr-reserve").each(function (e) {
		if ($(this).hasClass(filter["select_filter_payment"]) &&
				$(this).hasClass(filter["select_filter_terminal"]) &&
				$(this).hasClass(filter["select_filter_bus_number"]) &&
				$(this).hasClass(filter["select_filter_date"]) &&
				$(this).hasClass(filter["select_filter_time"]))
				$(this).removeClass("hidden");
	});

	if (filter["select_filter_payment"] == "" &&
			filter["select_filter_terminal"] == "" &&
			filter["select_filter_bus_number"] == "" &&
			filter["select_filter_date"] == "" &&
			filter["select_filter_time"] == "")
			$(".tr-reserve").removeClass("hidden");
}

function removeFilter() {
	$(".tr-reserve").removeClass("hidden");
}

function exportListToPDF() {

}

// Send PDF
function genPDF(rescode, resnum, receipt, fname, lname, busNumber, email, number, route, seatNum, driver, conductor) {
	var initialMarginX = 10;
	var initialMarginY = 10;
	var x = 0;
	var y = 0;
	var offset = 4;
	doc = new jsPDF({
		orientation: 'portrait',
		unit: 'px',
		format: [210, 240]
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
	doc.text(20, 160, "Driver: "+driver);
	doc.text(20, 180, "Cond: "+conductor);
	doc.text(20, 200, "Reserved: "+seatNum);
	doc.text(20, 220, "Receipt #: " + resnum);
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
