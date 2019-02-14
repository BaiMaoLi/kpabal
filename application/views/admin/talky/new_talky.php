
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"><?php echo !isset($talky)?'Add Talky':'Edit Talky';?></h3>
            </div>
        </div>
    </div>

    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <!--begin: Datatable -->
                <form method="post" action="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/<?php echo !isset($talky)?'insert_talky':'update_talky/'.$talky[0]['idx'];?>" enctype="multipart/form-data">
                    <table class="table table-striped- table-bordered table-hover table-checkable data_table">
                        <tbody>
                            <tr>
                                <td style="width: 150px;">Customer</td>
                                <td>
                                    <select name="customer" class="form-control">
                                        <?php
                                        foreach ($customers as $customer) {
                                            ?>
                                            <option value="<?=$customer['memberIdx']?>" <?php if((isset($talky)) && ($talky[0]['customer_id'] == $customer['memberIdx'])) echo " selected";?>><?=$customer['user_id']?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 150px;">Talky Title</td>
                                <td><input type="text" name="talky_title" class="form-control" required value="<?php echo isset($talky)?$talky[0]['talky_title']:'';?>"/></td>
                            </tr>
                            <tr>
                                <td style="width: 150px;">Talky Descriptions</td>
                                <td>
                                <textarea name="talky_desc" rows="4" cols="50"><?php echo isset($talky)?$talky[0]['talky_desc']:'';?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 150px;">Talky Image</td>
                                <td>
                                    <input type="file" name="talky_logo" id="talky_logo" class="form-control" accept="image/*" style="max-width: 300px;" />
                                    <img src="<?php echo isset($talky)? ROOTPATH.$talky[0]['post_img']: '';?>" id="img_logo" width="200px" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#img_logo").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#talky_logo").change(function(){
            readURL(this);
        });
    });
</script>