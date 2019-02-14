<!-- Page Title
		============================================= -->
<!-- Content
============================================= -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    .modal{
        background: rgba(255,255,255,0.5);
        z-index: 10;
    }
    .modal-dialog{
        top: 25vh;
    }
    #change_view_menu:hover{
        cursor: pointer;
    }
</style>
<div id="myModal" class="modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Details:</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-5">
                        <img src="">
                    </div>
                    <div class="col-sm-7">
                        <h4 style="margin: 0;"></h4>
                        <p style="margin: 0;"></p>
                        <button type="button" class="btn btn-primary">Add List</button>
                    </div>
                </div>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-default close" data-dismiss="modal">Close</button>
            </div>-->
        </div>

    </div>
</div>
<section id="content">
    <div class="content-wrap" style="padding-top: 10px;">
        <div class="container clearfix">
            <!-- Post Content
            ============================================= -->
            <div class="row">
                <div class="col-sm-3">
                    <h4>Weekly Circular</h4>
                </div>
                <div class="col-sm-6">
                </div>
                <div class="col-sm-3">
                    <div id="change_view_menu">
                        <i aria-hidden="true" class="material-icons" style="font-size: 35px;">view_module</i>
                        <div style="display: inline-block;">
                            <h4 style="margin: 0;">
                                Page View
                            </h4>
                            <p style="line-height: 1;margin: 0;">View by pages</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3" style="border-right: 1px solid #ccc;">
                    <h3 style="margin-bottom: 10px;">View by Category</h3>
                    <p style="margin: 0;"><a href="<?=ROOTPATH?>savings/page">All Categories</a></p>
                    <?php
                    foreach ($categories as $category) {
                        ?>
                        <p style="margin: 0;"><a href="<?=ROOTPATH?>savings/page/<?=$category['id']?>"><?=$category['title']?></a></p>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-sm-9">
                    <p style="margin: 0;">Weekly Circular</p>
                    <h2>All Categories</h2>
                    <div class="row">
                    <?php
                    foreach ($products as $product) {
                        ?>
                        <div class="col-sm-3" style="border: 1px solid #ccc; padding: 10px 0;">
                            <div style="width: 100%;height:180px;text-align: center;">
                                <img src="<?=ROOTPATH?><?=$product['logo']?>" style="max-width: 100%;max-height: 100%;" />
                            </div>
                            <!--<div style="height: 80px;overflow: auto">
                                <h4 style="text-align: center;margin: 0;"><?=$product['price']?></h4>
                                <div style="text-align: center;"><?=$product['title']?></div>
                            </div>-->
                            <div style="text-align: center;margin-top: 15px;">
                                <button type="button" class="btn btn-primary btn_details">View Details</button>
                                <input type="hidden" class="ptitle" value="<?=$product['title']?>" />
                                <input type="hidden" class="plogo" value="<?=ROOTPATH?><?=$product['logo']?>" />
                                <input type="hidden" class="pprice" value="<?=$product['price']?>" />
                                <input type="hidden" class="pdescription" value="<?=$product['description']?>" />
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- #content end -->