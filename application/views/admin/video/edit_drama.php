
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Video</h3>
            </div>
        </div>
    </div>

    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">Edit Drama</h3>
                    </div>
                </div>
                
            </div>
            <div class="m-portlet__body">

                <!--begin: Datatable -->
                <form method="post" action="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/video/update_drama" enctype="multipart/form-data">
                    <input type="hidden" name="video_id" value="<?=$video_info['scrap_id']?>" />
                    <table class="table table-striped- table-bordered table-hover table-checkable data_table">
                        <tbody>
                        <tr>
                            <td style="width: 150px;">Play</td>
                            <td align="center">
                                	<iframe width="420" height="345" src="<?=$video_info['scrap_url']?>"></iframe>
                            </td>
                        </tr>
                        <tr>
                            <td   style="width: 150px;">Sub links</td>
                            <td>
                                <select id="select_id" name="sublink" class="form-control">
                                    <?php
                                    foreach($sub_links as $sub){
                                        if($sub['scrap_id'] == $video_info['scrap_id']) $selected = " selected";
                                        else $selected = "";
                                    ?>
                                    <option value = "<?=$sub['scrap_id'];?>" <?=$selected?>><?=$sub['scrap_sub_link']?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;"> Title</td><td><input type="text" name="title" class="form-control" value="<?=$video_info['scrap_title']?>" required /> </td>
                        </tr>
                        
                        </tbody>
                    </table>
                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#select_id').change(function(){
           id = $('#select_id').val();
           //console.log(id);
            window.location = "<?=base_url()."admin_video/edit_drama/"?>" +id;
               
        });
    });

</script>