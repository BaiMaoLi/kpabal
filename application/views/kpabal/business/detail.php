<style type="text/css">
    @media (max-width: 1024px) {
        .row.content_container {
            margin-left: 0px;
            margin-right: 0px;
        }
    }

    .review_textarea {
        float:left;
        width: calc(100% - 320px);
        line-height: 21px;
        padding: 0.5rem;
    }

    @media (max-width: 570px) {
        .review_textarea {
            width: calc(100% - 90px);
        }
    }
    .content_container .form-control {
        font-size: 0.8rem;
    }
    .fa-star {
        color: #cecece;
    }
    .fa-star.checked {
        color: orange;
    }
    .breadcrumb-item a {
        color: #c71c77;
    }
    .name {
        color: #c71c77;
        margin-bottom: 0.5rem;
    }
    .rating_link {
        display: inline-block;
        background-color: #e2dede75;
        padding: 4px 13px;
        border-radius: 15px;
        font-size: 12px;
        border: solid 1px #8080801c;
    }
    .business_home_info {
        width: 30px;
        text-align: center;
        color: #a017608a;
    }
    .review_form {
        height: 100px;
        background: url(<?=ROOTPATH.PROJECT_IMG_DIR?>bg_review.png) no-repeat;
        border: solid 1px #da81b16b;
        border-radius: 4px;
    }
    .rate_label {
        display: inline-block;
        width: 50px;
        text-align: right;
    }
    .rating {
        cursor: pointer;
    }
    .user_name {
        color: #c71c77;
        font-weight: 600;
        display: inline-block;
    }
    .comment_date {
        color: #888888;
        font-size: 12px;
    }    
    .review_rating_link {
        display: inline-block;
        background-color: #e2dede75;
        padding: 3px 10px;
        border-radius: 10px;
        font-size: 10px;
        border: solid 1px #8080801c;
    }
</style>
<?php 
    $userid = $loggedinuser['memberIdx'];
?>
<div class="contents_area_wrap0">    
    <div class="gpe_contents_box">
        <div class="row content_container">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" style="height: 30px;">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>business">Yellow Page</a></li>
                    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>business?categoryIdx=<?=$business->categoryIdx?>"><?=$business->categoryName?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?=$business->business_name_ko?></li>
                  </ol>
                </nav>
            </div>
            <div class="col-sm-6 mb-3">
                <h3 class="name"><?=$business->business_name_ko?></h3>
                <span class="rating_link">
                <?php $rating = round($business->rating, 0); if($rating > 5) $rating = 5; if($rating < 0) $rating = 0;
                for($i=0; $i<$rating; $i++)
                    echo '<span class="fas fa-star checked"></span>';
                for($i=$rating; $i<5; $i++)
                    echo '<span class="fas fa-star"></span>';
                if($business->reviews):?> <span> / <?=$business->reviews?> People</span><?php endif?>
                  <span>  | Views : <?=$business->views_count?> </span>
                </span>
                <?php if(($business->address) || ($business->street) || ($business->city) || ($business->zip) || ($business->stateCode)):?>
                <div class="mt-3"><i class="fas fa-map-marker-alt business_home_info"></i> <?=$business->address?> <?=$business->street?><?php if($business->city) echo ', '.$business->city;?><?php if($business->zip) echo ', '.$business->zip;?><?php if($business->stateCode) echo ', '.$business->stateCode;?></div>
                <?php endif?>
                <?php if($business->work_time):?><div><i class="far fa-clock business_home_info"></i> <?=$business->work_time?></div><?php endif?>
                <div><i class="fas fa-phone-square business_home_info"></i> <a href="tel:<?=str_replace(" ", "", str_replace("-", "", $business->phone1))?>"><?=$business->phone1?></a></div>
                <?php if($business->phone2):?><div><i class="fas fa-phone-square business_home_info"></i> <a href="tel:<?=str_replace(" ", "", str_replace("-", "", $business->phone2))?>"><?=$business->phone2?></a></div><?php endif?>
                <?php if($business->fax):?><div><i class="fas fa-fax business_home_info"></i> <?=$business->fax?></div><?php endif?>
                <?php if($business->website):?><div><i class="fab fa-safari business_home_info"></i> <a href="<?=$business->website?>"><?=$business->website?></a></div><?php endif?>                
                <?php if($business->email):?><div><i class="far fa-envelope business_home_info"></i> <a href="mailto:<?=$business->email?>"><?=$business->email?></a></div><?php endif?>
                <div class="mt-3" style="text-align: right;">
                    <button type="button" class="btn btn-outline-success" style="font-size: 12px;" id="btn_favorite"><i class="<?php if($business->favorite):?>fas<?php else:?>far<?php endif?> fa-heart"></i> Favorite</button>
                    <?php if(($business->longitude) && ($business->latitude) && ($business->longitude != 0) && ($business->latitude != 0)):?>
                    <button type="button" class="btn btn-outline-info" style="font-size: 12px;" id="btn_maps" data-toggle="modal" data-target="#myMapModal" data-lat='<?=$business->latitude?>' data-lng='<?=$business->longitude?>'><i class="fas fa-map-marker-alt"></i> Google Maps</button><?php endif?>
                    <button type="button" class="btn btn-outline-danger" style="font-size: 12px;" id="btn_edit"><i class="far fa-edit"></i> Edit Info</button>
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <img src="<?=ROOTPATH?>api/image/business/<?=$business->id?>/552/400" class="rounded" style="width: 100%;">
            </div>
            <div class="col-sm-12">
                <div class="review_form">
                    <div style="float:left; width: 90px; text-align: center; color: white; font-size: 0.8rem; line-height: 32px;">
                        <div>Rating</div>
                        <div style="font-size: 2rem; font-weight: 600;"><?=number_format($business->rating, 1)?></div>
                        <div><?=$business->reviews?> People<?php if($business->reviews>1):?>s<?php endif?></div>
                    </div>
                    <div style="float:left; width:24px; height: 100px;">
                    </div>                    
                    <div style="float:left;width: 116px;font-size: 11px;line-height: 21px;" class="pt-2">
                        <div class="rating"><span class="rate_label">Pricing</span> <?php for($i=0; $i<5; $i++){?><span class="fas fa-star"></span><?php }?></div>
                        <div class="rating"><span class="rate_label">Reliability</span> <?php for($i=0; $i<5; $i++){?><span class="fas fa-star"></span><?php }?></div>
                        <div class="rating"><span class="rate_label">Quality</span> <?php for($i=0; $i<5; $i++){?><span class="fas fa-star"></span><?php }?></div>
                        <div class="rating"><span class="rate_label">Service</span> <?php for($i=0; $i<5; $i++){?><span class="fas fa-star"></span><?php }?></div>
                    </div>
                    <div class="review_textarea">
                        <textarea class="form-control" id="txt_review" style="height: 80px;" placeholder="Please wrtie ratings and reviews (Including both Korean and English)"></textarea>
                    </div>
                    <div style="float:left; width: 90px; padding: 0.5rem 0.25rem;">
                        <button type="button" class="btn btn-outline-info" style="font-size: 12px; height: 80px;" id="btn_review"><i class="far fa-edit"></i> Write<br> a Review</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-sm-12">
                <?php foreach ($business->comments as $comment){?>
                <div class="shadow-sm p-3 mb-1 bg-white rounded">
                    <img src="<?=ROOTPATH?>api/image/avatar/<?=$comment->memberIdx?>/70/70" width="70" height="70" class="rounded-circle" style="border:solid 1px #c71c7766; float: left;">
                    <div class="ml-3" style="float: left; width: calc(100% - 100px);">
                        <span class="user_name mr-2"><?=$comment->user_id?></span>
                        <span class="comment_date"><?=date("M j, Y", strtotime($comment->comment_date))?></span>
                        <br>
                        <span class="review_rating_link"> Rating
                        <?php 
                        $rating = round(($comment->rating_1 + $comment->rating_2 + $comment->rating_3 + $comment->rating_4) / 4, 0); 
                        if($rating > 5) $rating = 5; if($rating < 0) $rating = 0;
                        for($i=0; $i<$rating; $i++)
                            echo '<span class="fas fa-star checked"></span>';
                        for($i=$rating; $i<5; $i++)
                            echo '<span class="fas fa-star"></span>'; ?>
                        </span> <br>
                        <?=$comment->comment_content?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php }?>
            </div>
            <?php if($business->options):?>
            <div class="col-sm-12 mt-3">
                <div style="color: #c71c77; font-weight: bold;">Business Detail Info</div>
                <?php foreach ($business->options as $option){?>
                <div style="line-height: 24px;" class="rounded">
                    <div class="option_code float-left" style="width: 100px; color: #ce430e;"><?=$option->option_code?></div>
                    <div class="option_value float-left" style="width: calc(100% - 120px);"><?=$option->option_value?></div>
                    <div class="clearfix"></div>
                </div>
                <?php }?>
            </div>
            <?php endif?>
            <?php if($business->business_description):?>
            <div class="col-sm-12 mt-3">
                <div style="color: #c71c77; font-weight: bold;">More Information</div>
                <?=implode("<br>", explode("\n", $business->business_description))?>
            </div>
            <?php endif?>
            <div class="col-sm-12 mt-3" style="color: #d45626;">
                <?php if($business->business_keyword):?>
                <i class="fas fa-tags"></i> <?=$business->business_keyword?>
                <?php endif?>
            </div>
        </div>
    </div>
    <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyB1_cca3KUssaymD-nx0yRKQyHcFFAfxp0"></script>
    <?php include_once(__DIR__."/../common/sidebar.php");?>

</div><!-- #content end -->