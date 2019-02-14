<script type="text/javascript">
	function remove_article(article_id) {
		if(confirm("Are you sure to remove this article?")) {
			jQuery.post("<?=ROOTPATH?>api/article_remove/" + article_id, {}, function(data){
				top.location.href = "<?=ROOTPATH?>blogs/category/<?=$article->categoryIdx?>";
			});
		}
	}

	function good_support(article_id) {
		jQuery.post("<?=ROOTPATH?>api/article_review/" + article_id, {"good_bad": 1}, function(data){
			window.location.reload(true);
		});
	}

	function bad_support(article_id) {
		jQuery.post("<?=ROOTPATH?>api/article_review/" + article_id, {"good_bad": 0}, function(data){
			window.location.reload(true);
		});
	}

	function delete_comment(article_id, id) {
		if(confirm("Are you sure to remove this comment?")) {
			jQuery.post("<?=ROOTPATH?>api/article_comment_delete/" + article_id + "/" + id, {}, function(data){
				jQuery("#comment_list_box").html("");
				comment_page_num = 0;
				load_article_comments();
			});
		}
	}

	var comment_page_num = 0;

	function load_article_comments() {
		jQuery.post("<?=ROOTPATH?>article_comments/<?=$article->id?>/" + comment_page_num, {}, function(data){
			jQuery("#comment_list_box").append(data);
		});
	}

	function toggle_add_comment(elem) {
		jQuery(elem).parent().parent().parent().find(".cmt-reply-box").hide();
		jQuery(elem).parent().parent().find(".cmt-reply-box").show();
	}

	function add_comment(article_id, comment_id, elem) {
		if(jQuery(elem).parent().parent().find(".mb_comment_reply").prop("value") == "") {
			jQuery(elem).parent().parent().find(".mb_comment_reply").focus();
			return false;
		}
		jQuery.post("<?=ROOTPATH?>api/article_reply/"+article_id+"/"+comment_id, {"reply_content": jQuery(elem).parent().parent().find(".mb_comment_reply").prop("value")}, function(data){
			jQuery("#comment_list_box").html("");
			jQuery("#mb_comment_content").prop("value", "");
			comment_page_num = 0;
			load_article_comments();
		});
	}

	jQuery(function(){
		jQuery("#btn_comment").click(function(){
			if(jQuery("#mb_comment_content").prop("value") == "") {
				jQuery("#mb_comment_content").focus();
				return false;
			}
			jQuery.post("<?=ROOTPATH?>api/article_reply/<?=$article->id?>", {"reply_content": jQuery("#mb_comment_content").prop("value")}, function(data){
				jQuery("#comment_list_box").html("");
				jQuery("#mb_comment_content").prop("value", "");
				comment_page_num = 0;
				load_article_comments();
			});
		});

		jQuery("#comment_add_list").click(function(){
			comment_page_num++;
			load_article_comments();
		});

		load_article_comments();
	});

</script>