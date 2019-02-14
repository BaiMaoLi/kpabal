
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Update Category</h3>
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
                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/category" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                          <i class="la la-cart-plus"></i>
                          <span>Category List</span>
                        </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                <!--begin: Datatable -->
                <form method="post" action="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/update_category">
                    <input type="hidden" name="id" value="<?=$data[0]['id']?>" />
                    <table class="table table-striped- table-bordered table-hover table-checkable">
                        <tr><td>Parent:</td><td>
                                <select name="parent" class="form-control">
                                    <option value="0">Select Parent</option>
                                    <?php foreach($p_cats as $p_cat){ ?>
                                        <option value="<?=$p_cat['id']?>" <?php if($p_cat['id']==$data[0]['parent'])echo "selected"; ?>><?=$p_cat['name']?></option>
                                    <? } ?>
                                </select>
                            </td></tr>
                        <tr><td>Category:</td><td><input type="text" name="name" class="form-control" value="<?=$data[0]['name']?>" /></td></tr>
                    </table>
                    <p><button class="btn btn-primary">Update</button></p>
                </form>
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