<!-- MODAL STICK UP  -->
<div class="modal fade" id="addNewAppModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?=$dispCaption?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-bottom: 5px;">        
        <form role="form" id="category_form" name="category_form">
          <input type="hidden" id="parentIdx" name="parentIdx" value="<?=$parentIdx?>">
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
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                  <li class="m-nav__item m-nav__item--home">
                    <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/category/<?=$tbl_name?>" class="m-nav__link m-nav__link--icon">
                      <i class="m-nav__link-icon la la-home"></i>
                    </a>
                  </li>
                  <?php foreach ($additional_caption as $menu_item) {?>
                  <li class="m-nav__separator">-</li>
                  <li class="m-nav__item">
                    <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/category/<?=$tbl_name?>/<?=$menu_item->$pri_fld?>" class="m-nav__link">
                      <span class="m-nav__link-text"><?=$menu_item->$dispCaption_fld?></span>
                    </a>
                  </li>
                  <?php }?>
                </ul>
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
        </div>