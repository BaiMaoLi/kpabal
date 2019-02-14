<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Profile Management</h3>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__body">
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Search By Name</h3>
                                </div>
                                <!-- /.box-header -->
                                <form action="<?php echo base_url(). ADMIN_PUBLIC_DIR .'/search_profile_name/result_name';?>" method="post">
                                    <table width="500" border="0" align="center">
                                        <tr>
                                            <td width="132">Search By Name:</td>
                                            <td width="358"><input type="text" name="search" id="search" placeholder="Enter ..." class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><button type="submit" class="btn btn-primary">Submit</button></td>
                                        </tr>
                                    </table>
                                </form>

                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->

                            <!-- /.box -->
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>