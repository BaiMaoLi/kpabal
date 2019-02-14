<script type="text/javascript">

$(function(){
	$("#phone1").inputmask("mask", {
        "mask": "999-999-9999"
    });

	$( "#business_form" ).validate({
	    // define validation rules
	    rules: {
	        categoryIdx: {
	            required: true,
	        },
	        business_name_en: {
	            required: true,
	        },
	        business_name_ko: {
	            required: true
	        },
	        city: {
	            required: true,
	        },
	        stateIdx: {
	            required: true,
	        },
	        phone1: {
	            required: true,
	            phoneUS: true 
	        },
	        email: {
	            required: true,
	            email: true,
	            minlength: 10
	        },
	        business_description: {
	            required: true,
	            minlength: 20 
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
	    	$.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/business/update", $("#business_form").serialize(), function(data){
	    		window.location.href = "<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/business";
            });
	    }
	});  
});
</script>