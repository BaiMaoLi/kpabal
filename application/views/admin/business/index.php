        <div class="m-grid__item m-grid__item--fluid m-wrapper">

          <!-- BEGIN: Subheader -->
          <div class="m-subheader ">
            <div class="d-flex align-items-center">
              <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Business List</h3>
              </div>
            </div>
          </div>

          <!-- END: Subheader -->
          <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
              <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                  <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                      Advanced Search
                    </h3>
                    &nbsp;&nbsp;&nbsp;
                    <select id="categoryIdx" onchange='window.location.href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/business/"+this.value'>
                      <option value="">ALL</option>
                      <?php foreach($categories as $category) { ?>
                      <option value="<?=$category->categoryIdx?>"<?php if($categoryIdx == $category->categoryIdx) echo " selected";?>><?=$category->categoryName?></option>
                      <?php foreach($category->children as $sub_category) { ?>
                      <option value="<?=$sub_category->categoryIdx?>"<?php if($categoryIdx == $sub_category->categoryIdx) echo " selected";?>>&nbsp;&nbsp;&nbsp;<?=$sub_category->categoryName?></option>
                      <?php } } ?>
                    </select>
                  </div>
                </div>
                <div class="m-portlet__head-tools">
                  <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                      <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/business/add_new" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                          <i class="la la-cart-plus"></i>
                          <span>New Business</span>
                        </span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="m-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="business_table">
                  <thead>
                    <tr>
                      <th>Business Name</th>
                      <th>Thumbnails</th>
                      <th>Email Address</th>
                      <th>Phone</th>
                      <th>Fax</th>
                      <th>State</th>
                      <th>Category</th>
                      <th>Show / Hide</th>
                      <th>Registrant</th>
                      <th>Reg.Date</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            <input type="file" id="upload_attach" accept=".gif,.jpg,.jpeg,.png" style="display: none;">
            <!-- END EXAMPLE TABLE PORTLET-->
          </div>
        </div>