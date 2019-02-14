<?php foreach($articles as $article){?>
<tr>
    <td class="col-no d-none d-md-table-cell"><?=$article->id?></td>
    <td><a href="<?=ROOTPATH?>article/<?=$article->id?>"><?=$article->article_title?><?php if($article->reply_count > 0):?> [<?=$article->reply_count?>]<?php endif?></a> <?php if(strtotime($article->regDate) + 86400 > time()):?><img class="user-i-level mb-level-10" src="<?=ROOTPATH.PROJECT_IMG_DIR?>bbs_basic/icon_new.gif"><?php endif?></td>
    <td class="col-author d-none d-ssm-table-cell"><?=$article->memberName?></td>
    <td class="col-date d-none d-sm-table-cell"><?=date("M j, Y", strtotime($article->regDate))?><br><?=date("H:i", strtotime($article->regDate))?></td>
    <td class="col-hit d-none d-md-table-cell"><?=$article->good_count?></td>
</tr>
<?php }?>
<script type="text/javascript">
	total_page = "<?=$totalPages?>";
</script>