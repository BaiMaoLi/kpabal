<script type="text/javascript">
	$(function(){

		$(".btn_remove").click(function(){
			$.post("<?=ROOTPATH?>shopping/set_cart/"+$(this).parent().attr("productIdx"), {}, function(data){

			});
			$(this).parent().parent().remove();
			calculate_checkout();
		});

		$(".btn_plus").click(function(){
			proc_amount = $(this).parent().find(".txt_amount:first");
			proc_amount.prop("value", parseInt(proc_amount.prop("value")) + 1);

			$.post("<?=ROOTPATH?>shopping/set_cart/"+$(this).parent().attr("productIdx")+"/"+proc_amount.prop("value"), {}, function(data){

			});
			calculate_checkout();
		});

		$(".btn_minus").click(function(){
			proc_amount = $(this).parent().find(".txt_amount:first");
			proc_amount.prop("value", proc_amount.prop("value") - 1);

			$.post("<?=ROOTPATH?>shopping/set_cart/"+$(this).parent().attr("productIdx")+"/"+proc_amount.prop("value"), {}, function(data){

			});
			calculate_checkout();
			if(proc_amount.prop("value") == 0)
				$(this).parent().parent().remove();
		});

		$(".txt_amount").change(function(){
			proc_count = parseInt($(this).prop("value"));
			if(isNaN(proc_count)) proc_count = 1;
			$(this).prop("value", proc_count);

			$.post("<?=ROOTPATH?>shopping/set_cart/"+$(this).parent().attr("productIdx")+"/"+proc_count, {}, function(data){
			});
			if(proc_count == 0)
				$(this).parent().parent().remove();
			calculate_checkout();
		});

		calculate_checkout();
	});

	function calculate_checkout() 
	{
		$(".checkout_page").hide();
		total_price = 0;
		for(i=0; i<$(".cart_product").length; i++) {
			total_price += $(".cart_product .business_record").eq(i).attr("productPrice") * $(".cart_product .business_record").eq(i).find(".txt_amount:first").prop("value");
		}

		$("#total_amount").html(total_price);
	}

	function goto_checkout()
	{
		if($(".cart_product").length) {
			$(".checkout_page").show();
		} else {
			$(".checkout_page").hide();
		}
	}
</script>