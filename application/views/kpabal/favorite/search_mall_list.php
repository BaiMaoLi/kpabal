
<?php if($where == "home-tab"):?>
<?php foreach($result as $mall){?>
<div class="shadow-sm p-3 mb-1 bg-white rounded business_prefered">
    <img src="<?=ROOTPATH?>api/image/mall/<?=$mall->mallIdx?>/84/30" width="84" height="30" class="rounded" style="float: left;">
    <div class="business_record">
        <a href="<?=ROOTPATH?>shopping/mall/<?=$mall->mallIdx?>" class="business_link"><?=$mall->mall_title?></a><br>
        <span><?=$mall->mall_address?></span><br>
        <?php if($mall->mall_site_url):?><span><?=$mall->mall_site_url?></span><br><?php endif?>
        <span><?=$mall->categoryName?></span>
    </div>
    <div class="action_button">
        <a class="btn btn-outline-success" style="font-size: 12px; line-height: 12px; padding: 6px 5px 6px 7px;" href="<?=ROOTPATH?>favorites/mall/<?=$mall->mallIdx?>" title="Edit Info"><i class="fas fa-edit"></i></a>
    </div>
    <div class="clearfix"></div>
</div>
<?php }?>
<div class="p-3 mb-1 bg-white">
    <a class="btn btn-outline-success" style="font-size: 12px;" href="<?=ROOTPATH?>favorites/mall/new" title="Add new business"><i class="fas fa-plus"></i> Add New Shopping Mall</a>
</div>
<?php elseif($where == "product-tab"):?>
<?php foreach($result as $product){?>
<div class="shadow-sm p-3 mb-1 bg-white rounded business_prefered">
    <img src="<?=ROOTPATH?>api/image/mall_product/<?=$product->productIdx?>/160/100" width="160" height="100" class="rounded" style="float: left;">
    <div class="business_record" style="width: calc(100% - 185px);">
        <a href="<?=ROOTPATH?>shopping/product/<?=$product->productIdx?>" class="business_link"><font color="mediumblue"><?=$product->mall_title?></font> - <?=$product->product_title?></a><br>
        <span><font color=red>$ <?=$product->product_price?></font></span><?php if($product->product_price_old > 0):?><span style="color: grey;     text-decoration: line-through; padding-left: 10px;">$ <?=$product->product_price_old?></span><?php endif?><br>
        <div style="max-height: 40px; overflow: hidden;">
            <?=$product->product_short_desc?>
        </div>
        <?php if($product->freeShipping):?><span style="color: red;">Free Shipping</span><?php endif?>
    </div>
    <div class="action_button">
        <a class="btn btn-outline-success" style="font-size: 12px; line-height: 12px; padding: 6px 5px 6px 7px;" href="<?=ROOTPATH?>favorites/mall_product/<?=$product->productIdx?>" title="Edit Product Info"><i class="fas fa-edit"></i></a>
    </div>
    <div class="clearfix"></div>
</div>
<?php }?>
<div class="p-3 mb-1 bg-white">
    <a class="btn btn-outline-success" style="font-size: 12px;" href="<?=ROOTPATH?>favorites/mall_product/new" title="Add new business"><i class="fas fa-plus"></i> Add New Product</a>
</div>
<?php elseif($where == "order-tab"):?>
<?php foreach($result as $order){?>
<div class="shadow-sm p-3 mb-1 bg-white rounded business_prefered">
    <img src="<?=ROOTPATH?>api/image/mall/<?=$order->mallIdx?>/84/30" width="84" height="30" class="rounded" style="float: left;">
    <div class="business_record" style="width: calc(100% - 185px);">
        <font color="mediumblue"><?=$order->mall_title?></font> - <?=$order->orderIdx?>, <font color="mediumseagreen"><?=$order->user_full_name?></font> -- <font color="red"><?=$order->statusName?></font><br>
        <span style="padding-right: 40px;"><i class="fas fa-map-marker-alt business_home_info" style="width: 20px;"></i> <?=$order->shippingAddress?></span>
        <span style="padding-right: 40px;"><i class="far fa-envelope business_home_info" style="width: 20px;"></i> <?=$order->emailAddress?></span>
        <span style="padding-right: 40px;"><i class="fas fa-phone-square business_home_info" style="width: 20px;"></i> <?=$order->phoneNumber?></span><br>
        <span style="padding-right: 40px;"><i class="far fa-clock business_home_info" style="width: 20px;"></i> <?=date("Y-m-d H:i:s", strtotime($order->orderDate))?></span>
        <span style="color:red;">$ <?=$order->totalAmount?></span><br>
        <table class="order_detail_info" style="display: none; margin-bottom: 0px; margin-top:10px;">
            <?php foreach($order->order_detail as $order_detail){?>
            <tr style="height: 20px; line-height: 20px;">
                <td><?=$order_detail->product_title?></td>
                <td width=30></td>
                <td><font color="red">$ <?=$order_detail->productOrderPrice?></font> X <?=$order_detail->productAmount?></td>
            </tr>
            <?php }?>
        </table>
    </div>
    <div class="action_button">
        <a href="#" class="btn btn-outline-success btn_toggle_detail" style="font-size: 12px; line-height: 12px; padding: 6px 5px 6px 7px;" title="Order Detail"><i class="fas fa-edit"></i></a>
    </div>
    <div class="clearfix"></div>
</div>
<?php }?>
<script language="javascript">
    $(".btn_toggle_detail").click(function(){
        $(this).parent().parent().find(".order_detail_info").toggle();
    });
</script>
<?php elseif($where == "payment-tab"):?>
<?php foreach($result as $payment){?>
<div class="shadow-sm p-3 mb-1 bg-white rounded business_prefered">
    <img src="<?=ROOTPATH?>api/image/mall/<?=$payment->mallIdx?>/84/30" width="84" height="30" class="rounded" style="float: left;">
    <div class="business_record" style="width: calc(100% - 185px);">
        <font color="mediumblue"><?=$payment->mall_title?></font> - <?=$payment->orderIdx?>, <font color="mediumseagreen"><?=$payment->user_full_name?></font><br>
        <span style="padding-right: 40px;"><i class="far fa-clock business_home_info" style="width: 20px;"></i> <?=date("Y-m-d H:i:s", strtotime($payment->paymentDate))?></span>
        <?=$payment->paymentKind?>, <span style="color:red;">$ <?=$payment->paymentAmount?></span><br>
        <div style="max-height: 40px; overflow: hidden; color: grey;">
            Note: <?=$payment->paymentNote?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php }?>
<?php endif?>
<nav class="mt-3">
  <ul class="pagination justify-content-end" style="margin-bottom: 0px;">
    <li class="page-item<?php if($current_page == 0) echo ' disabled';?>">
      <a class="page-link" href="#" tabindex="-1" value="<?=$current_page - 1?>">Previous</a>
    </li>
    <?php for($i=0; $i<$total_page; $i++){
        if(abs($current_page - $i) > 2) continue;
    ?>
    <li class="page-item<?php if($current_page == $i) echo ' active disabled';?>"><a class="page-link" href="#" value="<?=$i?>"><?=$i + 1?></a></li>
    <?php }?>
    <li class="page-item<?php if($current_page == $total_page - 1) echo ' disabled';?>">
      <a class="page-link" href="#" value="<?=$current_page + 1?>">Next</a>
    </li>
  </ul>
</nav>