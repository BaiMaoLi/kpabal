
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
                        <h3 class="m-portlet__head-text">Product list</h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/savings/new_product" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                          <i class="la la-cart-plus"></i>
                          <span>New Product</span>
                        </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable data_table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Title</th>
                        <th>Store</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($products as $product) {?>
                        <tr>
                            <td style="width:150px;"><?php if($product['logo']!=""){ ?><img src="<?=ROOTPATH?><?=$product['logo']?>" style="width:100%;" /><?php } ?></td>
                            <td><?=$product['title']?></td>
                            <td><?=$product['store_title']?></td>
                            <td><?=$product['category_title']?></td>
                            <td><?=$product['price']?></td>
                            <td><?=$product['description']?></td>
                            <td>
                                <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/savings/edit_product/<?=$product['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                                    <i class="la la-edit"></i>
                                </a>
                                <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/savings/delete_product/<?=$product['id']?>" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill">
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
