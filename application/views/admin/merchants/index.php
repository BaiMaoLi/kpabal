<div class="modal fade" id="toggleSelectionAppModal" tabindex="-1" role="dialog" aria-labelledby="toggleSelectionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="toggleSelectionModalLabel">Toggle Selection</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-bottom: 5px;">
        <form role="form" id="toggle_selection_form" name="toggle_selection_form">
          <input type="hidden" id="merchantID1" name="merchantID1" value="">
          <div class="row"> <div class="col-sm-6"> <div class="form-group form-group-default"> <label>On / Off</label> <span class="m-switch" style="display: block;"> <label> <input type="checkbox" checked="checked" class="form-control" id="is_display" name="is_display"> <span></span> </label> </span> </div> </div> <div class="col-sm-6"> <div class="form-group form-group-default"> <label>Sort #</label> <input id="orderNum" name="orderNum" type="text" class="form-control" placeholder="Sort Order Number"> </div> </div> </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="toggle-selection" type="button" class="btn btn-primary  btn-cons">Save</button>
        <button type="button" class="btn btn-cons" data-dismiss="modal">Cancel</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="cashbackAppModal" tabindex="-1" role="dialog" aria-labelledby="cashbackModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cashbackModalLabel">Cash Back</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-bottom: 5px;">
        <form role="form" id="cashback_form" name="cashback_form">
          <input type="hidden" id="merchantID2" name="merchantID2" value="">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group form-group-default">
                <label>Cash Back (%)</label>
                <input type="text" name="cashback" id="cashback" class="form-control">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="cashback-update" type="button" class="btn btn-primary  btn-cons">Save</button>
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
                <h3 class="m-subheader__title m-subheader__title--separator">Merchant List</h3>
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
                      Selection Page
                    </h3>
                    &nbsp;&nbsp;&nbsp;
                    <select id="categoryIdx" onchange='window.location.href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/merchants/"+this.value'>
                      <?php foreach($categories as $key => $category) { ?>
                      <option value="<?=$key?>"<?php if($categoryIdx == $key) echo " selected";?>><?=$category?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="m-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="merchants_table">
                  <thead>
                    <tr>
                      <th>Merchant Name</th>
                      <th>Merchant ID</th>
                      <th>Logo</th>
                      <th>CashBack</th>
                      <th>Selection</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
          </div>
        </div>