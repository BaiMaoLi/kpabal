<?php
    function drawArticle($article, $class=''){
            $categoryCode = $article->categoryCode;
            echo '
    <article class="trt-card'.$class.' rounded shadow-sm" style="margin-bottom: 1.25rem !important;">
        <div class="trt-card__content">
            <div class="trt-card__category">
                <a class="trt-card__category-link" href="'.ROOTPATH.'news/'.$article->categoryIdx.'" title="'.$article->categoryName.'">'.$article->categoryName.'</a>
            </div>
            <h2 class="trt-card__title">
                <a class="trt-card__link" target="_blank" href="'.$article->article_link.'" title="'.$article->article_title.'">'.$article->article_title.'</a>
            </h2>
            <div class="trt-card__text">
                <a class="trt-card__link_second" target="_blank" href="'.$article->article_link.'">'.$article->article_content.'</a>
            </div>
            <div class="trt-card__footer">
                <div class="trt-card__published"><time>'.date("M j, Y", strtotime($article->article_date)).'</time></div>
                <div class="trt-card__tag">'.$article->article_source.'</div>
            </div>
        </div>
        <a class="trt-card__link_second" target="_blank" href="'.$article->article_link.'">
            <div class="trt-card__image">
                <div class="trt-thumb" style="background-image: url('.ROOTPATH.'api/image/news/'.$article->id.'/680/510);"></div>';
            if($categoryCode == "video") 
                echo '<div class="trt-thumb" style="position:  absolute;top: 0;background-image: url('.ROOTPATH.PROJECT_IMG_DIR.'play-video2.png);background-size: initial;background-repeat: no-repeat; z-index:100;"></div>';
            echo '</div>
        </a>
    </article>';
    }

    if(count($result) > 0):
?>
<div class="row">
    <div class="col-md-12">
        <div class="row" style="margin-left: 0px; margin-right: 0px;">                
            <div class="col-md-6 col-sm-12">
                <?php for($i=0; $i<count($result); $i+=3) drawArticle($result[$i]); ?>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="trt-showcase">
                <?php for($i=1; $i<count($result); $i+=6) {
                    echo '<div class="row" style="margin-left: 0px; margin-right: 0px;"><div class="col-sm-6">';
                    drawArticle($result[$i], ' trt-card_size_M');
                    echo '</div><div class="col-sm-6">';
                    if(count($result) > $i + 1) drawArticle($result[$i + 1], ' trt-card_size_M');
                    echo '</div></div>';
                    if(count($result) > $i + 3) drawArticle($result[$i + 3], ' trt-card_size_S');
                    if(count($result) > $i + 4) drawArticle($result[$i + 4], ' trt-card_size_S');
                }?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif?>
<?php if($total_page <= $current_page + 1):?>
    <script type="text/javascript">
        $("#load_more").hide();
    </script>
<?php endif?>