
<link rel="stylesheet" href="<?=ROOTPATH?>assets/css/magicsuggest.css">
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">New Talky</h3>
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
                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                          <i class="la la-cart-plus"></i>
                          <span>Talky List</span>
                        </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                <!--begin: Datatable -->
                <form method="post" action="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/insert_talky" enctype="multipart/form-data">
                    <!--                    <input type="hidden" name="id" value="--><?//=$data[0]['id']?><!--" />-->
                    <table class="table table-striped- table-bordered table-hover table-checkable">
                        <tr>
                            <td>Title</td>
                            <td><input type="text" name="title" maxlength="50" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Contents</td>
                            <td><textarea maxlength="1000" id="content_post" name="content" class="form-control"></textarea></td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>
                                <select name="category" class="form-control">
                                    <option></option>
                                    <?php
                                    foreach($cats as $cat){
                                        ?>
                                        <option value="<?=$cat['id']?>"><?=$cat['name']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Tags</td>
                            <td><div id="ms1" class="form-control"></div></td>
                        </tr>
                        <tr>
                            <td>Photo</td>
                            <td><input type="file" id="talky_photo" class="talky_photo" name="talky_photo" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Video</td>
                            <td><input type="file" id="talky_video" class="talky_video" name="talky_video" class="form-control"></td>
                        </tr>
                    </table>
                    <p><button class="btn btn-primary">Update</button></p>
                </form>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<div id="tags_name" style="display: none;"><?php echo json_encode($tags_name); ?></div>
