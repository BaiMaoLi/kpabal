
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Tag List</h3>
            </div>
        </div>
    </div>

    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">

                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/post_tag" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                          <i class="la la-cart-plus"></i>
                          <span>New Tag</span>
                        </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable job_table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Show</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($tags as $tag){ ?>
                        <tr>
                            <td><?=$tag['title']?></td>
                            <td><?=$tag['active']?></td>
                            <td>
                                <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/edit_tag/<?=$tag['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                                    <i class="la la-edit"></i>
                                </a>
                                <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/delete_tag/<?=$tag['id']?>" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill">
                                    <i class="la la-remove" title="Remove Record"></i>
                                </a></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#careers_occupation1").change(function(){
            if($(this).val()>0){
                $.ajax({
                    url: "<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/ajax_cat",
                    type: "post",
                    data:{"id":$("#careers_occupation1").val()},
                    success: function(result){
                        $("#careers_occupation2").html('<option value="0">전체</option>'+result);
                    }
                });
            }else{
                $("#careers_occupation2").html('<option value="0">전체</option>');
            }
        });
    });
</script>