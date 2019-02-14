
        <div class="m-grid__item m-grid__item--fluid m-wrapper">

<!-- BEGIN: Subheader -->
<div class="m-subheader ">
  <div class="d-flex align-items-center">
    <div class="mr-auto">
      <h3 class="m-subheader__title m-subheader__title--separator">Comment List</h3>
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
             Talky Comment
          </h3>
        </div>
      </div>
      <div class="m-portlet__head-tools">
        <ul class="m-portlet__nav">
          <li class="m-portlet__nav-item">
            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/add_talky_comment/<?=$talkyId;?>" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
              <span>
                <i class="la la-plus"></i>
                <span>New Talky Comment</span>
              </span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="m-portlet__body">
      <!--begin: Datatable -->
      <table class="table table-striped- table-bordered table-hover table-checkable" id="talky_comment_table">
        <thead>
          <tr>
            <th>Comment ID</th>
            <th>Title</th>
            <th>Customer</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($comments as $comment) {?>                      
          <tr>
              <td><?=$comment['id'];?></td>
              <td><?=$comment['comment_title']?></td>
              <td><?=$comment['user_id']?></td>
              <td>
                  <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/edit_talky_comment/<?=$comment['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                      <i class="la la-edit"></i>
                  </a>
                  <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/delete_talky_comment/<?=$comment['id']?>" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill">
                      <i class="la la-remove" title="Remove Record"></i>
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