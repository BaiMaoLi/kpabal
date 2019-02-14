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
									<h3 class="box-title">Friend List of <?php echo $real_name;?></h3>
								</div>
								<!-- /.box-header -->
								<?php
								if($this->session->flashdata('msg')):
								?>
								<div style="color:#009933;font-size:12px;"><?php echo $this->session->flashdata('msg');?></div><br />
								<?php
								endif;
								?>
								<div class="box-body table-responsive">
									<table id="example2" class="table table-bordered table-hover">
										<thead>
											<tr>
												<th width="84"><strong>Date Added</strong></th>
												<th width="44"><strong>Name</strong></th>
												<th width="72"><strong>Username</strong></th>
												<th width="32"><strong>Age</strong></th>
												<th width="61"><strong>Location</strong></th>
											</tr>
										</thead>
										<?php
										if($friend_row):
											foreach($friend_row as $friend) {
										?>
										<tr>
											<td><?php echo date('d-m-Y',strtotime($friend->dated));?></td>
											<td><a href="<?php echo base_url().'profile/'.$friend->username;?>" target="_blank"><?php echo $friend->name;?></a></td>
											<td><?php echo $friend->username;?></td>
											<td><?php echo $friend->mAge;?></td>
											<td><?php echo $friend->city;?></td>
										</tr>
										<?php
										}
										endif;
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