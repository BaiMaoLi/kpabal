
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
                        <h3 class="m-portlet__head-text">Edit Product</h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/savings/products" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                          <i class="la la-cart-plus"></i>
                          <span>Product list</span>
                        </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                <!--begin: Datatable -->
                <form method="post" action="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/savings/update_product" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?=$products[0]['id']?>" />
                    <table class="table table-striped- table-bordered table-hover table-checkable data_table">
                        <tbody>
                        <tr>
                            <td style="width: 150px;">Store</td>
                            <td>
                                <select name="store" class="form-control">
                                    <?php
                                    foreach ($stores as $store) {
                                        ?>
                                        <option value="<?=$store['id']?>" <?php if($store['id']==$products[0]['store'])echo "selected"?>><?=$store['title']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;">Category</td>
                            <td>
                                <select name="category" class="form-control">
                                    <?php
                                    foreach ($categories as $category) {
                                        ?>
                                        <option value="<?=$category['id']?>" <?php if($category['id']==$products[0]['category'])echo "selected"?>><?=$category['title']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;">Title</td><td><input type="text" name="title" class="form-control" value="<?=$products[0]['title']?>" required /> </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;">Logo</td>
                            <td>
                                <input type="file" name="product_logo" id="product_logo" class="form-control" accept="image/*" style="max-width: 300px;" />
                                <?php
                                if($products[0]['logo']==""){
                                    ?>
                                    <img src="<?=ROOTPATH ?>assets/company_logos/logo.jpg" id="img_logo" width="200px"/>
                                    <?php
                                }else{
                                    ?>
                                    <img src="<?=ROOTPATH ?><?=$products[0]['logo']?>" id="img_logo" width="200px"/>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;">Price</td><td><input type="text" name="price" class="form-control" value="<?=$products[0]['price']?>" required /> </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;">Description</td><td><textarea name="description" class="form-control" rows="10"><?=$products[0]['description']?></textarea> </td>
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
        $("#product_logo").change(function(){
            readURL(this);
        });
    });
</script>