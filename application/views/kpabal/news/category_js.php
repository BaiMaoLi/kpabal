<script type="text/javascript">
	var page_number = 1;

	$(function(){
		$("#load_more").click(function(){
			$.post("<?=ROOTPATH?>news/search/<?=$categoryIdx?>/" + page_number, {}, function(data){
				$("#new_container").append(data);
				page_number++;
			});
		});
	});
</script>