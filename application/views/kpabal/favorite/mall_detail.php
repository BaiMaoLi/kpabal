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
    .form-group label {
        margin-top: 0;
        margin-bottom: 0;
        font-size: 12px;
    }
</style>
<div class="contents_area_wrap0">
    <form method="post">
    <div class="gpe_contents_box">
        <div class="row content_container">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" style="height: 30px;">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>profile">My Profile</a></li>
                    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>favorites/mall">My Shopping Mall</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php if($mall):?>Edit<?php else:?>New<?php endif?> Shopping Mall</li>
                  </ol>
                </nav>
            </div>
            <div class="col-sm-6 mb-3">
              <div style="color: #c71c77; font-weight: bold;">Shopping Mall Main Info</div>
              <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="mall_title">Mall Name</label>
                    <input type="text" class="form-control" id="mall_title" name="mall_title" placeholder="Mall Name" value="<?php if($mall) echo $mall->mall_title?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="categoryIdx">Category</label>
                    <select class="form-control" id="categoryIdx" name="categoryIdx">
                        <?php foreach($mall_categories as $category){?>
                        <option value="<?=$category->categoryIdx?>"<?php if(($mall) && ($category->categoryIdx == $mall_categories->categoryIdx)):?> selected<?php endif?>><?=$category->categoryName?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label for="mall_address">Shopping Mall Address</label>
                    <input type="text" class="form-control" id="mall_address" name="mall_address" placeholder="Mall Address" value="<?php if($mall) echo $mall->mall_address;?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="mall_site_url">Shopping Mall Site URL</label>
                    <input type="text" class="form-control" id="mall_site_url" name="mall_site_url" placeholder="Site URL" value="<?php if($mall) echo $mall->mall_site_url;?>" required>
                </div>
              </div>
            </div>
            <div class="col-sm-6 mb-3" style="position: relative;">
                <img src="<?=ROOTPATH?>api/image/mall/<?php if($mall) echo $mall->mallIdx; else echo "new";?>/420/150" class="rounded" style="width: 100%;" id="mall_avatar">
                <button type="button" class="btn btn-danger" style="position: absolute; right: 20px; top: 0; font-size: 12px;" onclick="javascript: attach_record();"><i class="far fa-image"></i> Upload Image</button>
            </div>
            <div class="col-sm-12 mb-3">
              <button type="submit" class="btn btn-outline-danger" style="font-size: 12px;" id="btn_save"><i class="far fa-save"></i> <?php if($mall):?>Save<?php else:?>Register<?php endif?> Info</button>
            </div>
        </div>
    </div>
    </form>
    <input type="file" id="upload_attach" accept=".gif,.jpg,.jpeg,.png" style="display: none;">
    <?php include_once(__DIR__."/../common/sidebar.php");?>

</div><!-- #content end -->