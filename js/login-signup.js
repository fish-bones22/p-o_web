$(window).ready(function(){

  closeLoginContainer();

  function openLoginContainer() {
    $('.logform-container').css({visibility:'visible'});
    $('.logform-container').fadeIn(200);
    $('.logform').css("left", "10px");
    $('.logform').fadeIn(600);
    $('.logform-container').css({
      overflow: 'scroll'
    });
    $('.form-control').attr('value', '');
  }
  function closeLoginContainer() {
    $('.logform').fadeOut(600);
    if (!$('.logform').is(":visible"))
      $('.logform').css("left", "-9000px");
    $('.logform-container').fadeOut(200);
    window.setTimeout(250, function () {
      $('.logform-container').css("visibility", "hidden");
    });
  }

  $('.login-navbar, #reserve-btn-navbar').click(openLoginContainer);
  // Check if signing in yields error
  if ($('#error-signin-input').val() === '1') {
    openLoginContainer();
  }
  // Check if signing up yields error
  if ($('#error-signup-input').val() === '1') {
    if($('#is-signedin-input').val() !== '1') {
      openLoginContainer();
    } else {
      $('#error-signup-input').attr('value','0');
    }

  }
  $('#reserve-btn-home').click(function (e) {
    if($('is-signedin-input').val() !== 1) {
      if ($('#reserve-btn').attr('href') != '#')
        openLoginContainer();
    }
  });

  // Close Login/Signup form jQuery
  $('.close, .logform-outside').click(closeLoginContainer);

  // If login button is
  $('#login-btn').click(function (e) {
    e.preventDefault();
    closeLoginContainer();
    $('#login-form').submit();
  })
  // Login/Signup form jQuery
  $('.tab a').click(function (e) {
    e.preventDefault();

    $(this).parent().addClass('active');
    $(this).parent().siblings().removeClass('active');

    target = $(this).attr('href');
    $('.tab-content > div').not(target).hide();

    $(target).fadeIn(600);
  });

	var validator = $('#signupval').bootstrapValidator({
	  feedbackIcons: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    //validations
    fields : {
      Fname : {
        validators : {
          notEmpty : {
          	message:"First name is required"
        	}
       	}
     	},
     	Lname : {
       	validators : {
       		notEmpty : {
       			message : "Last name is required"
    			},
     			different : {
     				field : "Fname",
       			message : "First name and Last name can not be match"
       		}
       	}
      },
      email : {
        validators : {
        	notEmpty : {
        		message:"Please provide an email address"
        	},
          regexp: {
            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
          }
     	  }
      },
     	Password1 : {
     		validators : {
     			notEmpty : {
     				message : "Password is required and cannot be empty"
     			},
     			stringLength : {
     				min : 8,
     				message : "The password must be 8 characters long"
     			},
     			different : {
     				field : "email",
     				message : "Password too weak"
     			}
     		}
     	},
     	Confirm : {
     		validators : {
     			identical : {
     				field : "Password1",
            message: "Passwords do not match"
       		}
       	}
    	},
    	Phone : {
     		validators : {
       		notEmpty : {
    				message : "Contact number is required"
     			},
       		numeric : {
      			message : "phone \ doesn'\ t match the specific format "
       		},
    			stringLength :{
     				min : 11,
       			max : 11,
       			message : "Input must be 11 digits"
    			}
     		}
     	}
    }
  });
});
