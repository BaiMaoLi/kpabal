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
                    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>favorites/business">My Business</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php if($business):?>Edit<?php else:?>New<?php endif?> Business</li>
                  </ol>
                </nav>
            </div>
            <div class="col-sm-6 mb-3">
              <div style="color: #c71c77; font-weight: bold;">Business Main Info</div>
              <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="business_name_ko">Business Name</label>
                    <input type="text" class="form-control" id="business_name_ko" name="business_name_ko" placeholder="Business Name" value="<?php if($business) echo $business->business_name_ko;?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="categoryIdx">Category</label>
                    <select class="form-control" id="categoryIdx" name="categoryIdx">
                        <?php foreach($business_categories as $category){?>
                        <option value="<?=$category->categoryIdx?>"<?php if(($business) && ($category->categoryIdx == $business->categoryIdx)):?> selected<?php endif?>><?=$category->categoryName?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label for="business_keyword">Keywords</label>
                    <input type="text" class="form-control" id="business_keyword" name="business_keyword" placeholder="Keywords" value="<?php if($business) echo $business->business_keyword;?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="phone1">Phone Number</label>
                    <input type="text" class="form-control" id="phone1" name="phone1" placeholder="Phone Number" value="<?php if($business) echo $business->phone1;?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="phone2">Mobile Number</label>
                    <input type="text" class="form-control" id="phone2" name="phone2" placeholder="Mobile Number" value="<?php if($business) echo $business->phone2;?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="fax">Fax Number</label>
                    <input type="text" class="form-control" id="fax" name="fax" placeholder="Fax Number" value="<?php if($business) echo $business->fax;?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="work_time">Work Time</label>
                    <input type="text" class="form-control" id="work_time" name="work_time" placeholder="Work Time" value="<?php if($business) echo $business->work_time;?>" required>
                </div>
              </div>
            </div>
            <div class="col-sm-6 mb-3" style="position: relative;">
                <img src="<?=ROOTPATH?>api/image/business/<?php if($business) echo $business->id; else echo "new";?>/552/400" class="rounded" style="width: 100%;" id="business_avatar">
                <button type="button" class="btn btn-danger" style="position: absolute; right: 20px; top: 0; font-size: 12px;" onclick="javascript: attach_record();"><i class="far fa-image"></i> Upload Image</button>
            </div>
            <div class="col-sm-12 mb-3">
              <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="website">Web Site URL</label>
                    <input type="text" class="form-control" id="website" name="website" placeholder="Web Site URL" value="<?php if($business) echo $business->website;?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="email">Email Address</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="<?php if($business) echo $business->email;?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="latitude">Latitude</label>
                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude" value="<?php if($business) echo $business->latitude;?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="longitude">Longitude</label>
                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude" value="<?php if($business) echo $business->longitude;?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php if($business) echo $business->address;?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php if($business) echo $business->city;?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="stateIdx">State</label>                    
                    <select class="form-control" id="stateIdx" name="stateIdx">
                        <?php foreach($states as $state){?>
                        <option value="<?=$state->stateIdx?>"<?php if(($business) && ($state->stateIdx == $business->stateIdx)):?> selected<?php endif?>><?=$state->stateName?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="zip">Zip Code</label>
                    <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip Code" value="<?php if($business) echo $business->zip;?>">
                </div>
              </div>
            </div>
            <div class="col-sm-12 mb-3">
              <div style="color: #c71c77; font-weight: bold;">Business Detail Info</div>
              <div class="form-row">
                <?php if(($business) && ($business->options)):?>
                <?php foreach ($business->options as $option){?>
                <div class="form-group col-md-3">
                    <label for="option_<?=$option->id?>"><?=$option->option_code?></label>
                    <input type="text" class="form-control" id="option_<?=$option->id?>" name="option_<?=$option->id?>" placeholder="<?=$option->option_code?>" value="<?=$option->option_value?>">
                </div>
                <?php }?>
                <?php endif?>
                <div class="form-group col-md-12">
                    <label for="zip">More Information</label>
                    <textarea class="form-control" id="business_description" name="business_description" rows=8 placeholder="More Information"><?php if($business) echo $business->business_description;?></textarea>
                </div>
              </div>
              <button type="submit" class="btn btn-outline-danger" style="font-size: 12px;" id="btn_save"><i class="far fa-save"></i> <?php if($business):?>Save<?php else:?>Register<?php endif?> Info</button>
            </div>
        </div>
    </div>
    </form>
    <input type="file" id="upload_attach" accept=".gif,.jpg,.jpeg,.png" style="display: none;">
    <?php include_once(__DIR__."/../common/sidebar.php");?>

</div><!-- #content end -->