
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Savings</h3>
            </div>
        </div>
    </div>

    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">New Store</h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/savings/stores" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                          <i class="la la-cart-plus"></i>
                          <span>Stores list</span>
                        </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                <!--begin: Datatable -->
                <form method="post" action="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/savings/insert_store">
                <table class="table table-striped- table-bordered table-hover table-checkable data_table">
                    <tbody>
                    <tr>
                        <td style="width: 150px;">Title</td><td><input type="text" name="title" class="form-control" required /> </td>
                    </tr>
                    <tr>
                        <td>Address</td><td colspan="3"><input type="text" name="address" class="form-control" /></td>
                    </tr>
                    <tr>
                        <td>Zipcod</td><td colspan="3"><input type="text" name="zipcode" class="form-control" required /></td>
                    </tr><tr>
                        <td style="width: 150px;">Logo</td><td>
                            <input type="file" name="store_logo" id="store_logo" class="form-control" accept="image/*" style="max-width: 300px;" />
                            <img src="<?=ROOTPATH ?>assets/company_logos/logo.jpg" id="img_logo" width="200px"/>
                        </td>
                        <td style="width: 150px;">Image</td><td>

                            <input type="file" name="store_img" id="store_img" class="form-control" accept="image/*" style="max-width: 300px;" />
                            <img src="<?=ROOTPATH ?>assets/company_logos/logo.jpg" id="img_store" width="200px"/>
                        </td>
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
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#img_logo").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#store_logo").change(function(){
            readURL(this);
        });
        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#img_store").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#store_img").change(function(){
            readURL1(this);
        });
    });
</script>