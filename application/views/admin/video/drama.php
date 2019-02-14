
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Drama</h3>
            </div>
        </div>
    </div>

    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">Drama list</h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/video/delete_all/drama" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                          <i class="fas fa-trash-alt"></i>
                          <span>Delete All</span>
                        </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable data_table ">


                    <thead>
                    <tr>
                        <th>Video Image</th>
                        <th>Title</th>
                        <th>Likes</th>
                        <th>Api Type</th>
                        <th>Video ID</th>
                        <th>Duration</th>
                        <th>Create Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($drama as $one) {?>
                        <tr>
                            <td style="width:150px;"><?php if($one['image']!=""){ ?><img src="<?=$one['image']?>" style="width:100%;" /><?php } ?></td>
                            <td><?=$one['title']?></td>
                            <td><?=$one['likes']?></td>
                            <td><?=$one['api_type']?></td>
                            <td><?=$one['video_id']?></td>
                            <td><?=$one['duration']?></td>
                            <td><?=$one['create_date']?></td>
                            
                            <td>
                             <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/video/edit_product/<?=$one['vc_id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                                    <i class="la la-edit"></i>
                                </a>
                                <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/video/edit_done/drama/<?=$one['vc_id']?>/" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Modify Done">
                                    <i class="far fa-check-circle"></i>
                                </a>  
                                <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/video/delete_product/drama/<?=$one['vc_id']?>" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill">
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
