<script type="text/javascript">
	var nav_tab = "home-tab";

	function search_data(page_number) {
		$.post("<?=ROOTPATH?>favorites/search", {where: nav_tab, page: page_number}, function(data){
			$("#content_table").html(data);

			$(".btn_unfavorite").unbind("click").click(function(){
				$.post("<?=ROOTPATH?>api/business_favorite/" + $(this).attr("value"), {on_off: 0}, function(data){
					search_data(0);
				});
			});

			$(".btn_uncomment").unbind("click").click(function(){
				$.post("<?=ROOTPATH?>api/business_review_delete/" + $(this).attr("value"), {}, function(data){
					search_data(0);
				});
			});

			$(".page-link").unbind("click").click(function(){
				if($(this).parent().hasClass("disabled")) return false;
				search_data($(this).attr("value"));
			});
		});
	}

	$(function(){

		$("#myTab .nav-link").click(function(){
			if(nav_tab == $(this).attr("id")) return false;
			nav_tab = $(this).attr("id");
			search_data(0);
		});

		search_data(0);
	});
</script>