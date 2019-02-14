<script type="text/javascript">
	function add_cart(productIdx) {
		<?php $userid = $loggedinuser['memberIdx']; if($userid):?>
			$.post("<?=ROOTPATH?>shopping/add_cart/"+productIdx, {}, function(data){
				window.location.href = "<?=ROOTPATH?>shopping/cart";
			});
		<?php else:?>
			window.location.href = "<?=ROOTPATH?>login";
		<?php endif?>
	}
</script>