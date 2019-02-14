<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title m-subheader__title--separator">Business Option Information (<?=$business->business_name_ko?>)</h3>
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
			<form class="m-form m-form--fit m-form--label-align-right" id="business_option_form" novalidate="novalidate">
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
					<?php 
						$n = 0;
						foreach($options as $option) {
							if(($n) && ($n % 4 == 0)) echo '</div><div class="form-group m-form__group row">';
							$n++;
					?>					
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label"><?=$option->option_code?></label>
							<input type="text" class="form-control m-input" name="option_<?=$option->id?>" placeholder="Enter <?=$option->option_code?>" value="<?php if(isset($option->option_value)) echo $option->option_value; ?>">
						</div>
					<?php }?>					
					</div>
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-9 ml-lg-auto">
								<a href="#" class="btn btn-success" id="btn_save_option">Save</a>
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