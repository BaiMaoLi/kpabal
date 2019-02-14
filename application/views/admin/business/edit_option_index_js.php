<script type="text/javascript">

$(function(){
	$("#btn_save_option").click(function(){
		$.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/business/option_update", $("#business_option_form").serialize(), function(data){
			window.location.href = "<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/business";
	    });
	});
});

</script>