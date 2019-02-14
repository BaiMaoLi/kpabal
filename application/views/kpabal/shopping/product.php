<style type="text/css">
.nav-tabs>li {
    float: left;
    margin-bottom: -1px;
}

.nav>li {
    position: relative;
    display: block;
}
.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
    color: #555;
    cursor: default;
    background-color: #fff;
    border: 1px solid #ddd;
    border-bottom-color: transparent;
}

ul a {
    color: #337ab7;
    text-decoration: none !important;
}
.nav-tabs>li>a {
    margin-right: 2px;
    line-height: 1.42857143;
    border: 1px solid transparent;
    border-radius: 4px 4px 0 0;
}
.nav>li>a {
    position: relative;
    display: block;
    padding: 10px 15px;
}
.tab-content p {
	font-size:12px;
	line-height: 20px;
	margin-bottom: 10px;
}
.tab-content img {
	padding: 10px;
}
.item_desc {
	position: absolute;
    width: calc(50% - 5px);
    max-height: 60px;
    overflow: hidden;
    font-size: 11px;
    margin-left: 4px;
}
</style>
<div class="row" style="margin:10px 0px !important;">
	<div class="col-md-9 col-sm-12">
		<nav aria-label="breadcrumb" style="position: relative;">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>shopping">Shopping Mall</a></li>
		    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>shopping/category/<?=$product->category->categoryIdx?>"><?=$product->category->categoryName?></a></li>
		    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>shopping/mall/<?=$product->mallIdx?>"><?=$product->category->mall_title?></a></li>
		  </ol>
		</nav>
		<div style="height: 10px;"></div>
		<h2><?=$product->product_title?></h2>
		<h5 class="mb-1"><?=$product->product_short_desc?></h5>
		<img class="d-block w-100" src="<?=ROOTPATH?>api/image/mall_product/<?=$product->productIdx?>/800/400" alt="<?=$product->product_title?>">
		<div style="height: 10px;"></div>
		<h4>
			Price: <font color=red>$ <?=$product->product_price?></font>
			<button type="button" class="btn btn-success" style="float:right;" onclick="javascript: add_cart(<?=$product->productIdx?>);"><i class="fa fa-shopping-cart"></i> Add To Cart</button>
		</h4>
		<div style="height: 10px;"></div>
		<ul class="nav nav-tabs">
			<li class="active" id="tab_01" onclick="this.className='active';tab_02.className='';">
				<a href="#1" data-toggle="tab">Overview</a>
			</li>
			<li id="tab_02" onclick="this.className='active';tab_01.className='';" style="display: none;">
				<a href="#2" data-toggle="tab">More Detail</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="1">
				<br>
				<?=$product->product_long_desc?>
			</div>
			<div class="tab-pane" id="2" style="display: none;">
				<br>
			</div>
		</div>
		<br>
	</div>
	<div class="col-md-3 d-none d-md-block">
		<?php if(count($sidebar_sliders)):?>
		<a href="<?=$sidebar_sliders[0]->content?>" target="_blank">
			<img class="w-100 d-none d-md-block" src="<?=ROOTPATH?>api/image/media/<?=$sidebar_sliders[0]->id?>/286/180" alt="<?=$sidebar_sliders[0]->title?>">
		</a>
		<div style="height: 10px;"></div>
		<?php endif?>
		<?php if(count($recommended_product)):?>
		<div style="height: 10px;"></div>
		<div class="list-group">
		<h5 class="mb-1">Recommended Products</h5>
		<?php foreach($recommended_product as $product){?>
		  <a href="<?=ROOTPATH?>shopping/product/<?=$product->productIdx?>" class="list-group-item list-group-item-action" style="padding:0.5rem 0.5rem;">
		  	<img class="w-50 d-inline-block" src="<?=ROOTPATH?>api/image/mall_product/<?=$product->productIdx?>/286/180" alt="<?=$product->product_title?>">
		  	<span class="d-inline-block item_desc"><?=$product->product_title?></span>
		  </a>
		<?php }?>
		</div>
		<?php endif?>
		<?php if(count($sidebar_sliders)):?>
		<?php for($i=1; $i<count($sidebar_sliders) - 1; $i++){?>
		<div style="height: 10px;"></div>
		<a href="<?=$sidebar_sliders[$i]->content?>" target="_blank">
			<img class="w-100 d-none d-md-block" src="<?=ROOTPATH?>api/image/media/<?=$sidebar_sliders[$i]->id?>/286/180" alt="<?=$sidebar_sliders[$i]->title?>">
		</a>
		<?php }?>
		<?php endif?>
		<div style="height: 10px;"></div>
		<div class="list-group">
		<?php if(count($recent_product)):?>
		<h5 class="mb-1">Recent Products</h5>
		<?php foreach($recent_product as $product){?>
		  <a href="<?=ROOTPATH?>shopping/product/<?=$product->productIdx?>" class="list-group-item list-group-item-action" style="padding:0.5rem 0.5rem;">
		  	<img class="w-50 d-inline-block" src="<?=ROOTPATH?>api/image/mall_product/<?=$product->productIdx?>/286/180" alt="<?=$product->product_title?>">
		  	<span class="d-inline-block item_desc"><?=$product->product_title?></span>
		  </a>
		<?php }?>
		<?php endif?>
		<?php if(count($sidebar_sliders) > 1):?>		
			<div style="height: 10px;"></div>
			<a href="<?=$sidebar_sliders[count($sidebar_sliders) - 1]->content?>" target="_blank">
				<img class="w-100 d-none d-md-block" src="<?=ROOTPATH?>api/image/media/<?=$sidebar_sliders[count($sidebar_sliders) - 1]->id?>/286/180" alt="<?=$sidebar_sliders[count($sidebar_sliders) - 1]->title?>">
			</a>
		<?php endif?>
		</div>
	</div>
</div>