
<div class="m-grid__item m-grid__item--fluid m-wrapper">

<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"><?php echo !isset($comment)?'Add Comment':'Edit Comment';?></h3>
        </div>
    </div>
</div>

<!-- END: Subheader -->
<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            <!--begin: Datatable -->
            <form method="post" action="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/<?php echo !isset($comment)?'insert_talky_comment':'update_talky_comment/'.$comment[0]['id'];?>" enctype="multipart/form-data">
                <input type="hidden" name="talkyId" value="<?=$talkyId?>"/>
                <table class="table table-striped- table-bordered table-hover table-checkable data_table">
                    <tbody>
                        <tr>
                            <td style="width: 150px;">Customer</td>
                            <td>
                                <select name="customer" class="form-control">
                                    <?php
                                    foreach ($customers as $customer) {
                                        ?>
                                        <option value="<?=$customer['memberIdx']?>" <?php if((isset($comment)) && ($comment[0]['customer_id'] == $customer['memberIdx'])) echo " selected";?>><?=$customer['user_id']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;">Comment Title</td>
                            <td><input type="text" name="talky_comment_title" class="form-control" required value="<?php echo isset($comment)?$comment[0]['comment_title']:'';?>"/></td>
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