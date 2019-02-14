<style type="text/css">
	.card-body {
		padding: .5rem;
	}
	.card-title {
		margin-bottom: 0.25rem;
		font-weight: 500;
	}
	a .card-text {
		color: grey;
	}	
	a:hover .card-text {
		color: green;
	}
	.card-text {
		margin-bottom: 0.1rem;
	    height: 2.4rem;
	    overflow: hidden;
	    font-size: 12px;
	    text-align: center;
	}
	.btn {
		font-size: 12px;
		padding: 0.2rem 0.4rem;
	}
	.price {
	    margin-bottom: 5px;
	    color: #f44336
	}
	.price .price-down {
	    margin-left: 5px;
	    padding: 2px 5px;
	    color: #fff;
	    background: #f44336
	}
	.price-old {
	    position: relative;
	    display: inline-block;
	    margin-right: 7px;
	    color: #666
	}
	.price-old:before {
	    position: absolute;
	    width: 100%;
	    height: 60%;
	    content: '';
	    border-bottom: 1px solid #666
	}
	.Freeshipping {
		height: 14px;
	    line-height: 14px;
	    padding: 3px 5px;
	    border: solid 1px #2a0098;
	    border-radius: 3px;
	    color: #2a0098;
	    font-size: 11px;
	    background: #fff;
	}
	.item_desc {
	    position: absolute;
	    width: calc(60% - 5px);
	    max-height: 30px;
	    overflow: hidden;
	    font-size: 11px;
	    margin-left: 4px;
	}
</style>
<div class="row" style="margin:10px 0px !important;">
	<div class="col-md-3 d-none d-md-block">
		<?php if(count($sidebar_sliders)):?>
		<a href="<?=$sidebar_sliders[0]->content?>" target="_blank">
			<img class="w-100 d-none d-md-block" src="<?=ROOTPATH?>api/image/media/<?=$sidebar_sliders[0]->id?>/286/180" alt="<?=$sidebar_sliders[0]->title?>">		
		</a>
		<div style="height: 10px;"></div>
		<?php endif?>
		<div class="list-group">
		<?php foreach($malles as $mall){?>
		  <a href="<?=ROOTPATH?>shopping/mall/<?=$mall->mallIdx?>" class="list-group-item list-group-item-action" style="padding:0.5rem 0.5rem;" mall_id="<?=$mall->mallIdx?>">
		  	<img src="<?=ROOTPATH?>api/image/mall/<?=$mall->mallIdx?>/84/30" alt="<?=$mall->mall_title?>" style="max-height: 30px; width: 40% !important;">
		  	<span class="d-inline-block item_desc"><?=$mall->mall_title?></span>
		  </a>
		<?php }?>
		</div>
		<?php if(count($sidebar_sliders)):?>
			<?php for($i=1; $i<count($sidebar_sliders); $i++){?>
			<div style="height: 10px;"></div>
			<a href="<?=$sidebar_sliders[$i]->content?>" target="_blank">
				<img class="w-100 d-none d-md-block" src="<?=ROOTPATH?>api/image/media/<?=$sidebar_sliders[$i]->id?>/286/180" alt="<?=$sidebar_sliders[$i]->title?>">
			</a>
			<?php }?>
		<?php endif?>
	</div>
	<div class="col-md-9 col-sm-12">
		<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
		  <div class="carousel-inner">
		  	<?php foreach($home_sliders as $key => $slider){?>
		  	<div class="carousel-item<?php if($key == 0):?> active<?php endif?>">
		      <img class="d-block w-100" src="<?=ROOTPATH?>api/image/media/<?=$slider->id?>/738/369" alt="<?=$slider->title?>">
		    </div>
			<?php }?>
		  </div>
		  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
		    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
		    <span class="carousel-control-next-icon" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
		<div style="height: 10px;"></div>
		<?php foreach($malles as $mall){
			$products = $mall->products;
			if(count($products) == 0) continue;
		?>
		<nav class="navbar navbar-light bg-light" style="background-color: #007523 !important;">
		  <a class="navbar-brand" href="<?=ROOTPATH?>shopping/mall/<?=$mall->mallIdx?>" style="font-size: 16px; padding: 0px;"><?=$mall->mall_title?></a>
		</nav>
		<div style="height: 10px;"></div>
		<div class="row">
		<?php foreach($products as $product){?>
			<div class="col-md-3 col-sm-4">
				<div class="card">
				<a href="<?=ROOTPATH?>shopping/product/<?=$product->productIdx?>">
				  <img class="card-img-top" src="<?=ROOTPATH?>api/image/mall_product/<?=$product->productIdx?>/160/100" alt="<?=$product->product_title?>">
				  <div class="card-body">
				    <h5 class="card-title" style="height: 21px; overflow: hidden;"><?=$product->product_title?></h5>
				    <p class="card-text"><?=strip_tags($product->product_short_desc)?></p>
				    <div style="text-align: center;">
					<div class="price">
		                <?php if(($product->product_price_old > 0) && ($product->product_price_old != $product->product_price)):?><span class="price-old"> $ <?=$product->product_price_old?></span><?php endif?> $ <?=$product->product_price?>
		            </div>		            
		            <!--<font class="Freeshipping"<?php if(!($product->freeShipping)):?> style="visibility: hidden;"<?php endif?>>Free shipping</font>
		            <div style="height: 5px;"></div>-->
				    </div>
				  </div>
				  </a>
				</div>
				<div style="height: 10px;"></div>
			</div>
		<?php }?>
		</div>
		<?php }?>
	</div>
</div>