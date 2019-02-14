
        <div class="m-grid__item m-grid__item--fluid m-wrapper">

          <!-- BEGIN: Subheader -->
          <div class="m-subheader ">
            <div class="d-flex align-items-center">
              <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Manage City And Country List</h3>
              </div>
            </div>
          </div>

          <!-- END: Subheader -->
          <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__body">
				<h3>Add City</h3>
				<br>
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="product_table">
                  <thead>
                    <tr>
                      <th>Add City Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>				
                   <form action="./add_product_city" method="post">
                    <tr>
                      <td><input type="text" required name="city_name"></td>
                      <td><input type="submit" value="Add City"></td>
                    </tr>
					</form>
                  </tbody>
                </table>
				<br>
				<br>
					<table class="table table-striped- table-bordered table-hover table-checkable" id="product_table">
					<thead>
                    <tr>
                      <th>City Name</th>
                      <th>Action</th>
                    </tr>
					</thead>
					<tbody>				
					<?php foreach($get_product_city as $get_name) { ?>
                    <tr>
                      <td><?php echo $get_name->city_name;?></td>
                      <td>
					  <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products/delete_prod_city/<?=$get_name->id;?>" onclick="return confirm('Are you sure you want to delete this Country?');" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-remove" title="Remove"></i></a>
	 				</td>
                    </tr>
					<?php } ?>
					</tbody>
					</table>
				<br>
				<h3>Add Country</h3>
				<br>
				<table class="table table-striped- table-bordered table-hover table-checkable" id="product_table">
                  <thead>
                    <tr>
                      <th>Add Country Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>				
                   <form action="./add_product_country" method="post">
                    <tr>
                      <td><input type="text" required name="country_name"></td>
                      <td><input type="submit" value="Add Country"></td>
                    </tr>
					</form>
                  </tbody>
                </table>
				<br>
				<br>
				<table class="table table-striped- table-bordered table-hover table-checkable" id="product_table">
					<thead>
                    <tr>
                      <th>Country Name</th>
                      <th>Action</th>
                    </tr>
					</thead>
					<tbody>				
					<?php foreach($get_product_country as $get_name) { ?>
                    <tr>
                      <td><?php echo $get_name->country_name;?></td>
                      <td>
					  <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products/delete_prod_country/<?=$get_name->id;?>" onclick="return confirm('Are you sure you want to delete this Country?');" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-remove" title="Remove"></i></a>
	 				</td>
                    </tr>
					<?php } ?>
					</tbody>
					</table>
				
				
				
              </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
          </div>
        </div>