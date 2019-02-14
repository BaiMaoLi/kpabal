<div class="modal fade" id="editStatusAppModal" tabindex="-1" role="dialog" aria-labelledby="editStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editStatusModalLabel">Edit Member Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-bottom: 5px;">
        <form role="form" id="member_status_form" name="member_status_form">
          <input type="hidden" id="memberIdx" name="memberIdx" value="">
          <div class="form-group form-group-default row">
            <label class="col-form-label col-sm-6">Member Status</label>
            <div class="col-sm-6">
              <select id="member_status" class="form-control">
                <option value="0">Pending</option>
                <option value="1">Normal</option>
                <option value="2">Prepared</option>
                <option value="3">Locked</option>
                <option value="4">Blocked</option>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="edit-member-status" type="button" class="btn btn-primary  btn-cons">Save</button>
        <button type="button" class="btn btn-cons" data-dismiss="modal">Cancel</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="resetPasswordAppModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="resetPasswordModalLabel">Reset Member Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-bottom: 5px;">
        <form role="form" id="member_password_form" name="member_password_form">
          <input type="hidden" id="reset-memberIdx" name="reset-memberIdx" value="">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group form-group-default">
                <label>New Password</label>
                <input type="password" name="new-password" id="new-password" class="form-control">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group form-group-default">
                <label>Re-enter New Password</label>
                <input type="password" name="new-password2" id="new-password2" class="form-control">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="reset-member-password" type="button" class="btn btn-primary  btn-cons">Reset</button>
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
                <h3 class="m-subheader__title m-subheader__title--separator">Member List</h3>
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
                  </div>
                </div>
                <div class="m-portlet__head-tools">
                  <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                      <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/members/add_new" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                          <i class="la la-cart-plus"></i>
                          <span>New Member</span>
                        </span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="m-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="member_table">
                  <thead>
                    <tr>
                      <th>User ID</th>
                      <th>Email Address</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>State</th>
                      <th>Phone</th>
                      <th>Reg.Date</th>
                      <th>Status</th>
                      <th>Type</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($members as $member) {?>                      
                    <tr>
                      <td><?=$member->user_id?></td>
                      <td><?=$member->user_email?></td>
                      <td><?=$member->first_name?></td>
                      <td><?=$member->last_name?></td>
                      <td><?=$member->stateCode?></td>
                      <td><?=$member->phone?></td>
                      <td><?=$member->regDate?></td>
                      <td><?=$member->member_status?></td>
                      <td><?=$member->is_admin?></td>
                      <td><?=$member->memberIdx?></td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
          </div>
        </div>