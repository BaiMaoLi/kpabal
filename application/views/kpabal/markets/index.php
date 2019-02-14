<div class="container">
  <div class="breadcrumb-bar">
    <ul>
      <li><a href="#">Home</a></li>
     
    </ul>
  </div>
</div>
<div class="container-fluid-wrapper">
  <div class="container" style=" margin-top:20px;">
    <div class="row">
		<div class="col-md-3 side-bar-wrapper">
        <div class="wrapper-title">categories</div>
		<nav class="nav-tree nobottommargin">
                                        
										
									<ul>
									<?php 
									 foreach($categories as $cat){?>
										 <li class="link"><a href="#"><?php echo $cat->categoryName;?></a></li>
										 
									<?php } ?>
									
									</ul>
										
										
										
										
                                        
                                        
                                    </nav>

		</div>
		<div class="col-md-6">
        <div class="content-product">
          <div class="banner">
		 
			
			<div class="gpe_pm_conban">
            <div class="gpe_pm_ban_imgbox">				
                <?php foreach($home_sliders as $slider){?>
                <a href="<?=$slider->content?>"><img src="<?php echo site_url();?>api/image/media/<?=$slider->id?>/790/120" alt="<?=$slider->title?>"/></a>
                <?php }?>
            </div>
            <span class="gpe_prev"></span>
            <span class="gpe_next"></span>
        </div>
			
		  </div>
		  
		        <script>
            var j_bc = jQuery;
            j_bc(function() {
                j_bc('.gpe_pm_conban').slides({
                    preload: true,
                    preloadImage: '<?=PROJECT_IMG_DIR?>loading.gif',
                    play: 5000,
                    pause: 1,
                    hoverPause: true
                });
            });
        </script>
          <div class="search-bar-wrapper">
            <div class="search-title">
              <div class="product-search-title">You are here: <strong id="location">...</strong></div>
             </div>
			<form method="post" action="" class="card card-sm">
            <div class="search-wrapper">
              <div class="select-box-row">
			  
				<div class="selectblock"><span>City</span>
                  <div class="select-box">
                    		<select name="user_city">
						<option value="">--Select City--</option>
						<option value="juneau">Juneau</option>
						<option value="phoenix">Phoenix</option>
						<option value="Sacramento">Sacramento</option>
					</select>  
                  </div>
                </div>
			  
			  
			  
                <div class="selectblock"><span>State / Province</span>
                  <div class="select-box">
                    <select name="user_state">
	                  <option value="">--Select State--</option>
                      <option value="sidney">sidney</option>
                      <option value="newyork">newyork</option>
                      <option value="washigton">washigton</option>
                    </select>
                  </div>
                </div>
				
                <div class="selectblock"> <span>Country</span>
                  <div class="select-box">
                    <select name="user_country">
						<option value="">--Select Country--</option>
						<option value="united state">US</option>
						<option value="united kingdom">UK</option>
						<option value="india">India</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="location-relate">
                <ul>
                  <li><a href="#">Manhattan</a></li>
                  <li><a href="#">Brooklyn</a></li>
                  <li><a href="#">Queens</a></li>
                  <li><a href="#">Bronx</a></li>
                  <li><a href="#">Staten Island</a></li>
                  <li><a href="#">Long Island</a></li>
                  <li><a href="#"> New Jersey</a></li>
                </ul>
              </div>
			  
				
				<div class="select-box-row">
                <div class="selectblock"> <span>Category</span>
                  <div class="select-box">
                    <select name="category">
					<option value="">--Select Category--</option>
                      	<?php foreach($categories as $category) { ?>
		                      <option value="<?=$category->categoryIdx?>"<?php if(($product) && ($product->category == $category->categoryIdx)) echo " selected";?>><?=$category->categoryName?></option>
		                      <?php foreach($category->children as $sub_category) { ?>
		                      <option value="<?=$sub_category->categoryIdx?>"<?php if(($product) && ($product->category == $sub_category->categoryIdx)) echo " selected";?>>&nbsp;&nbsp;&nbsp;<?=$sub_category->categoryName?></option>
		                      <?php } } ?>
                    </select>
					</div>
                </div>
                <div class="selectblock search-bar"> <span>Search word</span>
                  <div class="select-box">
                   
                      <div class="card-body row no-gutters align-items-center"> 
                        
                        <!--end of col-->
                        <div class="col">
                          <input class="form-control form-control-lg form-control-borderless" name="keyword" type="text" placeholder="Search topics or keywords">
                        </div>
                        <!--end of col-->
                        <div class="col-auto">
                          <input class="btn btn-lg btn-success" name="search_product" type="submit" value="Search">
                        </div>
                        <!--end of col--> 
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!--div class="adv-search-content" style=" display: none;">
                <div class="col"> <span class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Seller Type</font></font></span>
                  <ul class="seller-type-wrap">
                    <li>
                      <input type="radio" name="businesstype" id="s-all" value="">
                      <label for="s-all"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">all</font></font></label>
                    </li>
                    <li>
                      <input type="radio" name="businesstype" id="s-personal" value="001001001">
                      <label for="s-personal"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Normal</font></font></label>
                    </li>
                    <li>
                      <input type="radio" name="businesstype" id="s-business" value="001001002">
                      <label for="s-business"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">business</font></font></label>
                    </li>
                  </ul>
                </div>
                <div class="col"> <span class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Price range</font></font></span>
                  <div class="input-group"> <span class="input-group-addon p-monetary-symbol">$</span>
                    <input type="number" placeholder="" id="price01" name="from">
                  </div>
                  <span class="sep">~</span>
                  <div class="input-group"> <span class="input-group-addon p-monetary-symbol"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">$</font></font></span>
                    <input type="number" placeholder="" id="price02" name="to">
                  </div>
                </div>
              </div>
              <div class="advanced-search"><a href="#">Advanced search</a> </div-->
            </div>
          </div>
		  
			
			<?php 
			
			
			
			if(!empty($fetch_products)){?>
				
				<div class="product-wrapper">
            <div class="product-title">
              <div class="product-title-wrapp">Premium Products</div>
              <div class="produc-btn"><a href="#"><img src="assets/images/product.png"></a></div>
              <div class="produc-btn"><a href="<?= site_url();?>register"><img src="assets/images/user.png"></a></div>
            </div>
			
			
            <div class="product-row-wrapper">
			
			<?php
			$prod_type = array();
			foreach($fetch_products as $uploadeds){
				
				if($uploadeds->user_type == "premium"){
					
					$prod_type[] = $uploadeds;
				}
				
			}	
			
			

			foreach($prod_type as $uploadeds){ 
			
			$segments = array('Productupload', 'product_details',$uploadeds->id);
			?>
			
			
              <div class="product-row">
                <div class="product-img"><a href="<?=site_url($segments); ?>"><img src="<?php echo site_url();?><?php echo $uploadeds->product_image_url;?>"  class="img-fluid" alt=""></a></div>
                <div class="product-text-block">
                  <div class="name-date-wrapper">
                    <div class="product-name">

					
					

					<a href="<?=site_url($segments); ?>"><?php echo $uploadeds->product_name;?></a>


					</div>
                    <div class="date-wrapper"><?php echo $uploadeds->posted_date;?></div>
                  </div>
                  <div class="product-price">$<?php echo $uploadeds->price;?></div>
                  <div class="product-sub-text"><?php echo $uploadeds->product_Short;?></div>
                </div>
              </div>
           
			<?php } ?>
            
            </div>
          </div>
          <div class="product-wrapper Preferred-products">
            <div class="product-title">
              <div class="product-title-wrapp">Preferred products</div>
              <div class="produc-btn"><a href="#"><img src="assets/images/product.png"></a></div>
            </div>
            <div class="product-row-wrapper">
			
			
             <?php 
			 
				$free = array();
				foreach($fetch_products as $uploadeds){
				
				if($uploadeds->user_type != "premium"){
					
					$free[] = $uploadeds;
				}
				
				}	
			 
			 
			 foreach($free as $uploadeds){
				$segments = array('Productupload', 'product_details',$uploadeds->id);
			 ?>
			
			
              <div class="product-row">
                <div class="product-img"><a href="<?=site_url($segments); ?>"><img src="<?php echo site_url();?><?php echo $uploadeds->product_image_url;?>"  class="img-fluid" alt=""></a></div>
                <div class="product-text-block">
                  <div class="name-date-wrapper">
                    <div class="product-name">

					
					

					<a href="<?=site_url($segments); ?>"><?php echo $uploadeds->product_name;?></a>


					</div>
                    <div class="date-wrapper"><?php echo $uploadeds->posted_date;?></div>
                  </div>
                  <div class="product-price">$<?php echo $uploadeds->price;?></div>
                  <div class="product-sub-text"><?php echo $uploadeds->product_Short;?></div>
                </div>
              </div>
           
			<?php } ?>
             
            </div>
          </div>
				
				
				
			
				
			<?php } else {?>
		  
			<div class="product-wrapper">
            <div class="product-title">
              <div class="product-title-wrapp">Premium Products</div>
              <div class="produc-btn"><a href="#"><img src="assets/images/product.png" title="Premium products"></a></div>
              <div class="produc-btn"><a href="<?= site_url();?>register"><img src="assets/images/user.png" title="Register"></a></div>
            </div>
			
			
            <div class="product-row-wrapper">
			
			<?php
			$prod_type = array();
			foreach($uploadedproducts as $uploadeds){
				
				if($uploadeds->user_type == "premium"){
					
					$prod_type[] = $uploadeds;
				}
				
			}	
			
			

			foreach($prod_type as $uploadeds){ 
			
			$segments = array('Productupload', 'product_details',$uploadeds->id);
			?>
						
            <div class="product-row">
                <div class="product-img"><a href="<?=site_url($segments); ?>"><img src="<?php echo site_url();?><?php echo $uploadeds->product_image_url;?>"  class="img-fluid" alt=""></a></div>
                <div class="product-text-block">
					<div class="name-date-wrapper">
                    <div class="product-name">
						<a href="<?=site_url($segments); ?>"><?php echo $uploadeds->product_name;?></a>
					</div>
                    <div class="date-wrapper"><?php echo $uploadeds->posted_date;?></div>
					</div>
					<div class="product-price">$<?php echo $uploadeds->price;?></div>
					<div class="product-sub-text"><?php echo $uploadeds->product_Short;?></div>
                </div>
            </div>
           
			<?php } ?>
            
            </div>
          </div>
          <div class="product-wrapper Preferred-products">
            <div class="product-title">
              <div class="product-title-wrapp">Preferred products</div>
              <div class="produc-btn"><a href="#"><img src="assets/images/product.png" title="Preferred products"></a></div>
            </div>
            <div class="product-row-wrapper">
			
			
            <?php 
			 
				$free = array();
				foreach($uploadedproducts as $uploadeds){
				
				if($uploadeds->user_type != "premium"){
					
					$free[] = $uploadeds;
				}
				
				}	
			 
			 
				foreach($free as $uploadeds){
					$segments = array('Productupload', 'product_details',$uploadeds->id);
			?>
			
			
				<div class="product-row">
                <div class="product-img"><a href="<?=site_url($segments); ?>"><img src="<?php echo site_url();?><?php echo $uploadeds->product_image_url;?>"  class="img-fluid" alt=""></a></div>
                <div class="product-text-block">
                  <div class="name-date-wrapper">
                    <div class="product-name">
					<a href="<?=site_url($segments); ?>"><?php echo $uploadeds->product_name;?></a>
					</div>
                    <div class="date-wrapper"><?php echo $uploadeds->posted_date;?></div>
                  </div>
                  <div class="product-price">$<?php echo $uploadeds->price;?></div>
                  <div class="product-sub-text"><?php echo $uploadeds->product_Short;?></div>
                </div>
				</div>
           
			<?php } ?>
             
            </div>
          </div>
		  
		  
			<?php } ?>
		  
        </div>
        
        <!--div class="pagination-wrapper">
        <div class="prev-wrapper"><a href="#"><< Prev </a></div>
        <div class="pagination-wrap">
        <ul>
        <li><a href="#">1</a></li>
         <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
           <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
             <li><a href="#">6</a></li>
            <li><a href="#">7</a></li>
        
        </ul> 
        </div>
        
        <div class="next-wrapper"><a href="#">Next >></a></div>
        
        
        </div-->
        
        
        
        
      </div>
      <div class="col-md-3 right-side-bar-wrapper">
		  <?php include_once(__DIR__."/../common/sidebar.php");?>
      </div>
    </div>
  </div>
</div>

	
	
	 <script>
            window.onload = function () {
                var startPos;
                var geoOptions = {
                    maximumAge: 5 * 60 * 1000,
                    timeout: 10 * 1000,
                    enableHighAccuracy: true
                }


                var geoSuccess = function (position) {
                    startPos = position;
                    geocodeLatLng(startPos.coords.latitude, startPos.coords.longitude);

                };
                var geoError = function (error) {
                    console.log('Error occurred. Error code: ' + error.code);
                    // error.code can be:
                    //   0: unknown error
                    //   1: permission denied
                    //   2: position unavailable (error response from location provider)
                    //   3: timed out
                };

                navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions);
            };
            function geocodeLatLng(lat, lng) {
                var geocoder = new google.maps.Geocoder;
                var latlng = {lat: parseFloat(lat), lng: parseFloat(lng)};
                geocoder.geocode({'location': latlng}, function (results, status) {
                    if (status === 'OK') {
                        console.log(results)
                        if (results[0]) {
                            document.getElementById('location').innerHTML = results[0].formatted_address;
                            var street = "";
                            var city = "";
                            var state = "";
                            var country = "";
                            var zipcode = "";
                            for (var i = 0; i < results.length; i++) {
                                if (results[i].types[0] === "locality") {
                                    city = results[i].address_components[0].long_name;
                                    state = results[i].address_components[2].long_name;

                                }
                                if (results[i].types[0] === "postal_code" && zipcode == "") {
                                    zipcode = results[i].address_components[0].long_name;

                                }
                                if (results[i].types[0] === "country") {
                                    country = results[i].address_components[0].long_name;

                                }
                                if (results[i].types[0] === "route" && street == "") {

                                    for (var j = 0; j < 4; j++) {
                                        if (j == 0) {
                                            street = results[i].address_components[j].long_name;
                                        } else {
                                            street += ", " + results[i].address_components[j].long_name;
                                        }
                                    }

                                }
                                if (results[i].types[0] === "street_address") {
                                    for (var j = 0; j < 4; j++) {
                                        if (j == 0) {
                                            street = results[i].address_components[j].long_name;
                                        } else {
                                            street += ", " + results[i].address_components[j].long_name;
                                        }
                                    }

                                }
                            }
                            if (zipcode == "") {
                                if (typeof results[0].address_components[8] !== 'undefined') {
                                    zipcode = results[0].address_components[8].long_name;
                                }
                            }
                            if (country == "") {
                                if (typeof results[0].address_components[7] !== 'undefined') {
                                    country = results[0].address_components[7].long_name;
                                }
                            }
                            if (state == "") {
                                if (typeof results[0].address_components[6] !== 'undefined') {
                                    state = results[0].address_components[6].long_name;
                                }
                            }
                            if (city == "") {
                                if (typeof results[0].address_components[5] !== 'undefined') {
                                    city = results[0].address_components[5].long_name;
                                }
                            }

                            var address = {
								"country": country,
								"state": state,
                            };

                            document.getElementById('location').innerHTML = address.state;
                            
                        } else {
                            window.alert('No results found');
                        }
                    } else {
                        window.alert('Geocoder failed due to: ' + status);
                    }
                });
            }
        </script>
	
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1J9eNEGnUF3-ZZ4MlHWwL_EwE-YbCaes&callback=initMap">
    </script>
