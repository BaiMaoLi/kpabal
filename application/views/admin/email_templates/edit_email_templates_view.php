<div class="m-grid__item m-grid__item--fluid m-wrapper">
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
<div class="d-flex align-items-center">
	<div class="mr-auto">
		<h3 class="m-subheader__title m-subheader__title--separator">Manage Email Templates</h3>
		<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
			<li class="m-nav__item m-nav__item--home">
				<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/pages_manage" class="m-nav__link m-nav__link--icon">
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
	<div class="m-portlet__body">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Edit  Email Templates</h3>
					</div>
					<!-- /.box-header -->
					<div style="font-size:11px; color:#F00;"><?php echo validation_errors(); ?></div>
					<?php
					if($this->session->flashdata('msg')):
					?>
					<div style="color:#009933;font-size:12px;"><?php echo $this->session->flashdata('msg');?></div><br />
					<?php
								endif;
					?>
					
					<?php echo form_open(ADMIN_PUBLIC_DIR.'/'.$page_name.'/update/'.$row->ID, array('name'=>'frm', 'id'=>'frm')); ?>
					
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<div id="msg_box"></div>
							<div class="nav-tabs-custom">
								<div class="tab-content">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Email Template Name</label>
												<input type="text" placeholder="Email Name" name="email_name" value="<?php echo $row->email_name;?>" id="email_name" class="form-control" required >
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label>From Name</label>
												<input type="text" placeholder="From Name" name="from_name" value="<?php echo $row->from_name;?>" id="from_name" class="form-control" required >
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label>From Email Address</label>
												<input type="text" placeholder="From Email Address" value="<?php echo $row->from_email;?>" name="from_email" id="from_email" class="form-control" required >
											</div>
										</div>
										
										<div class="col-md-12">
											<div class="form-group">
												<label>Email Subject</label>
												<input type="text" placeholder="Email Subject" name="email_subject"  value="<?php echo $row->email_subject;?>" id="email_subject" class="form-control" required >
											</div>
										</div>
										<div class="col-md-12">
											<label>Email Content</label>
											<textarea placeholder="Email Content" name="editor1" id="editor1" class="summernote form-control"><?php echo $row->email_content;?></textarea>
											<script>
											// CKEDITOR.replace( 'editor1', {
												// 	fullPage: false,
												// 	allowedContent: true,
												// 	extraPlugins: 'wysiwygarea'
											// });
													
											</script>
											
										</div>
									</div>
								</div>
								<!-- /.tab-content -->
								
							</div>
						</div>
					</div>
					
					<!-- /.box-body -->
					
					<div class="box-footer">
						<input type="hidden" value="update" name="method" id="method" />
						<input type="hidden" value="<?php echo $row->ID;?>" name="pid" id="pid" />
						<button class="btn btn-primary" id="btn_submit" type="submit">Update</button>
					</div>
					<?php echo form_close();?>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
				
				<!-- /.box -->
			</div>
		</div>
		<!--end::Portlet-->
	</div>
</div>