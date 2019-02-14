<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title m-subheader__title--separator">Manage User Massages</h3>
				<!-- <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
					<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/pages_manage" class="m-nav__link m-nav__link--icon">
						<i class="m-nav__link-icon la la-home"></i>
					</a>
				</li>
			</ul> -->
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
								<h3 class="box-title">All Messages</h3>
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
											<th><strong>Sender</strong></th>
											<th><strong>Receiver</strong></th>
											<th><strong>Message</strong></th>
											<th><strong>Action</strong></th>
										</tr>
									</thead>
									<?php
									if($message_row) {
										foreach($message_row as $message) {
											?>
											<tr>
												<td><?php echo date('d-m-Y',strtotime($message['date_send']));?></td>
												<td><?php echo $message['sender'];?></td>
												<td><?php echo $message['reciever'];?></td>
												<td><?php echo $message['message'];?></td>
												<td>
													<a href="<?php echo base_url(). ADMIN_PUBLIC_DIR.'/all_messages/message_delete/'.$message['messages_id'];?>" onclick="if(confirm('Do you want to delete message?')){ return true; } else {return false;} ">Delete Message</a><br/>
												</td>
											</tr>
											<?php
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