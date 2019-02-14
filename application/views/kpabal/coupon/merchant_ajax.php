
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