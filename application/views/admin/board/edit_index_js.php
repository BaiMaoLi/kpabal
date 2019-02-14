<script type="text/javascript">

$(function(){

	$( "#board_form" ).validate({
	    // define validation rules
	    rules: {
	        categoryIdx: {
	            required: true,
	        },
	        article_title: {
	            required: true,
	        },
	        article_content: {
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
	    	$.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards/update", $("#board_form").serialize(), function(data){
	    		window.location.href = "<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards";
            });
	    }
	});  
});
</script>