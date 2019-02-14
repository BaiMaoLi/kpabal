<style type="text/css">
    @media (max-width: 1024px) {
        .row.content_container {
            margin-left: 0px;
            margin-right: 0px;
        }
    }
    .breadcrumb-item a {
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
        position: relative;
    }
    .action_button {
        position: absolute;
        top: 10px;
        right: 0px;
    }
    .business_record {
        float: left;
        margin-left:10px;
        width: calc(100% - 154px);
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
    .business_link:hover {
        text-decoration: underline !important;
    }
    .rating_link {
        position: absolute;
        top: 0;
        right: 0;
        background-color: #e2dede75;
        padding: 4px 10px;
        border-radius: 15px;
        border: solid 1px #8080801c;
    }

</style>

<div class="contents_area_wrap0">    
    <div class="gpe_contents_box">
        <div class="row content_container">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" style="height: 30px;">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                  </ol>
                </nav>
            </div>
            <div class="col-sm-12">
<?php foreach($carts as $product){?>
<div class="shadow-sm p-3 mb-1 bg-white rounded business_prefered cart_product">
    <img src="<?=ROOTPATH?>api/image/mall_product/<?=$product->productIdx?>/160/100" width="160" height="100" class="rounded" style="float: left;">
    <div class="business_record" style="width: calc(100% - 185px);" productIdx="<?=$product->productIdx?>" productPrice="<?=$product->product_price?>">
        <a href="<?=ROOTPATH?>shopping/product/<?=$product->productIdx?>" class="business_link"><font color="mediumblue"><?=$product->product_title?></font></a>
    	<i class="fas fa-trash btn_remove" style="color: grey; cursor: pointer;" title="Remove from cart"></i>
    	<br>
        <span><font color=red>$ <?=$product->product_price?></font></span>
        <div style="height:5px;"></div>
        <i class="fas fa-minus-square btn_minus" style="color: grey; cursor: pointer;"></i>
        <input class="txt_amount" type="text" value="<?=$product->productAmount?>" size=3 style="text-align: center;">
        <i class="fas fa-plus-square btn_plus" style="color: grey; cursor: pointer;"></i>
    </div>
    <div class="clearfix"></div>
</div>
<?php }?>
                <h3 style="float: left;">Total Amount: $ <font color="red" id="total_amount">0</font></h3>
            	<button type="button" class="btn btn-success" style="float: right; margin-top:10px;" onclick="javascript: goto_checkout();"><i class="fa fa-shopping-cart"></i> CheckOut</button>
                <div style="clear: both; height:10px;"></div>
                <div class="checkout_page" style="display: none;">
                <form method="post">
                    <div class="form-row">
                        <div class="form-group col-md-12"> 
                            <label for="shippingAddress">Shipping Address</label>
                            <input type="text" class="form-control" id="shippingAddress" name="shippingAddress" placeholder="Shipping Address" value="" required="">
                        </div>
                        <div class="form-group col-md-6"> 
                            <label for="emailAddress">Email Address</label>
                            <input type="text" class="form-control" id="emailAddress" name="emailAddress" placeholder="Email Address" value="" required="">
                        </div>
                        <div class="form-group col-md-6"> 
                            <label for="phoneNumber">Phone Number</label>
                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone Number" value="" required="">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" style="float: right; margin-top:10px;"><i class="fa fa-shopping-cart"></i> Place Order</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <?php include_once(__DIR__."/../common/sidebar.php");?>

</div><!-- #content end -->