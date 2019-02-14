<!--컨텐츠-->
<div class="contents_area_wrap0">
    <!--사이드영역 배경bg-->
    <span class="con_right_line"></span>
    <div class="gpe_contents_box">
        <div class="gpe_pm_conban">
            <div class="gpe_pm_ban_imgbox">             
                <?php foreach($home_sliders as $slider){?>
                <a href="<?=$slider->content?>"><img src="<?=ROOTPATH?>api/image/media/<?=$slider->id?>/790/120" alt="<?=$slider->title?>"/></a>
                <?php }?>
            </div>
            <span class="gpe_prev"></span>
            <span class="gpe_next"></span>
        </div>
        <script>
            var j_bc = jQuery;
            j_bc(function() {
                j_bc('.gpe_pm_conban').slides({
                    preload: true,
                    preloadImage: '<?=ROOTPATH.PROJECT_IMG_DIR?>loading.gif',
                    play: 5000,
                    pause: 1,
                    hoverPause: true
                });
            });
        </script>
        <!--XE컨텐츠-->
        <div class="gpe_contents">
            <!--XE컨텐츠-->
            <div class="gpe_contents_xecon">
                <div class="xe-widget-wrapper" style="float: left; width: 388px; border-width: 0px; border-style: solid; border-color: rgb(0, 0, 0) rgb(255, 255, 255) rgb(0, 0, 0) rgb(0, 0, 0); margin: 10px 15px 0px 0px; background-color: transparent; background-image: none; background-repeat: repeat; background-position: 0% 0%;">
                    <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
                        <div class="gpe_wgPopularT2 b">
                            <h3 class="wgP_title">
                                조회수베스트<a href="<?=ROOTPATH?>news" class="popu_more"></a>
                            </h3>
                            타이틀+더보기
                            <ul class="wgP_contents" id="daily_news">
                                <?php if(isset($daily_news_html)) echo $daily_news_html;?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="xe-widget-wrapper" style="float: left; width: 389px; border-width: 0px; border-style: solid; border-color: rgb(0, 0, 0); margin: 10px 0px 0px; background-color: transparent; background-image: none; background-repeat: repeat; background-position: 0% 0%;">
                    <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
                        <div class="gpe_wgPopularT2 gn">
                            <h3 class="wgP_title">
                                추천수베스트<a href="<?=ROOTPATH?>blogs" class="popu_more"></a>

                            </h3>
                            타이틀+더보기
                            <ul class="wgP_contents">
                                <?php foreach($best_articles2 as $key => $article){?>
                                <li class="popu_li">
                                    <span class="wgPdate"><?=date("M j, Y", strtotime($article->article_date))?></span>
                                    <span class="Ncolor wgp_num0<?=$key+1?><?php if($key == 0):?> wgp_num01M480<?php endif?>">
                                        <?=$key+1?><span class="wgp_numR">위</span>
                                    </span>
                                    <a href="<?=ROOTPATH?>article/<?=$article->id?>"><?=$article->article_title?></a>
                                    <?php if($article->reply_count):?>
                                    <a href="<?=ROOTPATH?>article/<?=$article->id?>#comment" class="reNum">+<?=$article->reply_count?></a>
                                    <?php endif?>
                                    <span class="wgPicon chu"></span>
                                    <span class="wgPiconTxt chu"></span>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if(count($video_news->featured) > 0):?>
                <div class="xe-widget-wrapper" style="float: left; width: 100%; border-width: 0px; border-style: solid; border-color: rgb(0, 0, 0); margin: 2px 0px 0px; background-color: transparent; background-image: none; background-repeat: repeat; background-position: 0% 0%;">
                    <div class="gpe_WS_box">
                        <div class="gpe_WS_h2box" style="margin-bottom:0px;">
                            
                            <span class="gpe_wgTabAbg"></span>
                            
                            <ul id="tabsJustified" class="gpe_wgTabA cp nav nav-tabs" style="margin-bottom:14px; margin-top:25px;">
                                <li class="nav-item active">
                                    <a href="" data-target="#News" data-toggle="tab" class="nav-link small text-uppercase active"><h5 class="margin-top-0 margin-bottom-5" style="margin-bottom: 0;">News</h5></a>
                                </li>
                                <li class="nav-item">
                                    <a href="" data-target="#Drama" data-toggle="tab" class="nav-link small text-uppercase"><h5 class="margin-top-0 margin-bottom-5" style="margin-bottom: 0;">Drama</h5></a>
                                </li>
                                <li class="nav-item">
                                    <a href="" data-target="#Video_news" data-toggle="tab" class="nav-link small text-uppercase"><h5 class="margin-top-0 margin-bottom-5" style="margin-bottom: 0;">Video News</h5></a>
                                </li>
                            </ul>
                            <div id="tabsJustifiedContent" class="tab-content">
                                <div id="News" class="tab-pane fade active show">
                                    <ul id="tabsJustified" class="cp nav nav-tabs" style="margin-bottom:0px;">
                                        <?php 
                                        $item=array_keys($total_video['news']);

                                        for($i=0;$i<count($item);$i++){?>
                                            <?php $j==0?$s='nav-item active':$s='nav-item';
                                                ?>
                                            <li class="<?php echo $s;?>">
                                            <a href="" data-target="<?php echo '#'.$item[$i];?>" data-toggle="tab" class="nav-link small">
                                                <h6 class="margin-top-0 margin-bottom-5" style="margin-bottom: 0;"><?php echo $item[$i];?></h6>
                                            </a>
                                            </li>   
                                        <?php }?>
                                    </ul>
                                    <div id="tabsJustifiedContent" class="tab-content">
                                        <?php 
                                            $item=array_keys($total_video['news']);
                                            for($j=0;$j<count($item);$j++){?>
                                                <?php $j==0?$s='active show':$s='';
                                                ?>
                                                <div id="<?php echo $item[$j];?>" class="tab-pane fade <?php echo $s?>" style="padding-top: 10px">
                                                      <div class="row">
                                                        <?php for($i=0;$i<count($total_video['news'][$item[$j]]);$i++) {
                                                            $video=$total_video['news'][$item[$j]][$i];
                                                            if (!$video) continue;
                                                            ?>
                                                        <div class="col-md-3 col-sm-6 pb-2">
                                                            <a href="<?php echo "http://www.tv.kpabal.com/Home/viewvideo/".$video['video_id'].'/'.$video['api_type']?>" target="_blank">
                                                                <img src="<?php echo $video['image']?>" style="width: 100%;" alt="thumbnail">
                                                                <div title="<?=$video['title']?>" style="color: #d21c77; height: 22px; line-height: 22px; overflow: hidden;"><?=$video['title']?></div>
                                                                <div style="color: #b1afaf; height: 22px; line-height: 22px; overflow: hidden;"><?=$video['create_date']?></div>
                                                            </a>
                                                        </div>
                                                        
                                                        <?php }?>
                                                    </div>
                                                </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div id="Drama" class="tab-pane">
                                    <ul id="tabsJustified" class="gpe_wgTabA cp nav nav-tabs" style="margin-bottom:14px;">
                                            <li class="<?php echo $s;?>">
                                            <a href="" data-target="#" data-toggle="tab" class="nav-link small"><h6 class="margin-top-0 margin-bottom-5" style="margin-bottom: 0;"></h6></a>
                                            </li>   
                                    </ul>
                                    <div id="tabsJustifiedContent" class="tab-content">
                                        <?php
                                            $video=$total_video['drama'];
                                        ?>
                                        <div class="row">
                                            <?php 
                                                for($i=0;$i<10;$i++) 
                                                {
                                                    $video=$total_video['drama'][$i];
                                                    if (!$video) continue;
                                            ?>
                                            <div class="col-md-3 col-sm-6 pb-2">
                                                <a href="<?php echo "http://www.tv.kpabal.com/Home/dramaview/".$video['scrap_id']?>" target="_blank">
                                                    <img src="
                                                    <?php 
                                                        if(empty($video['image_url'])) echo 'http://www.tv.kpabal.com/assets/images/default_image.jpg';
                                                        else echo $video['image_url'];  
                                                    ?>" style="width: 100%;" alt="thumbnail">
                                                    <div title="<?=$video['scrap_title']?>" style="color: #d21c77; height: 22px; line-height: 22px; overflow: hidden;"><?=$video['scrap_title']?></div>
                                                    <div style="color: #b1afaf; height: 22px; line-height: 22px; overflow: hidden;"><?=$video['scrap_date']?></div>
                                                </a>
                                            </div>
                                            <?php
                                              }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div id="Video_news" class="tab-pane">
                                    <ul id="tabsJustified" class="gpe_wgTabA cp nav nav-tabs" style="margin-bottom:14px;">
                                        <li class="<?php echo $s;?>">
                                            <a href="" data-target="#" data-toggle="tab" class="nav-link small"><h6 class="margin-top-0 margin-bottom-5" style="margin-bottom: 0;"></h6></a>
                                        </li>   
                                    </ul>
                                    <div id="tabsJustifiedContent" class="tab-content">
                                        <div class="row">
                                            <?php foreach($video_news->featured as $news){ ?>
                                            <div class="col-md-3 col-sm-6 pb-2">
                                                <a href="<?=$news->article_link?>" target="_blank">
                                                    <img src="<?=ROOTPATH?>api/image/news/<?=$news->id?>/250/190" style="width: 100%;" alt="thumbnail">
                                                    <div style="color: #d21c77; height: 22px; line-height: 22px; overflow: hidden;"><?=$news->article_title?></div>
                                                    <div style="color: #b1afaf; height: 22px; line-height: 22px; overflow: hidden;"><?=$news->article_content?></div>
                                                </a>
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </div>
                            
                        </div>
                        
                    </div>
                </div>
                <?php endif?>

                <div class="xe-widget-wrapper" style="float: left; width: 100%; border-width: 0px; border-style: solid; border-color: rgb(0, 0, 0); margin: 8px 15px 0px 0px; background-color: transparent; background-image: none; background-repeat: repeat; background-position: 0% 0%;">
                    <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
                        <div class="widgetNOVAContainer">
                            <span class="gpe_wgTabAbg"></span>
                            <ul id="tabsJustified" class=" gpe_wgTabA cp nav nav-tabs" style="margin-bottom:14px;">
                                <li class="nav-item active">
                                    <a href="" data-target="#markets" data-toggle="tab" class="nav-link small text-uppercase active"><h5 class="margin-top-0 margin-bottom-5" style="margin-bottom: 0;">Markets</h5></a>
                                </li>
                                <li class="nav-item">
                                    <a href="" data-target="#housing" data-toggle="tab" class="nav-link small text-uppercase"><h5 class="margin-top-0 margin-bottom-5" style="margin-bottom: 0;">Housing</h5></a>
                                </li>
                                <li class="nav-item">
                                    <a href="" data-target="#talky" data-toggle="tab" class="nav-link small text-uppercase"><h5 class="margin-top-0 margin-bottom-5" style="margin-bottom: 0;">Talky</h5></a>
                                </li>
                            </ul>
                            <div id="tabsJustifiedContent" class="tab-content">
                                <div id="markets" class="tab-pane fade active show">
                                    <div class="row gpe_WS_box">
                                        <div class="col-12"><p><a href="https://www.trade.kpabal.com/index.php" class="widgetMoreLink" style="top:0;right:25px;"></a></p></div>
                                        <ul class="gpe_wgGalleryA">
                                            <?php foreach($products as $key => $product){ ?>
                                                <li style="width:175px; margin-bottom:px; <?php if($key % 4 != 3):?>margin-right:30px;<?php else:?>margin-right: 0px;<?php endif?>">
                                                    <a href="https://www.trade.kpabal.com/Productupload/product_details/<?=$product->id?>" class="thumb" style="width:175px;height:175px">
                                                        <img src="<?php echo site_url();?><?=$product->product_image_url;?>" style="width:175px; height:175px" alt="thumbnail">
                                                    </a>
                                                    <a href="https://www.trade.kpabal.com/Productupload/product_details/<?=$product->id?>" class="title" style="overflow: hidden;"><?=$product->product_name?></a>
                                                </li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                </div>
                                <div id="housing" class="tab-pane fade">
                                    <div class="row">
                                    <div class="col-sm-6">
                                        <p style="margin-bottom: 0;">RENT</p>
                                        <table class="table">
                                        <?php
                                        $idx=0;
                                        foreach($rents as $rent){
                                            $idx++;
                                            $logo=$rent['logo'];
                                            $title=$rent['title'];
                                            if(strlen($title)>17)$title=mb_substr($title,0,17)."...";
                                            ?>
                                            <tr>
                                                <td style="width: 100px;">
                                                    <img src="<?=$logo?>" style="height: 50px;width: auto;max-width: none;" />
                                                </td>
                                                <td>
                                                    <a href="<?=ROOTPATH?>housing/rentDetail/<?=$rent['id']?>"><?=$title?></a>
                                                </td>
                                                <td>
                                                    <?=$rent['createDate']?>
                                                </td>
                                            </tr>
                                        <?php
                                            if($idx>=5)break;
                                        }
                                        ?>
                                        </table>
                                    </div>
                                    <div class="col-sm-6">
                                        <p style="margin-bottom: 0;">SALE</p>
                                        <table class="table">
                                            <?php
                                            $idx=0;
                                            foreach($sales as $rent){
                                                $idx++;
                                                $logo=$rent['logo'];
                                                $title=$rent['title'];
                                                if(strlen($title)>17)$title=mb_substr($title,0,17)."...";
                                                ?>
                                                <tr>
                                                    <td style="width: 100px;">
                                                        <img src="<?=$logo?>" style="height: 50px;width: auto;max-width: none;" />
                                                    </td>
                                                    <td>
                                                        <a href="<?=ROOTPATH?>housing/saleDetail/<?=$rent['id']?>"><?=$title?></a>
                                                    </td>
                                                    <td>
                                                    <?=$rent['createDate']?>
                                                </td>
                                                </tr>
                                                <?php
                                                if($idx>=5)break;
                                            }
                                            ?>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                                <div id="talky" class="tab-pane fade"> sss</div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--<div class="xe-widget-wrapper" style="float: left; width: 100%; border-width: 0px; border-style: solid; border-color: rgb(0, 0, 0); margin: 2px 0px 0px; background-color: transparent; background-image: none; background-repeat: repeat; background-position: 0% 0%;">
                    <div class="gpe_WS_box">
                        <div class="gpe_WS_h2box" style="margin-bottom:px;">
                            <h2 class="gpe_contents_wsTitle" style="color:#007bd3;">Markets </h2>
                        </div>
                        <a href="<?=ROOTPATH?>markets" class="widgetMoreLink"></a>
                        <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
                            <div class="widgetNOVAContainer">
                                <div class="gpe_wgGalleryADIV" style="">
                                    <ul class="gpe_wgGalleryA">
                                        <?php foreach($products as $key => $product){ ?>
                                        <li style="width:175px; margin-bottom:px; <?php if($key % 4 != 3):?>margin-right:30px;<?php else:?>margin-right: 0px;<?php endif?>">
                                            <a href="<?=ROOTPATH?>markets/product/<?=$product->id?>" class="thumb" style="width:175px;height:175px">
                                                <img src="<?=ROOTPATH?>api/image/product/<?=$product->id?>/175/175" style="width:175px; height:175px" alt="thumbnail">
                                            </a>
                                            <a href="<?=ROOTPATH?>markets/product/<?=$product->id?>" class="title" style="overflow: hidden;"><?=$product->title?></a>
                                        </li>
                                        <?php }?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
                <div class="xe-widget-wrapper" style="float: left; width: 388px; border-width: 0px; border-style: solid; border-color: rgb(0, 0, 0); margin: 3px 15px 0px 0px; background-color: transparent; background-image: none; background-repeat: repeat; background-position: 0% 0%;">
                    <div class="gpe_WS_box">
                        <div class="gpe_WS_h2box" style="margin-bottom:px;">
                            <h2 class="gpe_contents_wsTitle" style="color:#007bd3;">구인</h2>
                        </div>
                        <a href="<?=ROOTPATH?>jobs/total_jobs" class="widgetMoreLink"></a>
                        <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
                            <div class="widgetNOVAContainer">
                                <div class="gpe_wgListADIV" style="margin-top:-5px;">
                                    <table class="gpe_wgListA" cellspacing="0">
                                        <tbody>
                                            <?php
                                            $idx=0;
                                            foreach($jobs as $job){
                                                $idx++;
                                                if($idx>5)break;
                                                $title=$job['title'];
                                                if(strlen($title)>17)$title=mb_substr($title,0,17)."...";
                                                ?>
                                            <tr>
                                                <td>
                                                    <span><?=$job['company_name']?></span>
                                                </td>
                                                <td class="">
                                                    <a href="<?=ROOTPATH?>jobs/details/<?=$job['id']?>" class="" title="<?=$job['title']?>"><?=$title?></a>
                                                </td>
                                                <td class="">
                                                    <span><?=$job['post_date']?></span>
                                                </td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xe-widget-wrapper" style="float: left; width: 389px; border-width: 0px; border-style: solid; border-color: rgb(0, 0, 0); margin: 3px 0px 0px; background-color: transparent; background-image: none; background-repeat: repeat; background-position: 0% 0%;">
                    <div class="gpe_WS_box">
                        <div class="gpe_WS_h2box" style="margin-bottom:px;">
                            <h2 class="gpe_contents_wsTitle" style="color:#39b54a;">구직</h2>
                        </div>
                        <a href="<?=ROOTPATH?>jobs/total_persons" class="widgetMoreLink"></a>
                        <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
                            <div class="widgetNOVAContainer">
                                <div class="gpe_wgListADIV" style="margin-top:-5px;">
                                    <table class="gpe_wgListA" cellspacing="0">
                                        <tbody>
                                            <?php
                                            $idx=0;
                                            foreach($persons as $person){
                                                $idx++;
                                                if($idx>5)break;
                                                $title=$person['title'];
                                                if(strlen($title)>17)$title=mb_substr($title,0,17)."...";
                                                ?>
                                            <tr>
                                                <td>
                                                    <span><?=$person['name']?></span>
                                                </td>
                                                <td class="">
                                                    <a href="<?=ROOTPATH?>jobs/details_person/<?=$person['id']?>" class="" title="<?=$person['title']?>"><?=$title?></a>
                                                </td>
                                                <td class="">
                                                    <span><?=$person['post_date']?></span>
                                                </td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xe-widget-wrapper" style="float: left; width: 100%; border-width: 0px; border-style: solid; border-color: rgb(0, 0, 0); margin: 10px 0px 0px; background-color: transparent; background-image: none; background-repeat: repeat; background-position: 0% 0%;">
                    <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
                        <div class="widgetNOVAContainer">
                            탭
                            사용자 컬러만 스타일뺏음
                            <span class="gpe_wgTabAbg"></span>
                            <ul class=" gpe_wgTabA r">
                                <?php foreach($news_categories as $key => $category){
                                    if($key >= 5) break;
                                ?>
                                <li<?php if($key == 0):?> class="active"<?php endif?>>
                                    <p class="gpe_wTA_item" style="width:157px;" onclick="content_wgNOVA_tab_show(jQuery(this),jQuery(this).parents(&#39;ul.gpe_wgTabA&#39;).next(&#39;dl.widgetNovaDivider&#39;),<?=$key?>)"><?=$category->categoryName?></p>
                                </li>
                                <?php }?>
                            </ul>
                            위젯컨텐츠
                            <dl class="widgetNovaDivider">                              
                                <?php foreach($news_categories as $key => $category){
                                    if($key >= 5) break;
                                ?>
                                <dt><?=$category->categoryName?></dt>
                                <dd<?php if($key == 0):?> class="open"<?php endif?>>
                                    <div class="gpe_wgListADIV">
                                        <table class="gpe_wgListA" cellspacing="0">
                                            <tbody>
                                                <?php foreach($category->news as $news){?>
                                                <tr>
                                                    <td class="category">
                                                        [<?=$news->article_source?>]
                                                    </td>
                                                    <td class="title">
                                                        <a href="<?=$news->article_link?>" class="title" target="_blank"><?=$news->article_title?></a>
                                                    </td>
                                                    <td class=""></td>
                                                    <td class="date">
                                                        <span><?=date("M j, Y", strtotime($news->article_date))?></span>
                                                    </td>
                                                </tr>
                                                <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </dd>
                                <?php }?>
                            </dl>
                        </div>
                    </div>
                </div>                
                <div class="xe-widget-wrapper" style="float: left; width: 388px; border-width: 0px; border-style: solid; border-color: rgb(0, 0, 0); margin: 8px 15px 0px 0px; background-color: transparent; background-image: none; background-repeat: repeat; background-position: 0% 0%;">
                    <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
                        <div class="widgetNOVAContainer">
                            <span class="gpe_wgTabAbg"></span>
                            <ul class=" gpe_wgTabA cp" style="margin-bottom:14px;">
                                <?php foreach($blog_categories as $key => $category){
                                    if($key >= 3) break;
                                ?>
                                <li<?php if($key == 0):?> class="active"<?php endif?>>
                                    <p class="gpe_wTA_item" style="width:127px;" onclick="content_wgNOVA_tab_show(jQuery(this),jQuery(this).parents(&#39;ul.gpe_wgTabA&#39;).next(&#39;dl.widgetNovaDivider&#39;),<?=$key?>)"><?=$category->categoryName?></p>
                                </li>
                                <?php }?>
                            </ul>
                            <dl class="widgetNovaDivider">
                                <?php foreach($blog_categories as $key => $category){
                                    if($key >= 3) break;
                                ?>
                                <dt><?=$category->categoryName?></dt>
                                <dd<?php if($key == 0):?> class="open"<?php endif?>>
                                    <div class="gpe_wgZineADIV">
                                        <ul class="wgP_contents">
                                            <?php foreach($category->articles as $article){?>
                                            <li class="popu_li" style="margin-bottom: 0;">
                                                <span class="wgPdate" style="float: right;"><?=date("M j, Y", strtotime($article->article_date))?></span>
                                                <a href="<?=ROOTPATH?>article/<?=$article->id?>"><?=$article->article_title?></a>
                                                <?php if($article->reply_count):?>
                                                <a href="<?=ROOTPATH?>article/<?=$article->id?>#comment" class="reNum">+<?=$article->reply_count?></a>
                                                <?php endif?>
                                            </li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                </dd>
                                <?php }?>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="xe-widget-wrapper" style="float: left; width: 389px; border-width: 0px; border-style: solid; border-color: rgb(0, 0, 0); margin: 8px 0px 0px; background-color: transparent; background-image: none; background-repeat: repeat; background-position: 0% 0%;">
                    <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
                        <div class="widgetNOVAContainer">
                            <span class="gpe_wgTabAbg"></span>
                            <ul class=" gpe_wgTabA cp" style="margin-bottom:14px;">
                                <?php foreach($blog_categories as $key => $category){
                                    if($key < 3) continue;
                                    if($key >= 6) break;
                                ?>
                                <li<?php if($key == 3):?> class="active"<?php endif?>>
                                    <p class="gpe_wTA_item" style="width:127px;" onclick="content_wgNOVA_tab_show(jQuery(this),jQuery(this).parents(&#39;ul.gpe_wgTabA&#39;).next(&#39;dl.widgetNovaDivider&#39;),<?=($key - 3)?>)"><?=$category->categoryName?></p>
                                </li>
                                <?php }?>
                            </ul>
                            <dl class="widgetNovaDivider">
                                <?php foreach($blog_categories as $key => $category){
                                    if($key < 3) continue;
                                    if($key >= 6) break;
                                ?>
                                <dt><?=$category->categoryName?></dt>
                                <dd<?php if($key == 3):?> class="open"<?php endif?>>
                                    <div class="gpe_wgZineADIV">
                                        <ul class="wgP_contents">
                                            <?php foreach($category->articles as $article){?>
                                            <li class="popu_li" style="margin-bottom: 0;">
                                                <span class="wgPdate" style="float: right;"><?=date("M j, Y", strtotime($article->article_date))?></span>
                                                <a href="<?=ROOTPATH?>article/<?=$article->id?>"><?=$article->article_title?></a>
                                                <?php if($article->reply_count):?>
                                                <a href="<?=ROOTPATH?>article/<?=$article->id?>#comment" class="reNum">+<?=$article->reply_count?></a>
                                                <?php endif?>
                                            </li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                </dd>
                                <?php }?>
                            </dl>
                        </div>
                    </div>
					
                </div>
				
			
            </div>
            
           
            
        </div>
     
         <?php include_once(__DIR__."/common/sidebar.php");?>
         <div style="clear:both"></div>
    </div>
    <!--[SIDE컨텐츠_우측]-->
    
</div>
