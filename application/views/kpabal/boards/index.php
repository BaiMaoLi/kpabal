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
                                조회수베스트<a href="<?=ROOTPATH?>blogs" class="popu_more"></a>
                            </h3>
                            <!--타이틀+더보기-->
                            <ul class="wgP_contents">
                            	<?php foreach($best_articles as $key => $article){?>
                                <li class="popu_li">
                                    <span class="wgPdate"><?=date("M j, Y", strtotime($article->article_date))?></span>
                                    <span class="Ncolor wgp_num0<?=$key+1?>">
                                        <?=$key+1?><span class="wgp_numR">위</span>
                                    </span>
                                    <a href="<?=ROOTPATH?>article/<?=$article->id?>"><?=$article->article_title?></a>
                                    <?php if($article->reply_count):?>
                                    <a href="<?=ROOTPATH?>article/<?=$article->id?>#comment" class="reNum">+<?=$article->reply_count?></a>
                                    <?php endif?>
                                    <span class="wgPicon jo"></span>
                                    <span class="wgPiconTxt jo"></span>
                                </li>
                                <?php }?>
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
                            <!--타이틀+더보기-->
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
                <?php foreach($blog_categories as $key => $category){
                    if(count($category->articles) == 0) continue;
                ?>
                <div class="xe-widget-wrapper" style="float: left; width: 100%; border-width: 0px; border-style: solid; border-color: rgb(0, 0, 0); margin: 2px 0px 0px; background-color: transparent; background-image: none; background-repeat: repeat; background-position: 0% 0%;">
                    <div class="gpe_WS_box">
                        <div class="gpe_WS_h2box" style="margin-bottom:0px;">
                            <h2 class="gpe_contents_wsTitle" style="color:#007bd3;"><?=$category->categoryName?> </h2>
                        </div>
                        <a href="<?=ROOTPATH?>blogs/category/<?=$category->categoryIdx?>" class="widgetMoreLink"></a>
                    </div>
                </div>
                <div class="xe-widget-wrapper" style="float: left; width: 100%; border-width: 0px; border-style: solid; border-color: rgb(0, 0, 0); margin: 10px 0px 0px; background-color: transparent; background-image: none; background-repeat: repeat; background-position: 0% 0%;">
                    <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
                        <div class="widgetNOVAContainer">
                            <dl class="widgetNovaDivider">
                                <dt><?=$category->categoryName?></dt>
                                <dd class="open">
                                    <div class="gpe_wgListADIV">
                                        <table class="gpe_wgListA" cellspacing="0">
                                            <tbody>
                                            	<?php foreach($category->articles as $article){?>
                                                <tr>
                                                    <td class="category">
                                                        [<?=$article->categoryName?>]
                                                    </td>
                                                    <td class="title">
                                                        <a href="<?=ROOTPATH?>article/<?=$article->id?>" class="title"><?=$article->article_title?></a>
                                                    </td>
                                                    <td class=""><?=$article->memberName?></td>
                                                    <td class="date">
                                                        <span><?=date("M j, Y", strtotime($article->regDate))?></span>
                                                    </td>
                                                </tr>
                                                <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--prev_next_bottom-->
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
    <!--[SIDE컨텐츠_우측]-->
    <?php include_once(__DIR__."/../common/sidebar.php");?>
</div>