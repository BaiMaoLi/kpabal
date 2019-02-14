<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title m-subheader__title--separator">Article Information</h3>
				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
					<li class="m-nav__item m-nav__item--home">
						<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards" class="m-nav__link m-nav__link--icon">
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
			<form class="m-form m-form--fit m-form--label-align-right" id="board_form" novalidate="novalidate">
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
							<label class="form-control-label">Article Title *</label>
							<input type="text" class="form-control m-input" name="article_title" placeholder="Enter article title" value="<?php if($board) echo $board->article_title;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Board Category *</label>
							<select class="form-control m-input" name="categoryIdx">
								<option value="">Select</option>
								<?php foreach($categories as $category) {?>
								<option value="<?=$category->categoryIdx?>"<?php if(($board) && ($board->categoryIdx == $category->categoryIdx)) echo " selected";?>><?=$category->categoryName?></option>
								<?php foreach($category->children as $sub_category) { ?>
		                      	<option value="<?=$sub_category->categoryIdx?>"<?php if(($board) && ($board->categoryIdx == $sub_category->categoryIdx)) echo " selected";?>>&nbsp;&nbsp;&nbsp;<?=$sub_category->categoryName?></option>
		                      	<?php } } ?>
							</select>
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Admin Suggest</label>
							<span class="m-switch" style="display: block;">
			                    <label>
			                      <input type="checkbox"<?php if($board && $board->admin_pre_order_chk) echo ' checked="checked"';?> class="form-control" name="admin_pre_order_chk" />
			                      <span></span>
			                    </label>
			                </span>
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Admin Suggest Priority</label>
							<input type="text" class="form-control m-input" name="admin_pre_order" placeholder="Enter priority" value="<?php if($board) echo $board->admin_pre_order;?>">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-12 m-form__group-sub">
							<label for="exampleTextarea">Article Content</label>
							<textarea class="form-control m-input" rows="5" name="article_content" placeholder="Enter article content"><?php if($board) echo $board->article_content;?></textarea>
						</div>
					</div>
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-9 ml-lg-auto">
								<button type="submit" class="btn btn-success">Save</button>
								<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards" class="btn btn-secondary">Cancel</a>
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