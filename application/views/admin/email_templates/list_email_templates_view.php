<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Manage Email Templates</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/pages_manage" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">All Email Templates</h3>
                            </div>
                            <!-- /.box-header -->
                            <?php
                            if($this->session->flashdata('msg')):
                            ?>
                            <!-- <div style="color:#009933;font-size:12px;"><?php echo $this->session->flashdata('msg');?></div><br /> -->
                            <?php
                            endif;
                            ?>
                            
                            <div class="box-body table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Added Date</th>
                                            <th>Email Name</th>
                                            <th>Email Subject</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sect">
                                        <?php if($result) {
                                        foreach($result as $row) { ?>
                                        <tr id="row_<?php echo $row->ID;?>">    
                                            <td><?php echo date('d M, Y', strtotime($row->dated));?> </td>
                                            <td><?php echo $row->email_name;?></td>
                                            <td><?php echo $row->email_subject;?></td>
                                            <td>
                                                <a href="<?php echo base_url(ADMIN_PUBLIC_DIR.'/'.$page_name.'/preview/'.$row->ID);?>" target="_blank" class="btn btn-default btn-xs">Preview</a>
                                                
                                                <a href="<?php echo base_url(ADMIN_PUBLIC_DIR.'/'.$page_name.'/update/'.$row->ID);?>" class="btn btn-primary btn-xs">Edit</a>
                                                
                                            </td>
                                        </tr>
                                        <?php } }?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                        
                        <!-- /.box -->
                    </div>
                </div>
                <section class="content-header">
                
            </section>
        </div>
    </div>
    <!--end::Portlet-->
</div>
</div>