<script type="text/javascript">
	jQuery(function(){
		setInterval(function(){
			jQuery.post("<?=ROOTPATH?>home/daily_news", {}, function(data){
				jQuery("#daily_news").html(data);
			});
		}, 60000);
	});
</script>