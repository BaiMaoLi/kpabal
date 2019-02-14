<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Ads</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/ads" class="m-nav__link m-nav__link--icon">
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
                <div class="col-xs-12">
                    <div class="box">
                        <!-- <div class="box-header">
                            <div style="font-size:11px; color:#060;">
                                <?php
                                if($this->session->flashdata('msg')):
                                ?>
                                <?php
                                echo $this->session->flashdata('msg');
                                endif;
                                ?>
                            </div>
                        </div> -->
                        <!-- /.box-header -->
                        <form action="<?php echo base_url()?><?=ADMIN_PUBLIC_DIR?>/ads/update_data/" method="post">
                            <table width="100%" border="0">
                                <tr>
                                    <td width="19%" align="right" valign="top"><strong>Ads:</strong>&nbsp;</td>
                                    <td width="81%"><textarea cols="80" id="content" name="content" rows="20"><?php echo stripslashes($content);?></textarea></td>
                                </tr>
                                <tr>
                                    <td align="right" valign="top">&nbsp;</td>
                                    <td><input type="submit" value="Submit" /></td>
                                </tr>
                            </table>
                        </form>
                        
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    
                    <!-- /.box -->
                </div>
            </div>
        </div>
        <!--end::Portlet-->
    </div>
</div>