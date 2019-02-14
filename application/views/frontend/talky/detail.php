
<link rel="stylesheet" href="<?=ROOTPATH?>assets/css/talky.css">
<link rel="stylesheet" href="<?=ROOTPATH?>assets/css/talky_component.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="<?=ROOTPATH?>assets/css/magicsuggest.css">
<style>

    .grid li .wrap figure img {
        border-radius: 10px;
    }
    .grid li .wrap {
        outline: 0;
        border-radius: 10px;
    }
    .grid li .wrap .share,.grid li .wrap .user{
        display:none;
    }
    .detail .viewbox .txt .user_act {
        margin-top: 20px;
    }
    .detail{
        padding-bottom: 20px;
    }
    .viewbox{
        width:100%;
    }
    .ms-sel-ctn input{
        height:24px !important;
    }
    .ms-ctn.form-control{
        border-radius: 0;
    }
    #DataTables_Table_0_length, #DataTables_Table_0_filter{
        display: none;
    }
    .title_section1{
        display: none;
    }
    p.title_section1{
        width: max-content;
        height: max-content;
    }
    @media screen and (max-width: 1024px) {
        .title_section2{
            display: none;
        }
        .title_section1{
            display: block;
        }
    }
</style>
<?php
$url="https://kpabal.com/CI/";
?>
<div class="detail" style="margin-top: -15px;">
    <div class="viewbox row">

        <div class="col-sm-5">
            <h4 class="title_section1"><a title="<?=$results[0]['talky_title']?>"><?=$results[0]['talky_title']?></a></h4>
            <p class="title_section1 con_info"><span class="detail_date"><?=$results[0]['post_date']?></span><span class="detail_user"><?=$results[0]['author_data']['user_id']?></span></p>
            <p class="title_section1">&nbsp;</p>
            <div class="photoimage">
                <?php
                if($results[0]['post_video']=="") {
                    ?>
                    <a href="<?= ROOTPATH . $results[0]['post_img'] ?>" data-lightbox="ktalk"
                       data-title="<?= $results[0]['talky_title'] ?>"><img
                                src="<?= ROOTPATH . $results[0]['post_img'] ?>" style="max-height: 400px;"></a>
                    <?php
                }else {
                    ?>
                    <video controls autoplay
                           poster="<?= ROOTPATH ?><?= $results[0]['post_img'] ?>?maxwidth=520&amp;shape=thumb&amp;fidelity=high"
                           draggable="false" preload="none" loop=""
                           src="<?= ROOTPATH ?><?= $results[0]['post_video'] ?>"
                           type="video/mp4" style="width: 100%; height: auto;"></video>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="col-sm-7 txt">
            <h4 class="title_section2"><a title="<?=$results[0]['talky_title']?>"><?=$results[0]['talky_title']?></a></h4>
            <p class="title_section2 con_info"><span class="detail_date"><?=$results[0]['post_date']?></span><span class="detail_user"><?=$results[0]['author_data']['user_id']?></span></p>
            <p class="con"><?=$results[0]['talky_desc']?></p>


            <div class="user_act">
                <div class="share">
                    <a href="http://www.facebook.com/sharer.php?u=<?=$url?>talky/detail/<?=$results[0]['id']?>" target="_blank" class="send_fb"><img src="<?=$url.$results[0]['post_img']?>"></a>
                    <a href="http://twitter.com/share?text=<?=$results[0]['talky_title']?>" target="_blank" class="send_tw"><img src="<?=$url.$results[0]['post_img']?>"></a>
                    <a class="send_gg" href="https://plus.google.com/share?url=<?=$url?>talky/detail/<?=$results[0]['id']?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="<?=$url.$results[0]['post_img']?>"></a>
                    <!--<a id='send_ka' class='send_ka'><img src='http://img.koreatimes.com/promotion/spring/images/sns_ka.png'></a>-->
                </div>

                <div class="user">
                    <div class="view"><?=$results[0]['views']?></div>
                    <a class="like" name="<?=$results[0]['id']?>"><?=$results[0]['likes']?></a>
                </div>



            </div>

            <div class="review_form">
                <form method="post" name="reviewform" id="reviewform" action="<?=ROOTPATH."/talky/insert_comment"?>" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?=$id?>">
                    <fieldset>
                        <div class="set_review">
                            <div class="insert_img">
                                <input type="file" id="file_comment" name="image" style="display:none;">
<!--                                <a id="btn_file_comment" class="btn_file_comment" onclick=""></a>-->
                            </div>
                            <textarea id="comment" name="comment" maxlength="100" placeholder="Comment is limited to 100 characters." required></textarea>

                            <?php
                            if($current_user>0) {
                                ?>
                                <input type="submit" class="btn_comment" value="Comment">
                                <?php
                            }else{
                                ?>
                                <a href="<?=ROOTPATH."login/"?>"><input type="button" class="btn_comment" value="Comment"></a>
                            <?php
                            }
                            ?>
                            <div class="count_txt"><span>100</span> /100자</div>

                        </div>

                    </fieldset>
                </form>
            </div>
            <div class="table-responsive" style="margin-top: -7px; font-size: 0.8em;">
                <table class="table table1 table-striped">
                    <thead>
                    <tr>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody >
                    <?php
                    $idx=0;
                    foreach($results[0]['comments'] as $data){
                        ?>
                        <tr>
                            <td><?=$data['comment_title']?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr class="clear">
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
        <ul class="grid" id="grid">
            <?php

            foreach($results1 as $res) {
                if($res['post_video']!="") {
                    ?>
                    <li>
                        <div class='wrap'>

                            <figure data-url='<?= ROOTPATH ?>talky/detail/<?= $res['id'] ?>'
                                    onclick="location.href='<?= ROOTPATH ?>talky/detail/<?= $res['id'] ?>'">
                                <a data-start='0'>
                                    <div class='image'>
                                        <video controls autoplay
                                               poster="<?= ROOTPATH ?><?= $res['post_img'] ?>?maxwidth=520&amp;shape=thumb&amp;fidelity=high"
                                               draggable="false" preload="none" loop=""
                                               src="<?= ROOTPATH ?><?= $res['post_video'] ?>"
                                               type="video/mp4" style="width: 100%; height: auto;"></video>
                                    </div>
                                    <figcaption>
                                        <h3><?= $res['talky_title'] ?></h3>
                                        <span class='writer'><?=$res['author_data']['user_id']?></span>
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
                }else {
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
                                        <span class='writer'><?=$res['author_data']['user_id']?></span>
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
                                <div class="hashtag" style="margin-left: 118px;">
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

