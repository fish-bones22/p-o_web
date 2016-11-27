$(window).ready(function () {

	var fName = $('#fname').val();
	var lName = $('#lname').val();
	var email = $('#email').val();
	var mobile = $('#phone').val();
	var isEditing = false;
	$('.edit-btn').click(function () {
			// edit
		if (!isEditing) {
			$('.form-control').removeAttr('disabled');
			$('.edit-btn').html("<span class=\"glyphicon glyphicon-ok\"></span> Cancel");
			$('.edit-btn span').removeClass('glyphicon glyphicon-edit');
			$('.edit-btn span').addClass('glyphicon glyphicon-remove');
			$("button.hidden").removeClass('hidden');
			//cancel
		} else {
			location.reload();
		}
		isEditing = !isEditing;
	});

  var validator = $('#accountsettings').bootstrapValidator({
  	feedbackIcons : {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
      //validations
    fields : {
      email : {
        validators : {
        	notEmpty : {
        		message : "Please provide an email address"
        	},
          regexp: {
            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
          }
     		}
     	},
     	Password : {
     		validators : {
     			notEmpty : {
     				message : "Please provide a password"
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
			RePassword : {
     		validators : {
     			notEmpty : {
     				message : "Please retype provide a password"
     			},
     			stringLength : {
     				min : 8,
     				message : "The password must be 8 characters long"
     			},
     			identical : {
     				field : "Password",
     				message : "Password do not match"
     			}
     		}
     	},
     	Fname : {
     		validators : {
     			notEmpty : {
     				message : "Please provide a value"
     			},
     		}
     	},
     	Lname : {
     		validators : {
     			notEmpty : {
     				message : "Please provide a value"
     			}
     		}
     	},
    	Phone : {
     		validators : {
     			notEmpty : {
     				message : "Phone number is required"
     			},
     			numeric : {
     				message : "phone \ doesn'\ t match the specific format "
     			},
     			stringLength :{
     				min : 11,
     				max : 13,
     				message : "Input must be 11 digits"
     			}
     		}
     	}
    }
  });
});
