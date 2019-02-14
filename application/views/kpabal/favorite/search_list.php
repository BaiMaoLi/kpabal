<?php if($where == "review-tab"):?>
<?php foreach ($result as $comment){?>
<div class="shadow-sm p-3 mb-1 bg-white rounded business_prefered">
    <img src="<?=ROOTPATH?>api/image/business/<?=$comment->business_id?>/138/100" width="138" height="100" class="rounded" style="float: left;">
    <div class="ml-3" style="float: left; width: calc(100% - 158px);">
        <a href="<?=ROOTPATH?>business/<?=$comment->business_id?>" class="business_link"><?=$comment->business_name_ko?></a>
        <br>
        <span class="review_rating_link" style="font-size: 11px;">
        <?php 
        $rating = round(($comment->rating_1 + $comment->rating_2 + $comment->rating_3 + $comment->rating_4) / 4, 0); 
        if($rating > 5) $rating = 5; if($rating < 0) $rating = 0;
        for($i=0; $i<$rating; $i++)
            echo '<span class="fas fa-star checked"></span>';
        for($i=$rating; $i<5; $i++)
            echo '<span class="fas fa-star"></span>'; ?>
        </span>
        <span class="comment_date"><?=date("M j, Y", strtotime($comment->comment_date))?></span>
        <br>        
        <?=$comment->comment_content?>
    </div>
    <div class="action_button">
        <button type="button" class="btn btn-outline-success btn_uncomment" style="font-size: 12px; line-height: 12px; padding: 7px 7px 5px;" value="<?=$comment->id?>" title="Remove Comment"><i class="far fa-trash-alt"></i></button>
    </div>
    <div class="clearfix"></div>
</div>
<?php }?>
<?php else:?>
<?php foreach($result as $business){?>
<div class="shadow-sm p-3 mb-1 bg-white rounded business_prefered">
    <img src="<?=ROOTPATH?>api/image/business/<?=$business->id?>/138/100" width="138" height="100" class="rounded" style="float: left;">
    <div class="business_record">
        <a href="<?php if($where == "home-tab"):?><?=ROOTPATH?>favorites/business/<?=$business->id?><?php else:?><?=ROOTPATH?>business/<?=$business->id?><?php endif?>" class="business_link"><?=$business->business_name_ko?></a><br>
        <?php if(($business->address) || ($business->street) || ($business->city) || ($business->zip) || ($business->stateCode)):?>
        <span><?=$business->address?> <?=$business->street?><?php if($business->city) echo ', '.$business->city;?><?php if($business->zip) echo ', '.$business->zip;?><?php if($business->stateCode) echo ', '.$business->stateCode;?></span><br>
        <?php endif?>
        <span><?=$business->work_time?></span><br>
        <span><?=$business->phone1?></span>
        <br>
        <?php $rating = round($business->rating, 0); if($rating > 5) $rating = 5; if($rating < 0) $rating = 0;
            for($i=0; $i<$rating; $i++)
                echo '<span class="fas fa-star checked"></span>';
            for($i=$rating; $i<5; $i++)
                echo '<span class="fas fa-star"></span>';
            if($business->reviews):?> <span> / <?=$business->reviews?> People</span><?php endif?>        
    </div>
    <div class="action_button">
        <?php if($where == "home-tab"):?>
        <a class="btn btn-outline-success btn_unfavorite" style="font-size: 12px; line-height: 12px; padding: 6px 5px 6px 7px;" href="<?=ROOTPATH?>favorites/business/<?=$business->id?>" title="Edit Info"><i class="fas fa-edit"></i></a>
        <?php else:?>
        <button type="button" class="btn btn-outline-success btn_unfavorite" style="font-size: 12px; line-height: 12px; padding: 7px 7px 5px;" value="<?=$business->id?>" title="Unfavorite"><i class="fas fa-heart"></i></button>
        <?php endif?>
    </div>
    <div class="clearfix"></div>
</div>
<?php }?>
<?php endif?>
<?php if($where == "home-tab"):?>
<div class="p-3 mb-1 bg-white">
    <a class="btn btn-outline-success" style="font-size: 12px;" href="<?=ROOTPATH?>favorites/business/new" title="Add new business"><i class="fas fa-plus"></i> Add New Business</a>
</div>
<?php endif?>
<nav class="mt-3">
  <ul class="pagination justify-content-end" style="margin-bottom: 0px;">
    <li class="page-item<?php if($current_page == 0) echo ' disabled';?>">
      <a class="page-link" href="#" tabindex="-1" value="<?=$current_page - 1?>">Previous</a>
    </li>
    <?php for($i=0; $i<$total_page; $i++){
        if(abs($current_page - $i) > 2) continue;
    ?>
    <li class="page-item<?php if($current_page == $i) echo ' active disabled';?>"><a class="page-link" href="#" value="<?=$i?>"><?=$i + 1?></a></li>
    <?php }?>
    <li class="page-item<?php if($current_page == $total_page - 1) echo ' disabled';?>">
      <a class="page-link" href="#" value="<?=$current_page + 1?>">Next</a>
    </li>
  </ul>
</nav>