<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title m-subheader__title--separator">Member Information</h3>
				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
					<li class="m-nav__item m-nav__item--home">
						<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/members" class="m-nav__link m-nav__link--icon">
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
			<form class="m-form m-form--fit m-form--label-align-right" id="member_form" novalidate="novalidate">
				<input type="hidden" name="memberIdx" value="<?=$memberIdx?>">
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
							<label class="form-control-label">User ID *</label>
							<input type="text" class="form-control m-input" name="user_id" placeholder="Enter user id" value="<?php if($member) echo $member->user_id;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Email *</label>
							<input type="text" class="form-control m-input" name="user_email" placeholder="Enter email" value="<?php if($member) echo $member->user_email;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">New Password</label>
							<input type="password" class="form-control m-input" name="user_password" id="user_password" placeholder="Enter new password" value="">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Re Enter New Password</label>
							<input type="password" class="form-control m-input" name="user_password2" id="user_password2" placeholder="Re-Enter new password" value="">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">First Name *</label>
							<input type="text" class="form-control m-input" name="first_name" placeholder="Enter first name" value="<?php if($member) echo $member->first_name;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Last Name *</label>
							<input type="text" class="form-control m-input" name="last_name" placeholder="Enter last name" value="<?php if($member) echo $member->last_name;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Gender *</label>
							<select class="form-control m-input" name="gender">
								<option value="">Select</option>
								<option value="1"<?php if(($member) && ($member->gender == 1)) echo " selected";?>>Male</option>
								<option value="0"<?php if(($member) && ($member->gender == 0)) echo " selected";?>>Female</option>
							</select>
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Day of Birthday *</label>
							<input type="text" class="form-control m-input" id="dob" name="dob" value="<?php if($member) echo date("m/d/Y", strtotime($member->dob));?>">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Address</label>
							<input type="text" class="form-control m-input" name="address" placeholder="Enter address" value="<?php if($member) echo $member->address;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Street</label>
							<input type="text" class="form-control m-input" name="street" placeholder="Enter street" value="<?php if($member) echo $member->street;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">City *</label>
							<input type="text" class="form-control m-input" name="city" placeholder="Enter city" value="<?php if($member) echo $member->city;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">State *</label>
							<select class="form-control m-input" name="stateIdx">
								<option value="">Select</option>
								<?php foreach($states as $state) {?>
								<option value="<?=$state->stateIdx?>"<?php if(($member) && ($member->stateIdx == $state->stateIdx)) echo " selected";?>><?=$state->stateName?></option>
								<?php }?>
							</select>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Postal Code *</label>
							<input type="text" class="form-control m-input" name="postal_code" placeholder="Enter postal code" value="<?php if($member) echo $member->postal_code;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Phone Number *</label>
							<input type="text" class="form-control m-input" id="phone" name="phone" placeholder="Enter phone number" value="<?php if($member) echo $member->phone;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Mobile Number</label>
							<input type="text" class="form-control m-input" name="mobile" placeholder="Enter mobile number" value="<?php if($member) echo $member->mobile;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">User Status *</label>
							<select class="form-control m-input" name="member_status">
								<option value="">Select</option>
								<option value="0"<?php if(($member) && ($member->member_status == 0)) echo " selected";?>>Pending</option>
								<option value="1"<?php if(($member) && ($member->member_status == 1)) echo " selected";?>>Normal</option>
								<option value="2"<?php if(($member) && ($member->member_status == 2)) echo " selected";?>>Prepared</option>
								<option value="3"<?php if(($member) && ($member->member_status == 3)) echo " selected";?>>Locked</option>
								<option value="4"<?php if(($member) && ($member->member_status == 4)) echo " selected";?>>Blocked</option>
							</select>
						</div>
					</div>
					<?php if($member):?>
					<div class="form-group m-form__group row">
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Member Points</label>
							<input type="text" class="form-control m-input" name="member_point" placeholder="Enter member point" value="<?php if($member) echo $member->member_point;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Avatar</label><br>
							<a href="#" id="select_avatar" class="btn btn-primary">Select Picture</a>
						</div>
						<?php if(file_exists(PROJECT_AVATAR_DIR."/user_".$memberIdx."_1.jpg")) unlink(PROJECT_AVATAR_DIR."/user_".$memberIdx."_1.jpg");?>
						<div class="col-md-3 m-form__group-sub">
							<img id="avatar" src="<?php if(file_exists(PROJECT_AVATAR_DIR."/user_".$memberIdx.".jpg")) echo ROOTPATH.PROJECT_AVATAR_DIR."/user_".$memberIdx.".jpg"; else echo ROOTPATH.PROJECT_AVATAR_DIR."/default.jpg";?>" style="display: inline-block; width: 80px; height: 80px; border: solid 2px #3235985c; border-radius: 5px;" alt=" Avatar">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">About Me</label><br>
							<!-- <input type="text" class="form-control m-input" name="member_about" placeholder="About Me" value=""> -->
							<textarea rows="4" cols="50" class="form-control m-input" name="member_about"><?php if($member) echo $member->member_about;?></textarea>
						</div>
					</div>
					<?php endif?>
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-9 ml-lg-auto">
								<button type="submit" class="btn btn-success">Save</button>
								<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/members" class="btn btn-secondary">Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
			<input type="file" id="upload_avatar" accept=".gif,.jpg,.jpeg,.png" style="display: none;">
		</div>
		<!--end::Portlet-->
	</div>
</div>