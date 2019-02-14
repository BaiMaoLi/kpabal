<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title m-subheader__title--separator">Business Information</h3>
				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
					<li class="m-nav__item m-nav__item--home">
						<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/business" class="m-nav__link m-nav__link--icon">
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
			<form class="m-form m-form--fit m-form--label-align-right" id="business_form" novalidate="novalidate">
				<input type="hidden" name="id" value="<?=$id?>">
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
							<label class="form-control-label">Business Name (English) *</label>
							<input type="text" class="form-control m-input" name="business_name_en" placeholder="Enter English business name" value="<?php if($business) echo $business->business_name_en;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Business Name (Korean) *</label>
							<input type="text" class="form-control m-input" name="business_name_ko" placeholder="Enter Korean business name" value="<?php if($business) echo $business->business_name_ko;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Business Category *</label>
							<select class="form-control m-input" name="categoryIdx">
								<option value="">Select</option>
								<?php foreach($categories as $category) {?>
								<option value="<?=$category->categoryIdx?>"<?php if(($business) && ($business->categoryIdx == $category->categoryIdx)) echo " selected";?>><?=$category->categoryName?></option>
								<?php foreach($category->children as $sub_category) { ?>
		                      	<option value="<?=$sub_category->categoryIdx?>"<?php if(($business) && ($business->categoryIdx == $sub_category->categoryIdx)) echo " selected";?>>&nbsp;&nbsp;&nbsp;<?=$sub_category->categoryName?></option>
		                      	<?php } } ?>
							</select>
						</div>
						<div class="col-md-1 m-form__group-sub">
							<label class="form-control-label">Zip</label>
							<input type="text" class="form-control m-input" name="zip" placeholder="Enter ZIP" value="<?php if($business) echo $business->zip;?>">
						</div>
						<div class="col-md-2 m-form__group-sub">
							<label class="form-control-label">Show / Hide</label>
							<span class="m-switch" style="display: block;">
			                    <label>
			                      <input type="checkbox"<?php if($business && $business->is_display) echo ' checked="checked"';?> class="form-control" name="is_display" />
			                      <span></span>
			                    </label>
			                </span>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Address</label>
							<input type="text" class="form-control m-input" name="address" placeholder="Enter address" value="<?php if($business) echo $business->address;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Street</label>
							<input type="text" class="form-control m-input" name="street" placeholder="Enter street" value="<?php if($business) echo $business->street;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">City *</label>
							<input type="text" class="form-control m-input" name="city" placeholder="Enter city" value="<?php if($business) echo $business->city;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">State *</label>
							<select class="form-control m-input" name="stateIdx">
								<option value="">Select</option>
								<?php foreach($states as $state) {?>
								<option value="<?=$state->stateIdx?>"<?php if(($business) && ($business->stateIdx == $state->stateIdx)) echo " selected";?>><?=$state->stateName?></option>
								<?php }?>
							</select>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Phone Number *</label>
							<input type="text" class="form-control m-input" id="phone1" name="phone1" placeholder="Enter phone number" value="<?php if($business) echo $business->phone1;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Mobile Number</label>
							<input type="text" class="form-control m-input" name="phone2" placeholder="Enter mobile number" value="<?php if($business) echo $business->phone2;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Fax Number</label>
							<input type="text" class="form-control m-input" name="phone2" placeholder="Enter fax number" value="<?php if($business) echo $business->fax;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Email *</label>
							<input type="text" class="form-control m-input" name="email" placeholder="Enter email" value="<?php if($business) echo $business->email;?>">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Web Site URL</label>
							<input type="text" class="form-control m-input" id="website" name="website" placeholder="Enter Web Site URL" value="<?php if($business) echo $business->website;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Work Time</label>
							<input type="text" class="form-control m-input" name="work_time" placeholder="Enter work time" value="<?php if($business) echo $business->work_time;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Admin Suggest</label>
							<span class="m-switch" style="display: block;">
			                    <label>
			                      <input type="checkbox"<?php if($business && $business->admin_pre_order_chk) echo ' checked="checked"';?> class="form-control" name="admin_pre_order_chk" />
			                      <span></span>
			                    </label>
			                </span>
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Admin Suggest Priority</label>
							<input type="text" class="form-control m-input" name="admin_pre_order" placeholder="Enter priority" value="<?php if($business) echo $business->admin_pre_order;?>">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Longitude</label>
							<input type="text" class="form-control m-input" name="longitude" placeholder="Enter Longitude" value="<?php if($business) echo $business->longitude;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Latitude</label>
							<input type="text" class="form-control m-input" name="latitude" placeholder="Enter Latitude" value="<?php if($business) echo $business->latitude;?>">
						</div>
						<div class="col-md-6 m-form__group-sub">
							<label class="form-control-label">Keywords</label>
							<input type="text" class="form-control m-input" name="business_keyword" placeholder="Enter keywords" value="<?php if($business) echo $business->business_keyword;?>">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-12 m-form__group-sub">
							<label for="exampleTextarea">Busniess Description</label>
							<textarea class="form-control m-input" rows="5" name="business_description" placeholder="Enter business description"><?php if($business) echo $business->business_description;?></textarea>
						</div>
					</div>
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-9 ml-lg-auto">
								<button type="submit" class="btn btn-success">Save</button>
								<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/business" class="btn btn-secondary">Cancel</a>
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