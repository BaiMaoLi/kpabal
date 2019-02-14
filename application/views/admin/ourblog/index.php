        <div class="m-grid__item m-grid__item--fluid m-wrapper">

          <!-- BEGIN: Subheader -->
          <div class="m-subheader ">
            <div class="d-flex align-items-center">
              <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Our Blog List</h3>
              </div>
            </div>
          </div>

          <!-- END: Subheader -->
          <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
              <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                 
                </div>
                <div class="m-portlet__head-tools">
                
                </div>
              </div>
              <div class="m-portlet__body">
		  			  
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable blog_table">
                  <thead>
                    <tr>
                      <th>Image</th>
                      <th>Title</th>
                       <th>Content</th>
                       <th>Publish Date</th>
                       <th>Action</th>
                      <!--th>Actions</th-->
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($list_blogs as $details) {?>
                    <tr>
                            <td><img width="150px" src="<?php echo site_url();?><?=$details->image;?>"></td>
                            <td><?=$details->title;?></td>
                            <td><?=$details->content;?></td>
                            <td><?=$details->posted_date;?></td>
   							<td>
							<?php if($details->status == 0){?>
                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/ourblogs/approved_blog/<?=$details->id;?>" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Approve">
                              <i class="la la-bell-o"></i>
                            </a>
							<?php } else {?>
							<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/ourblogs/disapproved_blog/<?=$details->id;?>" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Dis-approve">
                              <i class="la la-bell-slash"></i>
                            </a>
							<?php } ?>
							
                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/ourblogs/delete_blog/<?=$details->id;?>" onclick="return confirm('Are you sure you want to delete this Blog?');" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill">
                                <i class="la la-remove" title="Remove"></i>
                            </a>
							 
							 <a href="#" data-toggle="modal" data-target="#my<?php echo $details->id;?>" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill">
                                <i class="la  la-street-view" title="View"></i>
                            </a> 
							 
							</td>
                    </tr>
					
					
					<div class="modal fade" id="my<?php echo $details->id;?>" role="dialog">
						<div class="modal-dialog">
						<!-- Modal content-->
							<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<form action="./update_blog" method="post" enctype='multipart/form-data'>
							<div class="modal-body">
								<img width="200" src="<?php echo site_url();?><?=$details->image;?>"><br><br>
								<input type="hidden" name="blog_id" value="<?php echo $details->id;?>"><br><br>
								<input type="text" name="title" value="<?php echo $details->title;?>"><br><br>
								<textarea name="content" cols="40" rows="10"><?php echo $details->content;?></textarea><br><br>
								<input type="submit" name="update_blog">
							</div>
							</form>
							<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
							</div>
						</div>
					</div>
					
					
                    <?php }
					
					
					?>
					
                  </tbody>
                </table>
              </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
          </div>
        </div>
    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>      
    <script>
    $(document).ready(function(){
        $("#careers_occupation1").change(function(){
            if($(this).val()>0){
                $.ajax({
                    url: "<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/jobs/ajax_cat",
                    type: "post",
                    data:{"id":$("#careers_occupation1").val()},
                    success: function(result){
                        $("#careers_occupation2").html('<option value="0">전체</option>'+result);
                    }
                });
            }else{
                $("#careers_occupation2").html('<option value="0">전체</option>');
            }
        });
    });
    </script>