<?php foreach($comments as $comment){?>
<li id="mb_cmt3" class="cmt-list-item">
    <br>
    <div<?php if(strlen($comment->id) > 2):?> style="padding-left: <?=(strlen($comment->id) - 2)?>0px;"<?php endif?>>
        <span class="cmt-name"><?php if(strlen($comment->id) > 2):?><i class="fa fa-reply" aria-hidden="true"></i> <?php endif?><?=$comment->memberName?></span>
        <span class="cmt-date"><?=$comment->regDate?></span>
    </div>
    <div class="cmt-content"<?php if(strlen($comment->id) > 2):?> style="padding-left: <?=(strlen($comment->id) - 2)?>0px;"<?php endif?>><?=$comment->reply_content?></div>
    <div class="btn-box-right">
        <?php if($memberIdx == $comment->memberIdx):?>
        <button class="btn btn-default btn-cmt btn-delete" title="Delete" type="button" onclick="delete_comment('<?=$comment->articleIdx?>', '<?=$comment->id?>');">
            <span>Delete</span>
        </button>
        <button class="btn btn-default btn-cmt btn-modify" title="Modify" type="button" style="display: none;">
            <span>Modify</span>
        </button>
        <?php endif?>
        <?php if($memberIdx):?>
        <button class="btn btn-default btn-cmt btn-reply" title="Reply" type="button" onclick="toggle_add_comment(this);">
            <span>Reply</span>
        </button>
        <?php endif?>
    </div>
    <div class="cmt-reply-box" style="display: none;">
    	<br>                      	
        <div class="cmt-input-head cmt-input-box">
            <table cellspacing="0" cellpadding="0" border="0" class="table table-comment" style="margin-bottom: 0.5rem;">
            	<colgroup><col style="width:20%"><col></colgroup>
                <tbody>
                    <tr>
                        <th>Content(*)</th>
                        <td>
                            <textarea class="mb-comment-content mb_comment_reply" name="content"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
    	</div>
        <div class="comment-btn" style="text-align: right;">
            <button class="btn btn-default" title="Comment Reply" type="button" onclick="add_comment('<?=$comment->articleIdx?>', '<?=$comment->id?>', this);">
                <span>Comment Reply</span>
            </button>
        </div>
    </div>
</li>
<?php }?>
<script type="text/javascript">
    <?php if($is_more):?>
        jQuery("#comment_add_list").show();
    <?php else:?>
        jQuery("#comment_add_list").hide();
    <?php endif?>
</script>