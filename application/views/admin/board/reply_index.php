<div class="modal fade" id="replyArticleAppModal" tabindex="-1" role="dialog" aria-labelledby="replyArticleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="replyArticleModalLabel">Reply to Reply</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-top: 5px; padding-bottom: 5px;">
        <form role="form" id="reply_article_form" name="reply_article_form">
          <input type="hidden" id="articleIdx" name="articleIdx" value="<?=$articleIdx?>">
          <input type="hidden" id="parent_id" name="parent_id" value="">
          <div class="form-group form-group-default row">            
            <div class="col-sm-12">
              <label class="col-form-label">Reply Content</label>
              <textarea class="form-control" id="reply_content" name="reply_content" rows=4></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="save-reply-article" type="button" class="btn btn-primary  btn-cons">Reply</button>
        <button type="button" class="btn btn-cons" data-dismiss="modal">Cancel</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="updateArticleAppModal" tabindex="-1" role="dialog" aria-labelledby="updateArticleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateArticleModalLabel">Update Reply</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-top: 5px; padding-bottom: 5px;">
        <form role="form" id="update_article_form" name="update_article_form">
          <input type="hidden" name="articleIdx" value="<?=$articleIdx?>">
          <input type="hidden" id="id" name="id" value="">
          <div class="form-group form-group-default row">            
            <div class="col-sm-12">
              <label class="col-form-label">Reply Content</label>
              <textarea class="form-control" id="reply_content2" name="reply_content" rows=4></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="update-reply-article" type="button" class="btn btn-primary  btn-cons">Save</button>
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
                <h3 class="m-subheader__title m-subheader__title--separator">Article Replies List</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                  <li class="m-nav__item m-nav__item--home">
                    <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards" class="m-nav__link m-nav__link--icon">
                      <i class="m-nav__link-icon la la-home"></i>
                    </a>
                  </li>
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
                      Advanced Search
                    </h3>
                  </div>
                </div>
              </div>
              <div class="m-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="board_table">
                  <thead>
                    <tr>
                      <th>Reply</th>
                      <th>Registrant</th>
                      <th>Reg.Date</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($boards as $board) {?>                      
                    <tr>
                      <td><?=$board->reply_content?></td>
                      <td><?=$board->memberName?></td>
                      <td><?=$board->regDate?></td>
                      <td><?=$board->id?></td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
          </div>
        </div>