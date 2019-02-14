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
                <h3 class="m-subheader__title m-subheader__title--separator">Board Article List</h3>
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
                    <select id="categoryIdx" onchange='window.location.href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards/"+this.value'>
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
                      <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards/add_new" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                          <i class="la la-cart-plus"></i>
                          <span>New Article</span>
                        </span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="m-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="board_table">
                  <thead>
                    <tr>
                      <th>Title</th>                      
                      <th>Thumbnails</th>
                      <th>Category</th>
                      <th>Registrant</th>
                      <th>Reg.Date</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($boards as $board) {?>                      
                    <tr>
                      <td><?=$board->article_title?></td>
                      <td><?php if(file_exists(PROJECT_BOARD_DIR."/article_".$board->id.".jpg")) echo ROOTPATH.PROJECT_BOARD_DIR."/article_".$board->id.".jpg"; else echo ROOTPATH.PROJECT_BOARD_DIR."/default.jpg";?></td>
                      <td><?=$board->categoryName?></td>
                      <td><?=$board->memberName?></td>
                      <td><?=$board->regDate?></td>
                      <td><?=$board->id?></td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
            <input type="file" id="upload_attach" accept=".gif,.jpg,.jpeg,.png" style="display: none;">
            <!-- END EXAMPLE TABLE PORTLET-->
          </div>
        </div>