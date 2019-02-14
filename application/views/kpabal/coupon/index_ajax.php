<?php if($latest_deals){
    foreach($latest_deals as $fmtc_deals) { ?>
  <div class="col-md-4 col-sm-6 shadow-sm" style="text-align: center; padding: 20px;">
    <?php
      $merchant_logo = json_decode($fmtc_deals->aLogos);
      foreach ($merchant_logo as $unique_key) {
        if($unique_key->cSize=="120x60"){ ?>
     <a href="<?php echo site_url('coupon/deals/'.$fmtc_deals->nMerchantID);?>" style="display: block;"><img class="img" src="<?php echo site_url('coupon/get_safe_res'); ?>?url=<?php echo $unique_key->cURL; ?>" id="logo_<?php echo $fmtc_deals->id;?>" alt="<?php echo $fmtc_deals->cName ?>" style="height: 45px;"></a>
    <?php } } ?>

      <div class="sep_ttl">
        <div id="label_<?php echo $fmtc_deals->id;?>" style="max-height: 22px; overflow: hidden;"><?php echo $fmtc_deals->cName ?></div>
        
        <div class="exe_cashback" style="height: 45px; overflow: hidden;"><?php if(isset($fmtc_deals->cashback)){?><?php if($fmtc_deals->cashback > 0){?>+ <?=$fmtc_deals->cashback?>% Cash Back<?php }?><?php }?></div>
        
      </div>
      <a href="<?php echo site_url('coupon/deals/'.$fmtc_deals->nMerchantID);?>" class="dtl_lnk" style="max-height: 20px; font-size:12px; color: #66bb66;">See All Coupons & Deals</a>
  </div>
<?php } }?>