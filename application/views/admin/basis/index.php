<!-- MODAL STICK UP  -->
<div class="modal fade" id="addNewAppModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document"<?php if(isset($is_wide)) echo ' style="width:100%; max-width: 100%;"';?>>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?=$dispCaption?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-bottom: 5px;">   
        <form role="form" id="category_form" name="category_form">
        <?php foreach($columns as $column_arr) {
          echo '<div class="row">';
        foreach($column_arr as $column) {
          if($column["type"] == "hidden") {
        ?>
          <input id="<?=$column["name"]?>" name="<?=$column["name"]?>" type="hidden">
        <?php
            continue;
          }
        ?>
            <div class="col-sm-<?=round(12 / count($column_arr))?>">
              <div class="form-group form-group-default">
                <label><?=$column["caption"]?></label>
                <?php if($column["type"] == "onoff") {?>
                <span class="m-switch" style="display: block;">
                  <label>
                    <input type="checkbox" checked="checked" class="form-control" id="<?=$column["name"]?>" name="<?=$column["name"]?>" />
                    <span></span>
                  </label>
                </span>
                <?php } else if($column["type"] == "textarea") {?>
                <textarea id="<?=$column["name"]?>" name="<?=$column["name"]?>" style="height: 130px;" class="form-control"></textarea>
              <?php } else if($column["type"] == "contents") {?>
                <textarea id="<?=$column["name"]?>" name="<?=$column["name"]?>" style="height: 300px;" class="summernote form-control"></textarea>
                <?php } else { ?>
                <input id="<?=$column["name"]?>" name="<?=$column["name"]?>" type="text" class="form-control" placeholder="<?=$column["description"]?>">
                <?php } ?>
              </div>
            </div>
        <?php } echo '</div>'; } ?>
        </form>
      </div>
      <div class="modal-footer">
        <button id="add-category" type="button" class="btn btn-primary  btn-cons">Save</button>
        <button type="button" class="btn btn-cons" data-dismiss="modal">Cancel</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

        <div class="m-grid__item m-grid__item--fluid m-wrapper">
          <!-- BEGIN: Subheader -->
          <div class="m-subheader ">
            <div class="d-flex align-items-center">
              <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"><?=$dispCaption?></h3>
                <?php if(isset($categories_data)){ ?>
                <div class="pull-right pr-2" style="width: 250px;">
                  <select class="form-control m-select2" id="categories" name="categories" style="width: 100%;">
                    <option value="00"<?=(("" == $categoryIdx)?" selected":"")?>>ALL<?php if($root_count) echo " (".$root_count.")";?></option>
                    <?php foreach($categories_data as $category){ ?>
                    <option value="<?=$category->categoryIdx?>"<?=(($category->categoryIdx == $categoryIdx)?" selected":"")?>><?=$category->categoryName?></option>
                      <?php foreach($category->children as $category_item){ ?>
                    <option value="<?=$category_item->categoryIdx?>"<?=(($category_item->categoryIdx == $categoryIdx)?" selected":"")?>>&nbsp;&nbsp;&nbsp;<?=$category_item->categoryName?></option>
                      <?php }?>
                    <?php }?>
                  </select>
                </div>
                <?php } ?>
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
                      <?=$dispCaption?>
                    </h3>
                  </div>
                </div>
                <div class="m-portlet__head-tools">
                  <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                      <a href="#" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" id="show-modal">
                        <span>
                          <i class="la la-plus"></i>
                          <span>New record</span>
                        </span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="m-portlet__body">
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="tableWithDynamicRows">
                  <thead>
                    <tr>
                    <?php foreach($columns as $column_arr) {
                    foreach($column_arr as $column) {
                      if($column["type"] == "hidden") continue;
                      if($column["type"] == "textarea") continue;
                      if($column["type"] == "contents") continue;
                    ?>
                      <th><?=$column["caption"]?></th>
                    <?php } } ?>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach($rows as $row) {?>
                    <tr>
                    <?php foreach($columns as $column_arr) {
                    foreach($column_arr as $column) {
                      if($column["type"] == "hidden") continue;
                      if($column["type"] == "textarea") continue;
                      if($column["type"] == "contents") continue;
                      $column_name = $column["name"];
                    ?>
                      <td><?=$row->$column_name?></td>
                    <?php } } ?>
                      <td nowrap><?=$row->$pri_fld?></td>
                    </tr>
                  <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
          </div>
          <input type="file" id="upload_attach" accept=".gif,.jpg,.jpeg,.png" style="display: none;">
        </div>