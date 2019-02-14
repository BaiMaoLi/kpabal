<style type="text/css">	
    .board-view {
        font-size: 13px;
        line-height: 1.6em;
    }
    .board-view .table th, .board-view .table td {
	    padding: 0.25rem;
	}
	.board-view .btn {
	    display: inline-block;
	    min-width: 42px;
	    *height: 30px !important;
	    text-decoration: none !important;
	    font-weight: bold;
	    font-size: 13px;
	    line-height: 18px !important;
	    vertical-align: middle !important;
	}

	.board-view .btn-default {
	    margin: 0;
	    padding: 5px 10px 5px;
	    border: 1px solid #ccc;
	    -webkit-border-radius: 3px;
	    -moz-border-radius: 3px;
	    -khtml-border-radius: 3px;
	    border-radius: 3px;
	    background-color: #F0F0F0 !important;
	    height: 30px !important;
	}

	.board-view textarea {
	    padding: 5px 7px;
	    *padding: 3px 0px !important;
	    display: inline-block;
	    font-size: 13px;
	    line-height: 18px;
	    vertical-align: middle;
	    border: 1px solid #ccc;
	    overflow: auto;
	    background-color: #FFF;
	    color: #6A6A6A !important;
	    -webkit-border-radius: 3px;
	    -moz-border-radius: 3px;
	    -khtml-border-radius: 3px;
	    border-radius: 3px;
	}

	.btn-box-right {
		text-align: right;
	}

	.gpe_wgPoint td, th {
		line-height: 30px;
	}
</style>
<script type='text/javascript' src='<?=ROOTPATH?>../CI_MANG/wordpress/wp-content/plugins/mangboard/skins/bbs_basic/js/common.js?ver=1.7.1'></script>
<script type='text/javascript' src='<?=ROOTPATH?>../CI_MANG/wordpress/wp-content/plugins/mangboard/plugins/editors/smart/js/service/HuskyEZCreator.js?ver=4.9.8'></script>
<script type="text/javascript">
	var mb_urls = [];
	mb_urls["ajax_url"] = "<?=ROOTPATH?>../CI_MANG/wordpress/wp-admin/admin-ajax.php";
</script>
<!--컨텐츠-->
<div class="contents_area_wrap0">
    <div class="gpe_contents_box">
        <div class="board-view" style="padding: 5px;">
            <div class="mb-style1">
                <div class="main-style1" id="test_board_box">
                    <table cellspacing="0" cellpadding="0" border="0" id="" class="table table-write">
                        <colgroup>
                            <col style="width:20%">
                            <col>
                        </colgroup>
                        <tbody>
                            <tr id="mb_test_tr_title">
                                <th scope="row">Title(*)</th>
                                <td>
                                    <input class="text-left" style="width:99%;" name="article_title" id="article_title" value="<?=$article->article_title?>" type="text">
                                </td>
                            </tr>
                            <tr id="mb_test_tr_content">
                                <td class="content-box" colspan="2">
                                    <input type="hidden" name="data_type" id="data_type" value="html">
                                    <textarea class="mb-content" style="width: 100%; height: 360px;" name="article_content" id="article_content" title="Content"></textarea>
									<script type="text/javascript">
									    if (typeof (oEditors) === "undefined") {
									        var oEditors = [];
									    };
									</script>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="write-btn">
                    <div class="btn-box-right" id="test_btn_box">
                        <div class="btn-box-left" style="float:left;">
                            <button class="btn btn-default" title="List" type="button" onclick="top.location.href = '<?=ROOTPATH?>blogs/category/<?=$article->categoryIdx?>';">
                                <span>List</span>
                            </button>
                            <button class="btn btn-default" title="Back" type="button" onclick="top.location.href = '<?=ROOTPATH?>blogs/article/<?=$article->id?>';">
                                <span>Back</span>
                            </button>
                        </div>
                        <button class="btn btn-default btn-send-write" title="Submit" type="button">
                            <span>Submit</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--[SIDE컨텐츠_우측]-->
    <?php include_once(__DIR__."/../common/sidebar.php");?>
</div>