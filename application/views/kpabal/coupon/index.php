<style type="text/css">
    .text-center {
        text-align: center;
    }
    .widget_product_categories .cat-item a {
        cursor: pointer;
    }
    .widget_product_categories .cat-item a:hover{
        color: #66bb66;
        font-weight: bold;
    }
    .widget_product_categories .cat-item a.selected{
        font-weight: bold;
    }
    .store_selector span{
        text-indent: 0px;
        color: #66bb66;
        font-size: 14px;
        display: inline-block;
        min-width: 18px;
        cursor: pointer;
    }
    .store_selector span.selected {
        color: black;
    }
    .store_selector span.sel_char:hover {
        text-decoration: underline;
    }
    h3, h4 {
        font-family: "Open Sans", Helvetica, Arial, sans-serif;
        font-size: 18px;
        line-height: 28px;
        font-weight: 400;
        font-style: normal;
        color: #444;
    }
    .widget .widgettitle {
        color: #050505;
        line-height: 1.4;
        padding: 9px 0 15px 10px;
        position: relative;
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    .widget .widgettitle:after {
        width: 50px;
        border-bottom: 1px solid #cd2122;
    }
    .widget .widgettitle:after, .sidebar .widget .widgettitle:before {
        position: absolute;
        bottom: 2px;
        height: 0;
        left: 0;
        content: '';
    }
    .widget_product_categories .cat-item {
        margin: 10px 0;
    }
    .widget_product_categories .cat-item a:before {
        content: '';
        display: inline-block;
        margin-right: 12px;
        width: 8px;
        height: 2px;
        background: #E1E1E1;
        vertical-align: middle;
        -webkit-transition: all .15s ease-out;
        transition: all .15s ease-out;
    }
    .sep_ttl div {
        font-weight: bold;
        font-size: 15px;
        color: #d51b19;
        padding-top: 5px;
    }

    .exe_cashback {
        color: #ff3300 !important;
        font-family: proxima_nova_ltsemibold,Arial,Helvetica,sans-serif!important;
        font-weight: 400;
        font-style: normal;
        line-height: 40px;
        font-size: 16px;
        padding-top: 5px;
        text-align: center;
        height: 45px;
        overflow: hidden;
    }
</style>
<div class="row" style="margin:20px 0px !important;">
    <?php foreach($recommended as $fmtc_deals) {?>
    <div class="col-md-2 col-sm-4 shadow-sm" style="text-align: center; padding: 20px 10px 20px 10px; border:solid 1px #0000001f;">
        <?php
          $merchant_logo = json_decode($fmtc_deals->aLogos);
          foreach ($merchant_logo as $unique_key) {
            if($unique_key->cSize=="120x60"){ ?>
         <a href="<?php echo site_url('coupon/deals/'.$fmtc_deals->nMerchantID);?>" style="display: block;"><img class="img" src="<?php echo site_url('coupon/get_safe_res'); ?>?url=<?php echo $unique_key->cURL; ?>" id="logo_<?php echo $fmtc_deals->id;?>" alt="<?php echo $fmtc_deals->cName ?>" style="height: 35px;"></a>
        <?php } } ?>    
      <div class="sep_ttl">
        <div id="label_<?php echo $fmtc_deals->id;?>" style="height: 35px; line-height: 35px; font-size: 16px; overflow: hidden;"><?php echo $fmtc_deals->cName ?></div>
        <div class="exe_cashback" style="height: 35px; line-height:35px; font-size: 13px; overflow: hidden;"><?php if(isset($fmtc_deals->cashback)){?><?php if($fmtc_deals->cashback > 0){?>+ <?=$fmtc_deals->cashback?>% Cash Back<?php }?><?php }?></div>
      </div>
      <a href="<?php echo site_url('coupon/deals/'.$fmtc_deals->nMerchantID);?>" class="dtl_lnk" style="max-height: 20px; font-size:10px; color: #66bb66;">See All Coupons & Deals</a>
  </div>
    <?php }?>
</div>
<div class="row">
    <div class="col-md-3">
        <div id="sidebar-widget" style="border-top: 2px solid #23ae4a;">
            <!-- Product categories widget -->
            <div class="widget" style="padding: 5px;">
                <!-- Title -->
                <h3 class="widgettitle title">REFINE STORES</h3>
                <!-- Product category list -->
                <ul class="widget_product_categories product-categories" style="height: 760px;overflow-y: scroll;">
                    <li class="cat-item"><a class="dtl_lnk selected" value="exe-all-stores">All Stores</a></li>
                    <?php foreach ($categories as $category) { ?>                                            
                    <li class="cat-item"><a class="dtl_lnk" value="<?php echo $category->cSlug; ?>"><?php echo $category->cName; ?></a></li>
                    <?php } ?>
                </ul>
                <!--/ Product category list -->
            </div>
            <!--/ Product categories widget -->
        </div>
    </div>
    <div class="col-md-9">
        <div class="row" style="border-top: 2px solid #23ae4a; background-color: white; padding: 10px 0 10px 20px;">
            <h4 class="widgettitle title">ALL STORES</h4>
        </div>
        <div class="row store_selector" style="border-top: solid 1px #cccccc; background-color: white; padding-left: 20px; line-height: 36px;">
            <span style="width:60px;" value="ALL" class="selected sel_char">ALL</span>
            <?php foreach (range('A', 'Z') as $char) {
                $check_data = $characters[$char];
             ?>
            <span value="<?=$char?> "<?php if($check_data == 0) echo ' style="color: #BBBBBB;"'; else echo ' class="sel_char"';?>><?=$char?></span>
            <?php }
                $check_data = $characters["999"];
            ?>
            <span value="999"<?php if($check_data == 0) echo ' style="color: #BBBBBB;"'; else echo ' class="sel_char"';?>>0 - 9</span>
        </div>
        <div class="row deal_container" id="cat_append_div" style="margin-right: 0px !important;"></div>
        <div class="row">
            <div class="clearfix clear" style="height: 20px;"></div>
            <div class="text-center" id="load_more" style="width:100%; display: none;"></div>
            <div class="clearfix clear" style="height: 20px;"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var offset = 12;
    var page_number = 1;

    window.onload = function(){

        function page_link_generator(__page_count__) {
            str_html = "";
            if(__page_count__ > 1) {
                __check_hide = false;
                for(i=1; i<=__page_count__; i++) {
                    if((i != 1) && (i != __page_count__) && (Math.abs(i - page_number) > 2)) {
                        __check_hide = true;
                        continue;
                    }
                    if(__check_hide) {
                        str_html += " ... ";
                        __check_hide = false;
                    }
                    str_html += '<button class="page_link_btn btn btn-'+((i == page_number)?'success':'default')+' mtop20 mbtm15" style="padding: 3px 8px 3px 8px; margin-left: 4px; margin-right: 4px; font-size:14px;" value="'+i+'">'+i+'</button>';
                }
            }
            $("#load_more").html( str_html );

            $(".page_link_btn").unbind("click").click(function(){
                if(page_number == $(this).attr("value")) return false;
                page_number = $(this).attr("value");
                __get_deals_ajax();
            });

            $("#load_more").show();
        }

        function __get_deals_ajax(){
            $("#load_more").hide();
            
            var store_select = $(".store_selector span.selected").attr("value");
            var category_select = $(".dtl_lnk.selected").attr("value");

            $.post("<?php echo ROOTPATH.'coupon/merchants_ajax'; ?>", {"store_select": store_select, "category_select": category_select, "page_number": page_number, "offset": offset}, function(data){
                ret = jQuery.parseJSON(data);
                $(".deal_container").html(ret.deals);
                page_link_generator(ret.isMore);
            });
        }

        $(".store_selector span.sel_char").click(function(){
            $(".store_selector span").removeClass("selected");
            $(this).addClass("selected");
            page_number = 1;
            $(".deal_container").html("");
            __get_deals_ajax();
        });

        $(".cat-item .dtl_lnk").click(function(){
            $(".dtl_lnk").removeClass("selected");
            $(this).addClass("selected");
            page_number = 1;
            $(".deal_container").html("");
            __get_deals_ajax();
        });

        __get_deals_ajax();
    }
</script>
