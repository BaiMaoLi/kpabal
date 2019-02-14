</div>
<link rel="stylesheet" href="<?=ROOTPATH?>assets/css/talky.css">
<link rel="stylesheet" href="<?=ROOTPATH?>assets/css/talky_component.css">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick-theme.css"/>
<link rel="stylesheet" href="<?=ROOTPATH?>assets/css/magicsuggest.css">
<style>
    .slick-initialized .slick-slide {
        padding: 10px;
    }
    .list{
        padding: 0 30px;
    }
    .slick-prev {
        left: 10px;
    }
    .slick-next {
        right: 10px;
    }
    figcaption p{
        display:none;
    }
    .grid li .wrap figure img, .grid li .wrap figure video {
        border-radius: 10px;
    }
    .grid li .wrap {
        outline: 0;
        border-radius: 10px;
    }
    .grid li .wrap .share,.grid li .wrap .user{
        display:none;
    }
    .slick-prev:before, .slick-next:before {
        color: #757373;
    }
    a.Tag {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        border-radius: 3px;
        background-color: rgba(121,67,200,.8);
        background-size: auto 115px;
        background-repeat: repeat-x;
        background-position: 100% 0;
        transition: transform .3s;
        -webkit-transition: transform .3s;
        margin: 6px 6px 0;
    }
    .Tag>div {
        border-radius: 0 0 3px 3px;
    }
    .Tag-title {
        font-family: Proxima Nova Bold,Helvetica Neue,Helvetica,Arial,sans-serif;
        padding: 12px;
        width: 100%;
        text-align: center;
        color: #fff;
    }
    .extra_tags{
        display: none;
    }
    .col-xl-1{
        padding: 0 5px 0 5px;
    }
    .ms-sel-ctn input{
        height:24px !important;
    }
    .ms-ctn.form-control{
        border-radius: 0;
    }
    select.tags{
        display:none;
        margin: 7px 0 10px 10px;
        padding: 5px;
        border-radius: 15px;
    }
    @media (max-width: 767px) {
        .grid-weekly {
            display:none;
        }
        select.tags{
            display:block;
        }
        ul.tags{
            display:none;
        }
    }
</style>

    <div class="grid-weekly" style="margin-top: -15px;background: #fff;">
        <div class="" style="padding: 0 15px;">
            <div class="mytabs row">
            <div class="col-7"><h3 style="    text-align: left;">EXPLORE TAGS</h3></div>
            <div class="col-5" style="text-align: right;"><a class="TrendingTags-labelToggle">MORE TAGS +</a></div>
            <?php
            $idx=0;
            foreach($active_tags as $tag) {
            $idx++;
            if($idx>12)break;
            if($tag['logo']!=""){
                $background=ROOTPATH.$tag['logo'];
            }else{
                $background='https://i.imgur.com/qaYq4fG_d.jpg?maxwidth=800&amp;shape=thumb&amp;fidelity=high';
            }
                ?>
                <div class="col-sm-1 col-4">
                    <a class="Tag " href="<?=ROOTPATH?>talky/index/<?=$tag['title']?>"
                       style="background-image: url(<?=$background?>); height: 130px; width: 100%;">
                        <div class="Tag-title" style="background-color: rgb(81, 83, 90);">
                            <div class="Tag-name"><?=$tag['title']?></div>
<!--                            <div class="Tag-posts">3,939 Posts</div>-->
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>
            </div>

            <div class="extra_tags">
            <div class="row">
            <?php
            $idx=0;
            foreach($active_tags as $tag) {
                $idx++;
                if($idx>12) {
                    if($tag['logo']!=""){
                        $background=ROOTPATH.$tag['logo'];
                    }else{
                        $background='https://i.imgur.com/qaYq4fG_d.jpg?maxwidth=800&amp;shape=thumb&amp;fidelity=high';
                    }
                    ?>
                    <div class="col-sm-1 col-4">
                        <a class="Tag " href="<?=ROOTPATH?>talky/index/<?=$tag['title']?>"
                           style="background-image: url(<?=$background?>); height: 130px; width: 100%;">
                            <div class="Tag-title" style="background-color: rgb(81, 83, 90);">
                                <div class="Tag-name"><?=$tag['title']?></div>
<!--                                <div class="Tag-posts">3,939 Posts</div>-->
                            </div>
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
            </div></div>
        </div>
    </div>

<div class='header'>
    <div class='top'>

        <div class='search'>
            <!--<div class='list_home'><a href='list_home'><img src='http://img.koreatimes.com/talk/images/list_home.png' alt='list_home' /></a></div>-->
            <form action="" method="post" name="searchform" id="searchform" enctype="multipart/form-data">
                <div class='select'>
                    <select class='cat_select' name="sort" style="background: #da5a9e; border: 0; margin: 6px 0 0 15px; color: #fff;">
                        <option value="">--All--</option>
                        <?php
                        foreach($cats as $cat){
                            ?>
                            <option value="<?=$cat['id']?>"><?=$cat['name']?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <input type='text' class='input_style_search' name="keyword" maxlength='30' value='' placeholder="Search Keyword" />
                <button class='btn_search' href='#'></button>
            </form>
        </div>
        <!--//search-->

        <?php
            if($current_user>0) {
                ?>
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#properties"
                   style="float: right;margin-top: 15px;border-radius: 15px;color: #fff;border: 1px solid;position: relative;z-index: 1;">New
                    Post</a>
                <?php
            }else{
                ?>
                <a href="<?=ROOTPATH."login/"?>" class="btn btn-primary"
                   style="float: right;margin-top: 15px;border-radius: 15px;color: #fff;border: 1px solid;position: relative;z-index: 1;">New
                    Post</a>
        <?php
            }
        ?>
    </div>

</div>
<div id="grid-gallery" class="grid-gallery">

    <section class="grid-wrap">
<!--
        <select class="tags">
            <option value="">ALL</option>
            <?php
            $idx=0;
            foreach ($cats as $cat){
                $idx++;
                if($idx>7)break;
                ?>
                <option value='<?=$cat['id']?>'><?=$cat['name']?></option>
                <?php
            }
            ?>
        </select>
        -->
    <ul class="tags" style="padding-top: 10px;">
<!--        <h1 class="h4">Popular Tags</h1>-->
        <li class="active"><a data-tags='' href="<?=ROOTPATH."talky"?>">ALL</a></li>
        <?php
        $idx=0;
        foreach ($cats as $cat){
            $idx++;
            if($idx>7)break;
            ?>
            <li><a data-tags='<?=$cat['id']?>'><?=$cat['name']?></a></li>
        <?php
        }
        ?>
    </ul>
        <?php
        if(count($results)>0) {
        ?>
    <ul class="grid" id="grid">
        <?php
            foreach ($results as $res) {
                if ($res['post_video'] != "") {
                    ?>
                    <li>
                        <div class='wrap'>

                            <figure data-url='<?= ROOTPATH ?>talky/detail/<?= $res['id'] ?>'
                                    onclick="location.href='<?= ROOTPATH ?>talky/detail/<?= $res['id'] ?>'">
                                <a data-start='0'>
                                    <div class='image'>
                                        <video controls autoplay muted 
                                               poster="<?= ROOTPATH ?><?= $res['post_img'] ?>?maxwidth=520&amp;shape=thumb&amp;fidelity=high"
                                               draggable="false" preload="none" loop=""
                                               src="<?= ROOTPATH ?><?= $res['post_video'] ?>"
                                               type="video/mp4" style="width: 100%; height: auto;"></video>
                                    </div>
                                    <figcaption>
                                        <h3><?= $res['talky_title'] ?></h3>
                                        <span class='writer'><?= $res['author_data']['user_id'] ?></span>
                                    </figcaption>
                                </a>
                            </figure>
                            <div class='user'>
                                <a class='view'>15</a>
                                <a class='comment'>0</a>
                                <a class='like'>0</a>
                            </div>

                        </div>
                    </li>
                    <?php
                } else {
                    ?>
                    <li>
                        <div class='wrap'>

                            <figure data-url='<?= ROOTPATH ?>talky/detail/<?= $res['id'] ?>'
                                    onclick="location.href='<?= ROOTPATH ?>talky/detail/<?= $res['id'] ?>'">
                                <a data-start='1'>
                                    <div class='image'><img
                                                src='<?= ROOTPATH ?><?= $res['post_img'] ?>'
                                                alt='<?= $res['talky_title'] ?>'/>
                                    </div>
                                    <figcaption>
                                        <h3><?= $res['talky_title'] ?></h3>
                                        <span class='writer'><?= $res['author_data']['user_id'] ?></span>
                                    </figcaption>
                                </a>
                            </figure>
                            <div class='user'>
                                <a class='view'>16</a>
                                <a class='comment'>0</a>
                                <a class='like'>0</a>
                            </div>

                        </div>
                    </li>
                    <?php
                }
            }
        ?>
        <li class="grid-sizer"></li>
    </ul>
        <?php

        }else{
            ?>
            <div style="min-height: 50vh;">There is no result</div>
            <?php
        }
        ?>

</section>
</div>
<div class="modal fade" id="properties" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content posting">

            <div class="modal-header" style="background: #1f1f1f;">
                <h4 class="modal-title" id="modalLabelSmall" style="color: #fff;">New Post</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: #fff;">&times;</span>
                </button>
            </div>

            <div class="modal-body txtbox">

                <form action="<?=ROOTPATH?>talky/insert_talky" method="post" name="previewform" id="previewform" class="inputBox" enctype="multipart/form-data">
                    <input type="hidden" name="mode" value="set">
                    <input type="hidden" name="type" value="setcommunitytemp">
                    <input type="hidden" name="snoteid" value="-1">
                    <fieldset>
                        <ul class="info">
                            <li><label>Title</label><input type="text" name="title" maxlength="50"></li>
                            <li><label>Contents</label><textarea maxlength="1000" id="content_post" name="content"></textarea></li>
                            <li>
                                <label>Category</label>
                                <div class="category">
                                    <select name="category" style="width:83%;padding: 7px;">
                                        <option></option>
                                        <?php
                                        foreach($cats as $cat){
                                            ?>
                                            <option value="<?=$cat['id']?>"><?=$cat['name']?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <label>Tags</label>
                                <div class="hashtag" style="float: right;width:83%;">
                                    <div style="margin-top: -10px;"><div id="ms1" class="form-control"></div></div>
                                </div>
                            </li>
                            <li><label>Picture</label>
                                <input type="file" id="talky_photo" class="talky_photo" name="talky_photo">
                            </li>
                            <li><label>Video</label>
                                <input type="file" id="talky_video" class="talky_video" name="talky_video">
                            </li>
                        </ul>
                        <!--<div class='submit_preview' >PREVIEW</div>-->
                        <input type="submit" class="submit_preview" value="SUBMIT">
                    </fieldset>
                </form>
            </div>

        </div>
    </div>
</div>
<div id="tags_name" style="display: none;"><?php echo json_encode($tags_name); ?></div>
<div class="container">

