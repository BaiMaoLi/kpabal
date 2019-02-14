<style type="text/css">
    @media (max-width: 576px) {
        .row.content_container {
            margin-left: 0px;
            margin-right: 0px;
        }
    }
    .category_title {
        font-size: 1rem;
        height: 2rem;
        line-height: 2rem;
        text-align: center;
        background: #e87c08/*#c71c77*/;
        color: white;
        font-weight: 500;
    }

    .category_items li {
        border-bottom: 1px solid #e8e8e8;
        border-left: 1px solid #e8e8e8;
        border-right: 1px solid #e8e8e8;
        height: 40px; 
        color: #777777;
        line-height: 40px;
        text-indent: 15px;
        position: relative;
        cursor: pointer;
        background-color: #f9f9f9;
        list-style: none;
    }
    .category_items li.on {
        background-color: #ffffff;
    }
    .category_items li:hover {
        background-color: #ffffff;
        color: #000000;
        font-weight: 500;
    }
    .category_items li i {
        position: absolute;
        right: 10px;
        top: 10px;
        font-size: 20px;
    }
    .category_items li.on i {
        color: #c71c77;
    }

    .content_container label {
        color: #909090;
        font-size: 12px;
        margin-bottom: 5px;
        text-transform: initial;
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
    .business_prefered {
        background-image: url(<?=ROOTPATH?><?=PROJECT_IMG_DIR?>prefered.png);
        background-position-y: 10px;
        background-repeat: no-repeat;
        background-position-x: 100%;
        background-size: 10%;
    }
    .business_record {
        float: left;
        margin-left:10px;
        width: calc(100% - 154px);
        overflow: hidden;
        font-size: 0.8rem;
        color: #666666;
    }
    .business_free {
        position: relative;
    }
    .business_record_general {
        margin-left: 10px;
        overflow: hidden;
        font-size: 0.8rem;
        color: #666666;
    }
    .business_link {
        color: #e4178b !important;
        font-size: 1.0rem;
        font-weight: 600;
        text-decoration: none;
    }
    .business_record_general .business_link {
        color: #666666 !important;
    }
    .business_link:hover {
        text-decoration: underline !important;
    }
    .rating_link {
        position: absolute;
        bottom: 10px;
        right: 8px;
        background-color: #e2dede75;
        padding: 4px 10px;
        border-radius: 15px;
        border: solid 1px #8080801c;
        font-size: 11px;
    }

</style>

<div class="contents_area_wrap0">    
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
        <div style="height: 10px;"></div>
        <div class="row content_container">
            <div class="col-sm-3 d-sm-block d-none">
                <div class="category_title">Category</div>
                <input type="text" placeholder="Category search" autocomplete="off" id="category_search" class="form-control" style="font-size: 0.9rem;">
                <ul class="category_items">
                <?php foreach($business_categories as $category){?>
                    <li value="<?=$category->categoryIdx?>"> <?=$category->categoryName?> <i class="fas fa-angle-right"></i></li>
                <?php }?>
                </ul>            
            </div>
            <div class="col-sm-9">
              <div class="category_title" style="text-align: left; text-indent: 10px;">Current Location: <span id="cur_states">All States</span></div>
              <div style="height: 10px;"></div>
              <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="stateIdx">States</label>
                    <select class="form-control" id="stateIdx">
                        <option value="">All States</option>
                        <?php foreach($states as $state){?>
                        <option value="<?=$state->stateIdx?>" short_name="<?=$state->stateCode?>"><?=$state->stateName?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="form-group col-md-8" style="margin-bottom: 0;"></div>
                <div class="form-group col-md-4">
                    <label for="categoryIdx">Category</label>
                    <select class="form-control" id="categoryIdx">
                        <option value="">All Categories</option>
                        <?php foreach($business_categories as $category){?>
                        <option value="<?=$category->categoryIdx?>"><?=$category->categoryName?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="search_keyword">Keyword for searching</label>
                  <input type="text" class="form-control" id="search_keyword" placeholder="Please search for keyword or Store Name.">
                </div>
                <div class="form-group col-md-2">
                    <label>&nbsp;</label>
                    <button id="search_button" class="btn btn-primary form-control">Search</button>
                </div>
              </div>
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#" role="tab" aria-selected="true">Random</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="rating-tab" data-toggle="tab" href="#" role="tab" aria-selected="false">Rating</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="review-tab" data-toggle="tab" href="#" role="tab" aria-selected="false">Review</a>
                  </li>
                </ul>
                <div class="tab-content" id="business_list">
                  <div class="tab-pane fade show active" role="tabpanel" id="content_table">
                  </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once(__DIR__."/../common/sidebar.php");?>

</div><!-- #content end -->