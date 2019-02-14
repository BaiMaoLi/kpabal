<div class="modal fade" id="replyArticleAppModal" tabindex="-1" role="dialog" aria-labelledby="replyArticleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="replyArticleModalLabel">Reply</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-top: 5px; padding-bottom: 5px;">
        <form role="form" id="reply_article_form" name="reply_article_form">
          <input type="hidden" id="articleIdx" name="articleIdx" value="">
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
        <div class="m-grid__item m-grid__item--fluid m-wrapper">

          <!-- BEGIN: Subheader -->
          <div class="m-subheader ">
            <div class="d-flex align-items-center">
              <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Points</h3>
              </div>
            </div>
          </div>

          <!-- END: Subheader -->
          <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
              <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                      <form method="post" action="<?=site_url()?>adminpanel/point/save">
                  <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                      Write:
                    </h3>
                    &nbsp;&nbsp;&nbsp;
                    <input type="number" name="write" class="form-control" value="<?=$points[0]->write?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <h3 class="m-portlet__head-text">
                      Comment:
                    </h3>
                    &nbsp;&nbsp;&nbsp;
                    <input type="number" name="comment" class="form-control" value="<?=$points[0]->comment?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <h3 class="m-portlet__head-text">
                      Reply:
                    </h3>
                    &nbsp;&nbsp;&nbsp;
                    <input type="number" name="reply" class="form-control" value="<?=$points[0]->reply?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-primary btn-cons">Save</button>
                  </div>
                    </form>
                </div>
                <div class="m-portlet__head-tools">
                </div>
              </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
          </div>
        </div>