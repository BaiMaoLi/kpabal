<script type='text/javascript' src='<?=ROOTPATH?>../<?=((strpos(ROOTPATH, 'withyou')!==false)?"":"CI_MANG/")?>wordpress/wp-content/plugins/mangboard/skins/bbs_basic/js/common.js?ver=1.7.1'></script>
<script type='text/javascript' src='<?=ROOTPATH?>../<?=((strpos(ROOTPATH, 'withyou')!==false)?"":"CI_MANG/")?>wordpress/wp-content/plugins/mangboard/plugins/editors/smart/js/service/HuskyEZCreator.js?ver=4.9.8'></script>
<script type="text/javascript">
    var mb_urls = [];
    mb_urls["ajax_url"] = "<?=ROOTPATH?>../<?=((strpos(ROOTPATH, 'withyou')!==false)?"":"CI_MANG/")?>wordpress/wp-admin/admin-ajax.php";
</script>
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
    .editor_container iframe {
        width: 101% !important;
    }
</style>
<div class="contents_area_wrap0">
    <form method="post" id="frm_content">
    <div class="gpe_contents_box">
        <div class="row content_container">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" style="height: 30px;">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>profile">My Profile</a></li>
                    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>favorites/mall">My Shopping Mall</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php if($product):?>Edit<?php else:?>New<?php endif?> Product</li>
                  </ol>
                </nav>
            </div>
            <div class="col-sm-6 mb-3">
              <div style="color: #c71c77; font-weight: bold;">Product Main Info</div>
              <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="product_title">Product Title</label>
                    <input type="text" class="form-control" id="product_title" name="product_title" placeholder="Product Title" value="<?php if($product) echo $product->product_title;?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="categoryIdx">Shopping Mall</label>
                    <select class="form-control" id="mallIdx" name="mallIdx">
                        <?php foreach($malles as $mall){?>
                        <option value="<?=$mall->mallIdx?>"<?php if(($product) && ($product->mallIdx == $mall->mallIdx)):?> selected<?php endif?>><?=$mall->mall_title?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="product_price">Product Price</label>
                    <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Product Price" value="<?php if($product) echo $product->product_price;?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="product_price_old">Old Price</label>
                    <input type="text" class="form-control" id="product_price_old" name="product_price_old" placeholder="Old Price" value="<?php if($product) echo $product->product_price_old;?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="store_count">Store Count</label>
                    <input type="text" class="form-control" id="store_count" name="store_count" placeholder="Store Count" value="<?php if($product) echo $product->store_count;?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="freeShipping">FreeShipping</label>
                    <select class="form-control" id="freeShipping" name="freeShipping">
                        <option value="on"<?php if(($product) && ($product->freeShipping)):?> selected<?php endif?>>Yes</option>
                        <option value="off"<?php if(!(($product) && ($product->freeShipping))):?> selected<?php endif?>>NO</option>
                    </select>
                </div>
              </div>
            </div>
            <div class="col-sm-6 mb-3" style="position: relative;">
                <img src="<?=ROOTPATH?>api/image/mall_product/<?php if($product) echo $product->productIdx; else echo "new";?>/640/400" class="rounded" style="width: 100%;" id="product_avatar">
                <button type="button" class="btn btn-danger" style="position: absolute; right: 20px; top: 0; font-size: 12px;" onclick="javascript: attach_record();"><i class="far fa-image"></i> Upload Image</button>
            </div>
            <div class="col-sm-12 mb-3">
              <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="product_short_desc">Product Short Description</label>
                    <textarea class="form-control" id="product_short_desc" name="product_short_desc" rows=8 placeholder="Product Short Description"><?php if($product) echo $product->product_short_desc;?></textarea>
                </div>
                <div class="form-group col-md-12">
                    <label for="product_long_desc">Product Detailed Description</label>
                    <div class="editor_container" style="margin-right: 3px;">
                        <textarea class="form-control mb-content" id="product_long_desc" name="product_long_desc" rows=8 placeholder="Product Detailed Description"><?php if($product) echo $product->product_long_desc;?></textarea>
                    </div>
                    <script type="text/javascript">
                        if (typeof (oEditors) === "undefined") {
                            var oEditors = [];
                        };
                    </script>
                </div>
              </div>
              <button type="button" class="btn btn-outline-danger" style="font-size: 12px;" id="btn_save"><i class="far fa-save"></i> <?php if($business):?>Save<?php else:?>Register<?php endif?> Info</button>
            </div>
        </div>
    </div>
    </form>
    <input type="file" id="upload_attach" accept=".gif,.jpg,.jpeg,.png" style="display: none;">
    <?php include_once(__DIR__."/../common/sidebar.php");?>

</div><!-- #content end -->