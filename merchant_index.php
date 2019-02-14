<style type="text/css">
    .modal-backdrop.fade.show {
        display: block !important;
    }
    .inset_{    padding: 20px 0;  background: #FFF; box-shadow:0 2px 5px rgba(0, 0, 0, 0.10); border-radius:4px;}
    .image-sec span{ background:#EEE; padding:15px; display:inline-block;}
    .btn-hlw{ border-radius:8px; border: 2px solid #000; padding: 12px 50px 13px; box-shadow: none; font-size: 16px;}
    .btn-hlw:hover{ background:#000; color:#FFF;}
    #modal_se .modal-header { border-bottom:2px solid #e5e5e5; }
    #modal_se .image-sec img { max-height:80px; }
    #modal_se .sep_ttl, #modal_se .sep_ttl a { text-align:center; font-size:25px; }
    #modal_se .sep_ttl a{ margin:10px 0 20px; font-size:20px; display:block;}
    #modal_se .sep_ttl a:hover{ color:red;}
    #modal_se .image-sec{ margin:20px 0;}
    #modal_se .sep_ttl p { font-size:14px; }
    #modal_se .sep_highlight { background-color:#eee; border-radius:3px; padding:25px 15px; text-align:center; font-size:16px; margin:30px -15px -15px; border-top:2px dotted #bbb;  }
    #modal_se .modal-footer { border:none; padding:0 15px 15px; }
    #modal_se .site-overlay {
        background-color: rgba(0,0,0,0.4);
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: -1;
    }
    #modal_se .close{
        font-weight: 700;
        line-height: 1;
        color: #000;
        opacity: .5;
        z-index: 99;
        padding: 0 10px;
        font-size: 50px;
        position: absolute;
        right: 0;
        
    }
    #modal_se .close:focus, #modal_se .close:hover {
        color: #000;
        text-decoration: none;
        cursor: pointer;
        filter: alpha(opacity=50);
        opacity: .8;
    }
    #modal_se .modal-content{ border-radius:0; }
    #modal_se .modal-dialog{ transform: translate(0, -10%);}
    /*.modal-backdrop.in { opacity:0; }*/
    .fmtc_default_logo{background-color: #cd2122;}
    .fmtc_label{ line-height:18px; min-height:54px; color: #cc2e2e;}
    .cashback-label {
        color: #cd2122;
        font-weight: 600;
        text-align: center;
        font-family: "Open Sans", Helvetica, Arial, sans-serif;
        font-size: 16px;
        line-height: 28px;
        margin: 10px;
    }
    .merchant-left-banner, .marchant-deal-list-all {
        background: #fff;
        padding: 15px;
        border: 1px solid #CCC;
    }
    .mb-15 {
        margin-bottom: 15px !important;
    }
    .mt-0 {
        margin-top: 0px !important;
    }
    .merchant-left-banner h3 {
        color: #666666;
        font-size: 18px;
        margin-bottom: 10px;
    }
    .merchant-left-banner .recommended-store-list p {
        margin-bottom: 7px;
    }
    .recommended-store-list a {
        color: #000;
        font-size: 12px;
    }
    .recommended-store-list .cash-back-label {
        color: #f30;
    }
    .recommended-store-list a:hover, .recommended-store-list a:hover .cash-back-label{ color:#2caf50; }
    .lh-30 {
        line-height: 30px;
    }
    .mtop20 {
        margin-top: 20px;
    }
    .mbtm15 {
        margin-bottom: 15px;
    }
</style>
<!-- Blog page content -->
<section class="hg_section" style="padding-top: 20px;">
    <div class="__container">
        <div class="row">
            <div class="col-md-3 d-sm-none d-md-block">
                <div class="merchant-left-banner mb-15 text-center"> 
                    <a class="merchant--logo"> <img src="<?php echo site_url('coupon/get_safe_res'); ?>?url=<?= $merchant_info->aLogos[0]->cURL ?>"> </a>
                    <h4 class="cashback-label">
                        <?= $merchant_info->cashback ?>
                        % Cash Back</h4>
                    <a href="<?= site_url('coupon/deals/'.$merchant_info->nMerchantID) ?>" class="btn btn-success btn-sm btn-block">Shop Now</a>
                </div>
                <div class="merchant-left-banner">
                    <h3 class="mt-0">Recommended Stores</h3>
                    <div class="recommended-store-list">
                        <?php foreach ($recommended as $recommended_store) { ?>
                            <p> <a href="<?= site_url('coupon/deals/' . $recommended_store->nMerchantID) ?>">
                                    <?= $recommended_store->cName ?>
                                    <span class="cash-back-label">
                                        <?= $recommended_store->cashback ?>
                                        % Cash Back</span></a> </p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-12 col-xs-12">
                <div class="hp-hotdeals-heading blk blk-reg border blk-reg">
                    <div class="blk-reg prox-b blk-reg prox-b pad-15 pad-30-lr f-20 f-grn lh-30" style="font-size: 20px !important; color: #23ae4a; padding:15px; line-height: 30px;">
                        <?= $merchant_info->cName ?> Coupons, Promo Codes & Cash Back             
                    </div>
                </div>
                <div class="hp-hotdeals blk blk-reg border mar-10-b border-t-0" id="cat_append_div">
                    <?php
                    $dealCnt = 0;
                    $current_date = date('m/d/Y');
                    $logo = $merchant_info->aLogos[0]->cURL;

                    foreach ($merchant_info->deal_list as $fmtc_deals) {
                        if($dealCnt >= 12) break;
                        $dealCnt++;
                        if($fmtc_deals->is_deal) {
                        ?>
                        <div class="coupon-blk logo-blk blk border-b pad-15">
                            <div class="merchlogo flt col-md-2 col-sm-3 col-xs-12" style="margin-top: 10px;margin-bottom: 10px;">

                                <img class="bblk lazy special-logo" src="<?php echo site_url('coupon/get_safe_res'); ?>?url=<?= $logo ?>" id="logo_<?php echo $fmtc_deals->id; ?>" alt="<?php echo $fmtc_deals->cLabel ?>" style="width:125px; margin: 0px auto;">

                            </div>
                            <ul class="flt pad-30-l col-md-8 col-sm-6 col-xs-12" style="margin-bottom: 0;">
                                <li class="coupon-desc prox-b">
                                    <span class="title-part f-14 lh-24" id="label_<?php echo $fmtc_deals->id; ?>"><?php if(strlen($fmtc_deals->cLabel) < 90) echo $fmtc_deals->cLabel; else  echo substr($fmtc_deals->cLabel, 0, 80)."..."; ?></span>
                                    <span class="cb pad-20-r no-wrap f-14 lh-24">
                                        <?php if ($merchant_info->cashback) { ?>
                                            + <?php echo $merchant_info->cashback ?>% Cash Back
                                        <?php } ?>
                                    </span>
                                </li>
                                <li class="coupon-code mar-5-t">
                                    <?php if (isset($fmtc_deals->cCode) && ($fmtc_deals->cCode)) { ?>
                                        <span class="coupon-code flt f-14 f-gry mar-5-r pos-rel">Code: <span class="prox-b space-1 f-grn pad-20-r promo-code pointer" id="cCode_<?php echo $fmtc_deals->id; ?>" data-rel="<?php echo $fmtc_deals->cCode; ?>"><?php echo $fmtc_deals->cCode; ?></span> </span>
                                    <?php } ?>

                                    <?php
                                        $end_date = "";
                                        if (date('m/d/Y', strtotime($fmtc_deals->dtEndDate)) == $current_date) { 
                                            $end_date = "Today";
                                    ?>
                                        <span class="premium-expire flt f-14 lh-17 f-orange"> <span class="fa fa-clock-o mar-5-r flt bblk f-orange"></span> Ends <span id="date_<?php echo $fmtc_deals->id; ?>">Today</span> </span>
                                    <?php } else { ?>
                                        <span class="premium-expire flt f-14 lh-17 f-gry-dk-8"> <span class="fa fa-clock-o mar-5-r flt bblk f-gry-dk-8"></span> Expires <span id="date_<?php echo $fmtc_deals->id; ?>">
                                            <?php
                                            if (strtotime($fmtc_deals->dtEndDate) < strtotime("2000-01-01")) {
                                                echo "12/31/2050";
                                                $end_date = "12/31/2050";
                                            }
                                            else {
                                                echo date('m/d/Y', strtotime($fmtc_deals->dtEndDate));
                                                $end_date = date('m/d/Y', strtotime($fmtc_deals->dtEndDate));
                                            }
                                            ?></span>
                                        </span>
                                    <?php } ?>
                                </li>
                            </ul>
                            <div class="shopnow frt col-md-2 col-sm-3 col-xs-12" style="margin-top: 10px;">
                            <?php if($this->general->get_user_id()){
                                if (isset($fmtc_deals->cCode) && ($fmtc_deals->cCode)) { ?>
                                <a href="javascript:void(0)" style="background-color: #f30;" class="button ext frt fmtc_coupon_pop" id="url_<?php echo $fmtc_deals->id;?>" data-href="<?= site_url('coupon/load_deals/'.$merchant_info->nMerchantID).'/'.$fmtc_deals->id ?>" data-code="<?php echo $fmtc_deals->cCode ?>" data-date="<?=$end_date?>">Shop Now</a>
                            <?php } else { ?>
                                <a href="<?= site_url('coupon/load_deals/'.$merchant_info->nMerchantID).'/'.$fmtc_deals->id ?>" target="_blank" style="background-color: #f30;" class="button ext frt">Shop Now</a>
                            <?php } } else {?>
                                <a href="<?=ROOTPATH?>login" style="background-color: #f30;" class="popup-with-form button ext frt">Shop Now</a>
                            <?php } ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="coupon-blk logo-blk blk border-b pad-20">
                            <div class="merchlogo flt col-md-2 col-sm-3 col-xs-12" style="margin-bottom: 10px;">

                                <img class="bblk lazy special-logo" src="<?php echo site_url('coupon/get_safe_res'); ?>?url=<?=$fmtc_deals->image?>" style="height:50px; margin: 0px auto;">

                            </div>
                            <ul class="flt pad-30-l col-md-8 col-sm-6 col-xs-12" style="margin-bottom: 0;">
                                <li class="coupon-desc prox-b">
                                    <span class="title-part f-14 lh-24"><?php if(strlen($fmtc_deals->name) > 80) echo substr($fmtc_deals->name, 0, 80); else echo $fmtc_deals->name;?></span>
                                    <span class="cb pad-20-r no-wrap f-14 lh-24">
                                        <?php if($fmtc_deals->price != $fmtc_deals->finalprice){?><del><span >$ <?=number_format($fmtc_deals->price/100, 2)?></span></del><?php }?><span style="color:#ff3300; font-weight: bold; font-size:14px;"> $<?=number_format($fmtc_deals->finalprice/100, 2)?></span>
                                        <?php if (($merchant_info->cashback) && false) { ?>
                                            + <?php echo $merchant_info->cashback ?>% Cash Back
                                        <?php } ?>
                                    </span>
                                </li>
                                <li class="coupon-code mar-5-t" style="display: none;">
                                        <span class="coupon-code flt f-14 f-gry mar-5-r pos-rel"></span>
                                </li>
                            </ul>
                            <div class="shopnow frt col-md-2 col-sm-3 col-xs-12" style="margin-top: 10px;">
                            <?php if($this->general->get_user_id()){ ?>
                                <a href="<?= site_url('coupon/load_products/'.$merchant_info->nMerchantID).'/'.$fmtc_deals->id ?>" target="_blank" style="background-color: #f30;" class="button ext frt">Shop Now</a>
                            <?php } else {?>
                                <a href="<?=ROOTPATH?>login" style="background-color: #f30;" class="popup-with-form button ext frt">Shop Now</a>
                            <?php } ?>
                            </div>
                        </div>
                    <?php }
                    } ?>
                </div>
                <div class="text-center" id="load_more" style="display: none;">Test</div>
            </div>

        </div> 
    </div>
    <div class="clearfix" style="height: 20px;"></div>
</section>
<style>
    .recommended-store-list .overlay{
        text-align: center;
    }
</style>
<script type="text/javascript"> 
    var offset = 12;
    var page_number = 1;
    var coupon_deals_url = '<?php echo '<?=ROOTPATH?>coupon/merchant_deal_ajax/'.$merchant_info->nMerchantID; ?>';

    window.onload = function(){

        function page_link_generator(__page_count__) {
            str_html = "";
            if(__page_count__ > 1) {
                __check_hide = false;
                for(i=1; i<=__page_count__; i++) {
                    str_html += '<button class="page_link_btn btn btn-'+((i == page_number)?'success':'default')+' mtop20 mbtm15" style="padding: 3px 8px 3px 8px; margin-left: 4px; margin-right: 4px;" value="'+i+'">'+i+'</button>';
                }
            }
            $("#load_more").html( str_html );

            $(".page_link_btn").unbind("click").click(function(){
                $(".page_link_btn").removeClass("btn-success").addClass("btn-default");
                $(this).addClass("btn-success").removeClass("btn-default");
                if(page_number == $(this).attr("value")) return false;
                page_number = $(this).attr("value");
                __get_deals_ajax();
            });

            $("#load_more").show();
        }

        function __get_deals_ajax(){
            $.ajax({
                url: coupon_deals_url,
                type: "GET",
                dataType: 'html',
                data: {offset: offset * (page_number - 1)},
                success: function (data)
                {
                    $('#cat_append_div').html(data);
                    $(".gpe_mt.top").click();
                    
                    $(".fmtc_coupon_pop").click(function(){
                        $("#modal_se img").attr("src", "<?php echo site_url('coupon/get_safe_res'); ?>?url=<?= $logo ?>");
                        $("#fmtc_url_details").attr("href", $(this).attr("data-href"))
                        $("#fmtc_url").attr("href", $(this).attr("data-href"))
                        $("#fmtc_date").html($(this).attr("data-date"))
                        $("#fmtc_code").html($(this).attr("data-code"))
                        $("#modal_se").modal("show");
                    });
                }
            });
        }

        page_link_generator(<?=$total_page?>);

        $(".fmtc_coupon_pop").click(function(){
            $("#modal_se img").attr("src", "<?php echo site_url('coupon/get_safe_res'); ?>?url=<?= $logo ?>");
            $("#fmtc_url_details").attr("href", $(this).attr("data-href"))
            $("#fmtc_url").attr("href", $(this).attr("data-href"))
            $("#fmtc_date").html($(this).attr("data-date"))
            $("#fmtc_code").html($(this).attr("data-code"))
            $("#modal_se").modal("show");
        });

        $(".btn-hlw").click(function(){
            $("#modal_se").modal("hide");
        });
    }
</script>
