<style type="text/css">
.breadcrumb-item + .breadcrumb-item::before {
    content: "|";
}
.breadcrumb-item.active {
    color: #ff1c77;
}
.trt_is_blog .breadcrumb-item a:link, .trt_is_blog .breadcrumb-item a:active, .trt_is_blog .breadcrumb-item a:visited {
    color: green;
}
.trt_is_blog .breadcrumb-item a:hover {
    color: #ff1c77;
}
</style>
<div class="trt_is_blog trt_is_blog_www trt_is_home">
    <?php if($news):?>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb" style="height: auto; position: static !important; padding: 0.75rem 1rem !important; margin: 0 0 1rem 0 !important; background-color: #e9ecef !important;">        
        <li class="breadcrumb-item active" aria-current="page">All</li>
        <?php foreach($news_categories as $category){?>        
        <li class="breadcrumb-item"><a href="<?=ROOTPATH?>news/<?=$category->categoryIdx?>"><?=$category->categoryName?></a></li>
        <?php }?>
      </ol>
    </nav>
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
        
        $featured_rows = count($news->featured) - count($news->featured) % 3;
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="row" style="margin-left: 0px; margin-right: 0px;">
                <div class="col-md-6 col-sm-12">
                    <?php for($i=0; $i<($featured_rows / 3); $i++) drawArticle($news->featured[$i]); ?>
                </div>
                <div class="col-md-6 col-sm-12">
                    <?php for($i=($featured_rows / 3); $i<$featured_rows; $i++) drawArticle($news->featured[$i], ' trt-card_size_S'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row" style="margin-left: 0px; margin-right: 0px;">
        <?php 
            $category_idx = 0;
            foreach($news->category_news as $category_news){
                if(count($category_news) == 0) continue;
        ?>
                <div class="col-md-6 col-sm-12">
                    <div class="trt-showcase">
                        <div class="trt-showcase__label">
                            <h2 class="trt-showcase__title ">
                                <a class="trt-showcase__link" title="<?=$category_news[0]->categoryName?>" target="_blank" href="<?=ROOTPATH?>news/<?=$category_news[0]->categoryIdx?>"><?=$category_news[0]->categoryName?></a>
                            </h2>
                        </div>
                        
                        <?php 
                            if(($category_idx % 4 == 0) || ($category_idx % 4 == 3)) {
                                for($i=0; $i<count($category_news); $i++) if($i<2) drawArticle($category_news[$i]);
                            } else {
                                echo '<div class="row" style="margin-left: 0px; margin-right: 0px;"><div class="col-sm-6">';
                                drawArticle($category_news[0], ' trt-card_size_M');
                                echo '</div><div class="col-sm-6">';
                                if(count($category_news) > 1) drawArticle($category_news[1], ' trt-card_size_M');
                                echo '</div></div>';
                                if(count($category_news) > 2) drawArticle($category_news[2], ' trt-card_size_S');
                                if(count($category_news) > 3) drawArticle($category_news[3], ' trt-card_size_S');
                            }
                        ?>
                    </div>
                </div>
        <?php 
                if($category_idx % 4 == 1) echo '<div class="clearfix"></div>';
                $category_idx++;
            }?>
            </div>
        </div>
    </div>    
    <?php endif?>
</div>