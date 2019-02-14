<script type="text/javascript">

$(function(){

    $("#select_avatar").click(function(){
    	$("#upload_avatar").click();
    });

    transferComplete = function(e) {
    	$("#avatar").attr("src", "<?=ROOTPATH.PROJECT_PRODUCT_DIR."/product_".$id."_1.jpg"?>");
    }

    $("#upload_avatar").change(function(event){
    	var file = event.target.files[0];    	
        var data = new FormData();
        data.append("uploadedFile", file);
        var objXhr = new XMLHttpRequest();
        objXhr.addEventListener("load", transferComplete, false);
        objXhr.open("POST", "<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products/upload_avatar/<?=$id?>");
        objXhr.send(data);
    });

	$( "#product_form" ).validate({
	    // define validation rules
	    rules: {
	        product_name: {
	            required: true,
	            minlength: 6
	        },
	        title: {
	            required: true,
	        },
	        descriptions: {
	            required: true
	        },
	        price: {
	            required: true
	        },
	        category: {
	            required: true,
	        },
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
	    	$.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products/update", $("#product_form").serialize(), function(data){
	    		window.location.href = "<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products";
            });
	    }
	});  
});
</script>