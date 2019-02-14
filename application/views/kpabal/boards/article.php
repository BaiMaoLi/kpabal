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
	.board-view .cmt-input-box textarea {
	    width: 100%;
	    min-height: 60px !important;
	    display: inline-block !important;
	}
	.board-view th {
		max-width: 200px;
	}
	.btn-box-right {
		text-align: right;
	}
	.cmt-name, .pn_user_name {
		color: #1ABC9C;
	}
</style>
<!--컨텐츠-->
<div class="contents_area_wrap0">
    <div class="gpe_contents_box">
        <div class="board-view" style="padding: 5px;">
            <table cellspacing="0" cellpadding="0" border="0" class="table table-view">
            	<colgroup><col style="width:20%"><col></colgroup>
                <tbody>
                    <tr>
                        <th>Title</th>
                        <td>
							<span style="float:left;"><?=$article->article_title?></span>
							<span style="float:right;width:155px;text-align:right;"><?=date("M j, Y", strtotime($article->article_date))?> <?=date("H:i", strtotime($article->article_date))?></span>
                        </td>
                    </tr>
                    <tr>
						<th>Writer</th>
						<td><?=$article->memberName?></td>
					</tr>
                    <?php if(count($attachment)):?>
                    <tr>
                        <th>Attachment</th>
                        <td><?php foreach ($attachment as $file) {
                            echo '<a class="file_link" href="'.ROOTPATH.'api/download_attachment/'.$file->id.'" target="_blank">'.$file->file_name.'</a>';
                        }?>
                        </td>
                    </tr>
                    <?php endif?>
                    <tr id="mb_test_tr_content">
                        <td class="content-box text-left" colspan="2" style="font-size: 10pt; line-height:1.6;">
                             <?=$article->article_content?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="view-btn" style="text-align: right;">
                <div>
                    <?php if($memberIdx):?>
                    <button class="btn btn-default btn-vote-good" title="Like" type="button"<?php if(($memberIdx != $article->memberIdx)&&(!($article->good))):?> onclick="good_support(<?=$article->id?>);"<?php endif?>>
                        <span>
                            Like <span id="test_vote_good">(<?=$article->good_count?>)</span>
                        </span>
                    </button>
                    <button class="btn btn-default btn-vote-bad" title="Not Like" type="button"<?php if(($memberIdx != $article->memberIdx)&&(!($article->bad))):?> onclick="bad_support(<?=$article->id?>);"<?php endif?>>
                        <span>
                            Not Like <span id="test_vote_bad">(<?=$article->bad_count?>)</span>
                        </span>
                    </button>
                    <?php endif?>
                    <button class="btn btn-default btn-list" title="List" type="button" onclick="top.location.href='<?=ROOTPATH?>blogs/category/<?=$article->categoryIdx?>';">
                        <span>List</span>
                    </button>
                    <?php if($memberIdx == $article->memberIdx):?>
                    <button class="btn btn-default btn-modify" title="Modify" type="button" onclick="top.location.href='<?=ROOTPATH?>blogs/article_edit/<?=$article->id?>';">
                        <span>Modify</span>
                    </button>
                    <button class="btn btn-default btn-delete" title="Delete" type="button" onclick="remove_article(<?=$article->id?>);">
                        <span>Delete</span>
                    </button>
                    <?php endif?>
                    <?php if($memberIdx):?>
                    <button class="btn btn-default btn-write" title="Write" type="button" onclick="top.location.href='<?=ROOTPATH?>blogs/article_new/<?=$article->categoryIdx?>';">
                        <span>Write</span>
                    </button>
                    <?php endif?>
                </div>
            </div>
            <div class="cmt-style1">
                <div style="width:100%;min-height:32px;font-weight: bold;">
                     Comment [<span class="cmt-count-num" id="mb_comment_totalcount"><?=$article->reply_count?></span>]
                </div>
                <?php if($memberIdx):?>
                <div>
                    <div class="cmt-input-head cmt-input-box">
                        <table cellspacing="0" cellpadding="0" border="0" class="table table-comment" style="margin-bottom: 0.5rem;">
                        	<colgroup><col style="width:20%"><col></colgroup>
                            <tbody>
                                <tr>
                                    <th>Content(*)</th>
                                    <td>
                                        <textarea class="mb-comment-content" name="content" id="mb_comment_content"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                	</div>
                    <div class="comment-btn" style="text-align: right;">
                        <button class="btn btn-default" title="Comment Write" type="button" id="btn_comment">
                            <span>Comment Write</span>
                        </button>
                    </div>
                </div>
                <?php endif?>
                <ul id="comment_list_box" class="cmt-list-box list-unstyled" style="">
                </ul>
            </div>
            <div id="comment_add_list" class="cmt-add-list" style="display: none;">
                <button class="btn btn-default btn-more" title="More" type="button" style="width: 100%;">
                    <span>More</span>
                </button>
            </div>
            <br>
            <div class="prev_next_style">
                <table cellspacing="0" cellpadding="0" border="0" class="table table-prev-next">
                    <colgroup>
                        <col style="width:8%">
                        <col>
                        <col style="width:18%">
                        <col style="width:14%">
                    </colgroup>
                    <tbody>
                        <?php if(isset($prev_article)):?>
                        <tr>
                            <th scope="row">
                                <span>Prev</span>
                            </th>
                            <td class="pn_title">
                                <a href="<?=ROOTPATH?>article/<?=$prev_article->id?>"><?=$prev_article->article_title?></a>
                            </td>
                            <td class="pn_user_name"><?=$prev_article->memberName?></td>
                            <td class="pn_reg_date"><?=date("M j, Y", strtotime($prev_article->article_date))?></td>
                        </tr>
                        <?php endif?>
                        <tr>
                            <th scope="row">
                                <span>-</span>
                            </th>
                            <td class="pn_title">
                                <a href="#"><?=$article->article_title?></a>
                            </td>
                            <td class="pn_user_name"><?=$article->memberName?></td>
                            <td class="pn_reg_date"><?=date("M j, Y", strtotime($article->article_date))?></td>
                        </tr>
                        <?php if(isset($next_article)):?>
                        <tr>
                            <th scope="row">
                                <span>Next</span>
                            </th>
                            <td class="pn_title">
                                <a href="<?=ROOTPATH?>article/<?=$next_article->id?>"><?=$next_article->article_title?></a>
                            </td>
                            <td class="pn_user_name"><?=$next_article->memberName?></td>
                            <td class="pn_reg_date"><?=date("M j, Y", strtotime($next_article->article_date))?></td>
                        </tr>
                        <?php endif?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--[SIDE컨텐츠_우측]-->
    <?php include_once(__DIR__."/../common/sidebar.php");?>
</div>