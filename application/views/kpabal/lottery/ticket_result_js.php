<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
	$(function(){

		$(".btn_remove").click(function(){
			$.post("<?=ROOTPATH?>lottery/set_cart/"+$(this).parent().attr("productIdx"), {}, function(data){

			});
			$(this).parent().remove();
			calculate_checkout();
		});

		$(".btn_plus").click(function(){
			proc_amount = $(this).parent().find(".txt_amount:first");
			proc_amount.prop("value", parseInt(proc_amount.prop("value")) + 1);

			$.post("<?=ROOTPATH?>lottery/set_cart/"+$(this).parent().attr("productIdx")+"/"+proc_amount.prop("value"), {}, function(data){

			});
			calculate_checkout();
		});

		$(".btn_minus").click(function(){
			proc_amount = $(this).parent().find(".txt_amount:first");
			proc_amount.prop("value", proc_amount.prop("value") - 1);

			$.post("<?=ROOTPATH?>lottery/set_cart/"+$(this).parent().attr("productIdx")+"/"+proc_amount.prop("value"), {}, function(data){

			});
			calculate_checkout();
			if(proc_amount.prop("value") == 0)
				$(this).parent().parent().remove();
		});

		$(".txt_amount").change(function(){
			proc_count = parseInt($(this).prop("value"));
			if(isNaN(proc_count)) proc_count = 1;
			$(this).prop("value", proc_count);

			$.post("<?=ROOTPATH?>lottery/set_cart/"+$(this).parent().attr("productIdx")+"/"+proc_count, {}, function(data){
			});
			if(proc_count == 0)
				$(this).parent().parent().remove();
			calculate_checkout();
		});

		//calculate_checkout();
	});

	function calculate_checkout() 
	{
		total_price = 0;
		for(i=0; i<$(".cart_product").length; i++) {
			total_price += $(".cart_product .business_record").eq(i).attr("productPrice") * $(".cart_product .business_record").eq(i).find(".txt_amount:first").prop("value");
		}

		$("#total_amount").html(total_price);
		$(".pay_amount").prop("value", total_price);
	}

	Stripe.setPublishableKey('<?=STRIPE_PUB_KEY?>');

	function __check_alphanumeric(inputtxt)
	{
		if(inputtxt == "") return true;
		var letterNumber = /^[0-9a-zA-Z]+$/;
		if(inputtxt.match(letterNumber)) 
		{
			return true;
		}
		else
		{ 	
			return false; 
		}
	}

	function __check_numeric(inputtxt)
	{
		if(inputtxt == "") return true;
		var letterNumber = /^[0-9]+$/;
		if(inputtxt.match(letterNumber)) 
		{
			return true;
		}
		else
		{ 	
			return false; 
		}
	}

	$(function() {
		$("#stripe_button").click(function(){
			if(($("#card_number").prop("value").length > 16)||(!(__check_numeric($("#card_number").prop("value"))))){
				__displayMessage__("Payment", "The card number is not correct.", function(){
					setTimeout(function(){$("#card_number").prop("value", "").focus();}, 500);
				});
				return false;
			}
			if(($("#card_month").prop("value").length > 2)||(!(__check_numeric($("#card_month").prop("value"))))){
				__displayMessage__("Payment", "The card expiration month is not correct.", function(){
					setTimeout(function(){$("#card_month").prop("value", "").focus();}, 500);
				});
				return false;
			}
			if(($("#card_year").prop("value").length > 2)||(!(__check_numeric($("#card_year").prop("value"))))){
				__displayMessage__("Payment", "The card expiration year is not correct.", function(){
					setTimeout(function(){$("#card_year").prop("value", "").focus();}, 500);
				});
				return false;
			}
			if(($("#card_cvc").prop("value").length > 3)||(!(__check_numeric($("#card_cvc").prop("value"))))){
				__displayMessage__("Payment", "The card cvc is not correct.", function(){
					setTimeout(function(){$("#card_cvc").prop("value", "").focus();}, 500);
				});
				return false;
			}
			if(($("#card_zip").prop("value").length > 6)||(!(__check_alphanumeric($("#card_zip").prop("value"))))){
				__displayMessage__("Payment", "The billing postal code is not correct.", function(){
					setTimeout(function(){$("#card_zip").prop("value", "").focus();}, 500);
				});
				return false;
			}
			return true;
		});

		function stripeResponseHandler(status, response) {
			$('#payment-form').find('.submit').prop('disabled', false);
			$('#payment-form').find('.submit').val('Retry Payment');
			if (response.error) {
				alert(response.error.message);
			} else {
			    console.log('<?=ROOTPATH?>lottery/stripe_process/' + $(".pay_amount").val());
				$.ajax({
					url: '<?=ROOTPATH?>lottery/stripe_process/' + $(".pay_amount").val(),
					data: {
						access_token: response.id,
						emailAddress: $("#emailAddress").val(),
						gameType: $("#gameType").val(),
						phoneNumber: $("#phoneNumber").val()
					},
					type: 'POST',
					dataType: 'JSON',
					success: function(response){
						if(response.success){
						    alert(response.success);
							window.location.href="<?=ROOTPATH?>lottery/";
						}
						else 
							alert(response.error);
					},
					error: function(error){
					}
				});
			}
		}
		var $form = $('#payment-form');
		$form.submit(function(event) {
			$form.find('.submit').prop('disabled', true);
			$form.find('.submit').val('Please wait...');
			Stripe.card.createToken($form, stripeResponseHandler);
			return false;
		});
	});

</script>