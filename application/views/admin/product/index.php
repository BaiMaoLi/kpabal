
        <div class="m-grid__item m-grid__item--fluid m-wrapper">

          <!-- BEGIN: Subheader -->
          <div class="m-subheader ">
            <div class="d-flex align-items-center">
              <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Product List</h3>
              </div>
            </div>
          </div>

					
			
			<div class="m-portlet m-portlet--mobile"> 
			<div class="m-portlet__head"> 
			
			<div class="m-portlet__head-caption"> <div class="m-portlet__head-title"> </div> </div> <div class="m-portlet__head-tools"> <ul class="m-portlet__nav"> <li class="m-portlet__nav-item"> <a class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products/admin_upload_product/"> <span> <i class="la la-cart-plus"></i> <span>Add New Product</span> </span> </a> </li> </ul> </div>

			</div>
			</div>

          <!-- END: Subheader -->
          <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="product_table">
                  <thead>
                    <tr>
                      <th>Product Image</th>
                      <th>Product Name</th>
                      <th>Category</th>
                      <th>Price</th>
                      <th>Product Sku</th>
                      <th>Product Type</th>
                      <th>User Type</th>
                      <th>User Email</th>
                      <th>Address</th>
                      <th>Product Short Description</th>
                      <th>Product Long Description</th>
                      <th>Posted Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>				
                    <?php $CI =& get_instance();										
					foreach($products as $product) {?>
                    <tr>
                      <td><img style="width: 80px;" src="<?php echo site_url();?><?=$product->product_image_url; ?>"></td>
                      <td><?=$product->product_name?></td>
                      <td><?php 
							$cat_names = $CI->category_model->get_cat_name($product->product_categorys);
							foreach($cat_names as $cat_name){
						
								echo $cat_name->categoryName;
							}
					  ?></td>
                      <td><?=$product->price?></td>
                      <td><?=$product->product_Sku?></td>
                      <td><?=$product->product_type?></td>
                      <td><?=$product->user_type?></td>
                      <td><?=$product->user_email?></td>
                      <td><?=$product->Address?></td>
                      <td><?=$product->product_Short?></td>
                      <td><?=$product->product_Long?></td>
                      <td><?=$product->posted_date?></td>
                      <td><a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products/edit_product/<?=$product->id?>" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                          <i class="la la-edit"></i>
                        </a>
						<?php if($product->status == 0){?>
                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products/approved_prod/<?=$product->id;?>" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Approve">
                              <i class="la la-bell-o"></i>
                            </a>
							<?php } else {?>
							<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products/disapproved_prod/<?=$product->id;?>" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Dis-approve">
                              <i class="la la-bell-slash"></i>
                            </a>
							<?php } ?>
							<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products/delete_prod/<?=$product->id;?>" onclick="return confirm('Are you sure you want to delete this Blog?');" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill">
                                <i class="la la-remove" title="Remove"></i>
                            </a>
						
						</td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
          </div>
        </div>