<div class="m-grid__item m-grid__item--fluid m-wrapper">
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
<div class="d-flex align-items-center">
    <div class="mr-auto">
        <h3 class="m-subheader__title m-subheader__title--separator">Manage CMS</h3>
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
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <div style="font-size:11px; color:#060;">
                                <?php
                                if($this->session->flashdata('msg')):
                                ?>
                                <?php
                                // echo $this->session->flashdata('msg');
                                endif;
                                ?>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <form action="<?php echo base_url()."".ADMIN_PUBLIC_DIR."/pages_manage/update_cms/".$cms_id; ?>" method="post">
                            <table width="100%" border="0">
                                <tr>
                                    <td width="19%" align="right" valign="top"><strong>Content:</strong>&nbsp;</td>
                                    <td width="81%">
                                        <textarea class="summernote" cols="80" id="editor1" name="editor1" rows="10"><?php echo stripslashes($content);?></textarea>
                                        <script>
                                            // CKEDITOR.replace( 'editor1', {
                                            // fullPage: false,
                                            // allowedContent: true,
                                            // extraPlugins: 'wysiwygarea'
                                            // });
                                        </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="36" align="right" valign="top"><strong>Meta Title</strong></td>
                                    <td><input style="width:500px;" type="text" name="page_meta_title" id="page_meta_title" value="<?php echo $page_meta_title;?>"></td>
                                </tr>
                                <tr>
                                    <td height="37" align="right" valign="top"><strong>Meta Keywords</strong></td>
                                    <td><input style="width:500px;"  type="text" name="page_meta_keywords" id="page_meta_keywords" value="<?php echo $page_meta_keywords;?>"></td>
                                </tr>
                                <tr>
                                    <td height="172" align="right" valign="top"><strong>Meta Description</strong></td>
                                    <td><textarea cols="80" rows="10" name="page_meta_desc" id="page_meta_desc" ><?php echo $page_meta_desc;?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" valign="top">&nbsp;</td>
                                    <td><input type="hidden" name="cms_id" id="cms_id" value="<?php echo $cms_id;?>">
                                    <input type="submit" class="btn btn-primary" value="Submit" /></td>
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
<!--end::Portlet-->
</div>
</div>