<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
<style>
    select,input[type=file]{
        max-width:200px;
        display: inline-block !important;
    }
    tr td:nth-child(1),tr td:nth-child(3){
        /*background: #eee;*/
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Talky</h3>
            </div>
        </div>
    </div>

    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-subheader__title m-subheader__title--separator">Edit Tag</h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/tags/" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                          <i class="la la-cart-plus"></i>
                          <span>Tag List</span>
                        </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                <!--begin: Datatable -->
                <form method="post" action="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/talky/insert_tag" enctype="multipart/form-data">
                    <input type="text" name="title" placeholder="Title" class="form-control" value="<?=$tags[0]['title']?>" required />
                    <input type="hidden" name="id" value="<?=$tags[0]['id']?>" />
                    <p>&nbsp;</p>
                    <table class="table table-striped- table-bordered table-hover table-checkable">
                        <?php
                        $logo=$tags[0]['logo'];
                        if($logo==""){
                            $logo=ROOTPATH.'assets/company_logos/logo.jpg';
                        }else{
                            $logo=ROOTPATH.$logo;
                        }
                        ?>
                        <tr>
                            <td>Logo:</td><td ><input type="file" id="housing_logo" name="logo" class="form-control" accept="image/*" /><br /><img src="<?=$logo?>" id="img_logo" width="200px" /></td>
                            <td>Show/Hide:</td><td ><span class="m-switch" style="display: block;"><label>
                                        <input type="checkbox" <?php if($logo=$tags[0]['active']=="on")echo 'checked="checked"'; ?> class="form-control" id="isDisplay" name="isDisplay">
                                        <span></span> </label> </span>
                            </td>
                        </tr>

                    </table>
                    <p>&nbsp;</p>
                    <p><button class="btn btn-primary">Update</button></p>
                </form>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#careers_occupation1").change(function(){
            $.ajax({
                url: "./ajax_cat",
                type: "post",
                data:{"id":$("#careers_occupation1").val()},
                success: function(result){
                    $("#careers_occupation2").html(result);
                }
            });
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#img_logo").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#housing_logo").change(function(){
            readURL(this);
        });
    });

    function initAutocomplete() {
        autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('autocomplete')),{types: ['geocode']});
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=$key?>&libraries=places&callback=initAutocomplete" async defer></script>
