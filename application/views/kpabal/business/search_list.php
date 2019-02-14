<?php 
    $business_type = "";
    foreach($result as $business){
        if($business->admin_pre_order_chk) $real_type = "premium";
        else $real_type = "regular";
        if($business_type != $real_type) {
?>
<div style="background: url(<?=ROOTPATH?><?=PROJECT_IMG_DIR?>titie_<?=$real_type?>.gif) no-repeat; height: 35px; margin-top: 15px; border-bottom: solid 2px #e4178b !important; text-align: right;">
    <?php if($real_type != "regular"):?>
    <a><img src="<?=ROOTPATH?><?=PROJECT_IMG_DIR?>btn_<?=$real_type?>.gif"></a>
    <?php endif?>
</div>
<?php
        }
        $business_type = $real_type;
?>
<div class="shadow-sm p-3 mb-1 bg-white rounded<?php if($business->admin_pre_order_chk):?> business_prefered<?php else:?> business_free<?php endif?>">
<?php if($business->admin_pre_order_chk):?>
    <img src="<?=ROOTPATH?>api/image/business/<?=$business->id?>/138/100" width="138" height="100" class="rounded" style="float: left;">
<?php endif?>
    <div class="<?php if($business->admin_pre_order_chk):?>business_record<?php else:?>business_record_general<?php endif?>">
        <a href="<?=ROOTPATH?>business/<?=$business->id?>" class="business_link"><?php echo $business->business_name_ko;?></a><br>
        <?php if(($business->address) || ($business->street) || ($business->city) || ($business->zip) || ($business->stateCode)):?>
        <span><?=$business->address?> <?=$business->street?><?php if($business->city) echo ', '.$business->city;?><?php if($business->zip) echo ', '.$business->zip;?><?php if($business->stateCode) echo ', '.$business->stateCode;?></span><br>
        <?php endif?>
        <?php if($business->work_time):?><span><?=$business->work_time?></span><br><?php endif?>
        <span><?=$business->phone1?></span>
        <?php if($business->admin_pre_order_chk):?><br><?php else:?><div class="rating_link"><?php endif?>
        <?php $rating = round($business->rating, 0); if($rating > 5) $rating = 5; if($rating < 0) $rating = 0;
            for($i=0; $i<$rating; $i++)
                echo '<span class="fas fa-star checked"></span>';
            for($i=$rating; $i<5; $i++)
                echo '<span class="fas fa-star"></span>';
            if($business->reviews > -1):?> <span> / <?=$business->reviews?> People</span><?php endif?>
        <?php if($business->admin_pre_order_chk):?><?php else:?></div><?php endif?>
    </div>
    <div style="clear: both;"></div>
</div>
<?php }?>
<nav class="mt-3">
  <ul class="pagination justify-content-end">
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