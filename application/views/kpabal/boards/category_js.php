<script type="text/javascript">
	var current_page = 0;
	var total_page = "<?=$totalPages?>";

	function load_articles(){
		console.log($("#search_text").prop("value"));
		console.log($("#search_field").prop("value"));
		console.log(current_page);
		$.post("<?=ROOTPATH?>blogs/search/<?=$categoryInfo->categoryIdx?>", {"keyword":$("#search_text").prop("value"), "field":$("#search_field").prop("value"), "page_number":current_page}, function(data){
			$("#board_body").html(data);
		});
	}

	$(function(){
		$("#btn_first").click(function(){
			if(current_page > 0) {
				current_page = 0;
				load_articles();
			}
		});

		$("#btn_prev").click(function(){
			if(current_page > 0) {
				current_page--;
				load_articles();
			}
		});

		$("#btn_next").click(function(){
			if(current_page < total_page - 1) {
				current_page++;
				load_articles();
			}
		});

		$("#btn_last").click(function(){
			if(current_page < total_page - 1) {
				current_page = total_page - 1;
				load_articles();
			}
		});		

		$("#btn_search").click(function(){
			current_page = 0;			
			load_articles();
		});

		$("#search_text").blur(function(){
		//	$("#btn_search").click();
		}).keydown(function(e){
			if(e.keyCode == 13)
				$("#btn_search").click();
		});
	});
</script>