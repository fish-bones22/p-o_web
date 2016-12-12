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

  $('.login-navbar').click(openLoginContainer);
  // Check if signing in yields error
  if ($('#error-signin-input').val() === '1') {
    openLoginContainer();
  }
  // Check if signing up yields error
  if ($('#error-signup-input').val() === '1') {
    openLoginContainer();
  }
  $('#reserve-btn-home, #reserve-btn-navbar').click(function (e) {
    if($('#is-signedin-input').val() != 1) {
      if ($('#reserve-btn-home').attr('href') == '#')
        openLoginContainer();
    } else {
      if ($("body").scrollTop() < 50) {
        $("#reserve-btn-navbar").attr("href", "reserve.php");
      } else {
        $("#reserve-btn-navbar").attr("href", "#");
      }
    }
  });




  // Close Login/Signup form jQuery
  $('.close-pop, .logform-outside').click(function (e) {
    closeLoginContainer();
  });

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
        trigger: "blur",
        validators : {
          notEmpty : {
          	message:"First name is required"
        	}
       	}
     	},
     	Lname : {
        trigger: "blur",
       	validators : {
       		notEmpty : {
       			message : "Last name is required"
    			}
       	}
      },
      email : {
        threshold : 5,
        verbose : false,
        validators : {
        	notEmpty : {
        		message:"Please provide an email address"
        	},
          regexp: {
            message:"The email address is not valid",
            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$'
          },
          remote: {
            message: "email address is not available",
            url: 'php/validate_email.php',
            data: {
              type: 'email'
            },
            type: 'POST',
            delay: 1000
          }
     	  }
      },
     	Password1 : {
        threshold : 5,
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
        threshold : 5,
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
    				message : "Contact number is required",
            delay: 2000
     			},
       		numeric : {
      			message : "phone \ doesn'\ t match the specific format "
       		}
     		}
     	}
    }
  });
});
