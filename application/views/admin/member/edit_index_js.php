<script type="text/javascript">

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "3000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};

$(function(){
	$("#phone").inputmask("mask", {
        "mask": "999-999-9999"
    });

    $("#dob").datepicker({
        rtl: false,
        todayHighlight: true,
        orientation: "bottom right",
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    });

    $("#select_avatar").click(function(){
    	$("#upload_avatar").click();
    });

    transferComplete = function(e) {
    	$("#avatar").attr("src", "<?=ROOTPATH.PROJECT_AVATAR_DIR."/user_".$memberIdx."_1.jpg"?>");
    }

    $("#upload_avatar").change(function(event){
    	var file = event.target.files[0];    	
        var data = new FormData();
        data.append("uploadedFile", file);
        var objXhr = new XMLHttpRequest();
        objXhr.addEventListener("load", transferComplete, false);
        objXhr.open("POST", "<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/members/upload_avatar/<?=$memberIdx?>");
        objXhr.send(data);
    });

	$( "#member_form" ).validate({
	    // define validation rules
	    rules: {
	        user_id: {
	            required: true,
	            minlength: 6
	        },
	        user_email: {
	            required: true,
	            email: true,
	            minlength: 10 
	        },
		<?php if(!($memberIdx)):?>
	        user_password: {
	            required: true,
	            minlength: 8 
	        },
	        user_password2: {
	            required: true,
	            minlength: 8 
	        },
	    <?php endif ?>
	        first_name: {
	            required: true
	        },
	        last_name: {
	            required: true
	        },
	        gender: {
	            required: true,
	            minlength: 1 
	        },
	        dob: {
	        	required: true,
	        },
	        city: {
	            required: true,
	        },
	        stateIdx: {
	            required: true,
	        },
	        postal_code: {
	            required: true,
	        },
	        phone: {
	            required: true,
	            // ,phoneUS: true 
	        },
	        member_status: {
	        	required: true,
	        	minlength: 1
	        }
	    },
	    
	    //display error alert on form submit  
	    invalidHandler: function(event, validator) {     
	        var alert = $('#m_form_1_msg');
	        alert.removeClass('m--hide').show();
	        mUtil.scrollTop();
	        setTimeout(function(){
	        	$('#m_form_1_msg').addClass('m--hide').hide();
	        }, 5000);
	    },

	    submitHandler: function (form) {
	    	if($("#user_password").prop("value")) {
	    		if($("#user_password").prop("value") != $("#user_password2").prop("value")) {
					toastr.error("Please enter New Passwords correctly.");
					return false;
	    		}

		    	var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
		    	if(!(strongRegex.test($("#user_password").prop("value")))) {
		    		toastr.error("Password strength is weak. Password must be eight characters or longer, and contain at least one lowercase & uppercase alphabetical character, numeric, special character.");
		    		$("#user_password").focus();
		    		return false;
		    	}
	    	}
	    	$.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/members/update", $("#member_form").serialize(), function(data){
	    		if(data == 0) window.location.href = "<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/members";
                else if(data == -1) toastr.error("Someone already used that User ID");
                else if(data == -2) toastr.error("Someone already used that email address");
            });
	    }
	});  
});
</script>