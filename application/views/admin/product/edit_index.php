<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title m-subheader__title--separator">Product Information</h3>
				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
					<li class="m-nav__item m-nav__item--home">
						<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products" class="m-nav__link m-nav__link--icon">
							<i class="m-nav__link-icon la la-home"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- END: Subheader -->
	<div class="m-content">
		<!--begin::Portlet-->
		<div class="m-portlet">
			<!--begin::Form-->
			<form action="../update_product" method="post" class="m-form m-form--fit m-form--label-align-right" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php if($edit_product) echo $edit_product->id;?>">
				<div class="m-portlet__body">
					<div class="m-form__content">
						<div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="m_form_1_msg">
							<div class="m-alert__icon">
								<i class="la la-warning"></i>
							</div>
							<div class="m-alert__text">
								Oh snap! Change a few things up and try submitting again.
							</div>
							<div class="m-alert__close">
								<button type="button" class="close" data-close="alert" aria-label="Close">
								</button>
							</div>
						</div>
					</div>	
					<div class="form-group m-form__group row">
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Product Name *</label>
							<input type="text" class="form-control m-input" name="product_name" required placeholder="Enter product name" value="<?php if($edit_product) echo $edit_product->product_name;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Price *</label>
							<input type="text" class="form-control m-input" name="price" required placeholder="Enter price" value="<?php if($edit_product) echo $edit_product->price;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">sku </label>
							<input type="text" class="form-control m-input" name="product_Sku" placeholder="Enter Sku" value="<?php if($edit_product) echo $edit_product->product_Sku;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">type *</label>							
									<select class="form-control m-input" required name="product_type">
									<option value="">--Select Product Type--</option>
									<option value="used" <?php if($edit_product->product_type == 'used') echo "selected"; ?>>Used</option>
									<option value="new" <?php if($edit_product->product_type == 'new') echo "selected"; ?>>New</option>
									</select>							
							
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">user type *</label>						
							<select class="form-control m-input" required name="user_type">
				<option value="">--Select User Type--</option>
				<option value="By Admin" <?php if($edit_product->user_type == 'By Admin') echo "selected"; ?>>By Admin</option>
				<option value="free" <?php if($edit_product->user_type == 'free') echo "selected"; ?>>Free</option>
				<option value="premium" <?php if($edit_product->user_type == 'premium') echo "selected"; ?>>Premium</option>
				</select>   
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">user email *</label>
							<input type="text" class="form-control m-input" name="user_email" required placeholder="Enter User Email" value="<?php if($edit_product) echo $edit_product->user_email;?>">
						</div>
						<div class="col-md-6 m-form__group-sub">
							<label class="form-control-label">address *</label>
							<textarea name="Address" rows="4" cols="37" required><?php if($edit_product) echo $edit_product->Address;?></textarea>
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">short description *</label>
							<input type="text" class="form-control m-input" name="product_Short" required placeholder="Enter Short Description" value="<?php if($edit_product) echo $edit_product->product_Short;?>">
						</div>
						<div class="col-md-9 m-form__group-sub">
							<label class="form-control-label">long description *</label>						
							<textarea name="product_Long" rows="6" cols="60" required><?php if($edit_product) echo $edit_product->product_Long;?></textarea>
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">city *</label>
														
						<select class="form-control m-input" name="user_city" required>
							<option value="">--Select City--</option>
							<?php 
							foreach($get_product_city as $city){?>
							<option value="<?php echo $city->city_name;?>"><?php echo $city->city_name;?></option>
							<?php } ?>
						</select> 
							
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">state *</label>
							<select class="form-control m-input" name="user_state" required>
							<option value="">--Select State--</option>
							<?php 
								foreach($states as $statesname){?>
								<option value="<?php echo $statesname->stateCode;?>"><?php echo $statesname->stateName;?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">country *</label>
							<select class="form-control m-input" name="user_country" required>
								<option value="">--Select Country--</option>																
							<?php foreach($get_product_country as $country){?>
							<option value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
							<?php } ?>
								
							</select>
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Category *</label>
							<select class="form-control m-input" name="product_categorys" required>
								<option value="">Select</option>
								<?php foreach($categories as $category) { ?>
		                      <option value="<?=$category->categoryIdx?>"<?php if(($edit_product) && ($edit_product->product_categorys == $category->categoryIdx)) echo " selected";?>><?=$category->categoryName?></option>
		                      <?php  } ?>
							</select>
						</div>
						
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Sub Category</label>
							<select class="form-control m-input" name="product_categorys" required>
								<option value="">Select</option>
								<?php foreach($categories as $category) { 
									foreach($category->children as $sub_category) { ?>
										<option value="<?=$sub_category->categoryIdx?>"<?php if(($edit_product) && ($edit_product->product_categorys == $sub_category->categoryIdx)) echo "selected";?>><?=$sub_category->categoryName?></option>
								<?php } } ?>
							</select>
						</div>
						
						
					</div>
				
					<?php if($edit_product):?>
					<div class="form-group m-form__group row">
						<div class="col-md-12 m-form__group-sub">
							<label class="form-control-label">Product Feature Image</label>  :
							<img src="<?php echo site_url();?><?php echo $edit_product->product_image_url;?>" width="150px">
							<input type="file" name="product_image_url" accept=".gif,.jpg,.jpeg,.png">
						</div>
					</div>
					<?php endif?>
					
					<?php if($edit_product):?>
					<div class="form-group m-form__group row">
						<div class="col-md-12 m-form__group-sub">
							<label class="form-control-label">Product gallary Images</label>  : 
							<?php 
							$gallImg = $edit_product->product_gallary_image;
							foreach(explode(',',$gallImg) as $img){?>
								<img src="<?php echo site_url();?><?php echo $img;?>" width="90px" height="90px">
							<?php } ?>
						 <input type="file" name="userfile[]" accept=".gif,.jpg,.jpeg,.png" multiple="">
						</div>
					</div>
					<?php endif?>
					
					
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-9 ml-lg-auto">
								<button type="submit" class="btn btn-success">Save</button>
								<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products" class="btn btn-secondary">Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
			
		</div>
		<!--end::Portlet-->
	</div>
</div>