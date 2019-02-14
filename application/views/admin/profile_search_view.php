<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title m-subheader__title--separator">Profile Management</h3>
			</div>
		</div>
	</div>
	<!-- END: Subheader -->
	<div class="m-content">
		<!--begin::Portlet-->
		<div class="m-portlet">
			<div class="m-portlet__body">
				<section class="content">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Search Result By <?php echo $heading;?></h3>
								</div>
								<!-- /.box-header -->
								<?php
								if($this->session->flashdata('msg')):
									?>
									<!-- <div style="color:#009933;font-size:12px;"><?php echo $this->session->flashdata('msg');?></div><br /> -->
									<?php
								endif;
								?>
								
								<div class="box-body table-responsive">
									<table id="example2" class="table table-bordered table-hover">
										
										<thead>
											<tr>
												<th><strong>Date Added</strong></th>
												<th><strong>Name</strong></th>
												<th><strong>Email</strong></th>
												<th><strong>Username</strong></th>
												<th><strong>Status</strong></th>
												<th><strong>Action</strong></th>
											</tr>
										</thead>
										<?php
										$i=0;
										if($profiles_view){
											foreach($profiles_view as $profile) {
												$class = ($i%2==0)?'row':'row1';
												if($profile->sts == 'active') {
													$stsConvert = 'inactive';
												} else {
													$stsConvert = 'active';
												}
												?>
												<tr>
													<td><?php echo date('d-m-Y',strtotime($profile->dated));?></td>
													<td><?php echo $profile->name;?></td>
													<td><?php echo $profile->email;?></td>
													<td><?php echo $profile->username;?></td>
													<td><?php echo ucwords($profile->sts);?></td>
													<td>
														<a href="<?php echo base_url(). ADMIN_PUBLIC_DIR. '/profile_detail/profile/'.$profile->username;?>">View Detail</a><br/>
														<a href="<?php echo base_url(). ADMIN_PUBLIC_DIR. '/profile_detail/profile_delete/'.$profile->id;?>" onclick="if(confirm('Do you want to delete profile?')){ return true; } else {return false;} ">Delete Profile</a><br/>
														<a href="<?php echo base_url(). ADMIN_PUBLIC_DIR. '/profile_detail/profile_sts/'.$profile->id.'/'.$stsConvert;?>"><?php echo ucwords($stsConvert);?> Profile</a>
													</td>
												</tr>
												<?php
												$i++;
											}
										}
										?>
										<tfoot>
										</tfoot>
									</table>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
							<!-- /.box -->
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>