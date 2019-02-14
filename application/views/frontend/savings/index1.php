<!-- Page Title
		============================================= -->
<!-- Content
============================================= -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    .modal{
        background: rgba(255,255,255,0.5);
        z-index: 999;
    }
    .modal-dialog{
        top: 25vh;
    }
    #change_store_menu:hover, #change_category_menu:hover, #change_view_menu:hover, .zoom:hover{
        cursor: pointer;
    }
    .item {
        float: left;
        width:20%;
        padding: 5px 0px;
        overflow: hidden;
        position: relative;
    }
    #produce1{
        margin: 0; font-size: 5.5em; color: #fff; font-style: italic;font-weight: bold; line-height: normal !important;
    }
    #produce2{
        margin: 10px 0; font-style: italic; font-size: 2.5em; border-top: 1px solid #fff; border-bottom: 1px solid #fff; color: #fff; text-align: center;font-family: -webkit-pictograph;
    }
    .zoom{
        display: none;
    }
    #meet{
        text-align: center;
        margin-bottom:  20px;
        position: absolute;
        width: 100%;
        z-index: 9;
        top: 40px;
    }
    @media (max-width: 1199px){
        #produce1{
            font-size: 5em;
        }
        #produce2{
            line-height: 1.5;
        }
    }
    @media (max-width: 991px){
        #produce1{
            font-size: 4em;
        }
        #produce2{
            line-height: 1.5;
        }
    }
    @media (max-width: 767px){
        .item {
            width:50% !important;
        }
        #produce1{
            font-size: 3em;
        }
        #produce2{
            line-height: 1.5;
        }
        #meet{
            position: relative;
            top: 15px;
        }
    }
    @media (max-width: 480px){
        .item {
            width:100% !important;
        }
        #produce1{
            font-size: 4em;
        }
        #produce2{
            line-height: 1.5;
        }
    }
    .item img{
        width: 98%;
        max-width: unset;
        border: 1px solid #ccc;
    }
    .products{
        width:100%;
    }
    .mmodal{
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        text-align: center;
        margin: 5px 0px;
        z-index: 10;
    }
    .mmodal div{
        display: none;
    }
    .mmodal:hover{
        cursor: pointer;
    }
    .mmodal:hover div{
        display: block;
    }
    .product_container{
        min-height:50vh;
        overflow: auto;
    }
</style>
<?php
if($selectedStore<1 || $searchStore==1){
    ?>
<style>
    #myModal{
        display: block;
    }
</style>
<?php
}
?>
<div id="myModal" class="modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Enter ZIP code:</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" action="" >
                <div class="input-group divcenter">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="material-icons">place</i>
                        </div>
                    </div>
                    <input type="text" id="widget-subscribe-form-email" name="postal_code" class="form-control" placeholder="">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit">Search</button>
                    </div>
                </div>
                </form>
                <p>We use your ZIP code to find the circular for a store near you.</p>
                <?php
                //if($selectedStore>0) {
                    if (count($modal) > 0) {
                        ?>
                        <!--<p><b>PICK A STORE TO VIEW THE CIRCULAR:</b></p>-->
                        <table class="table">
                            <tbody>
                            <?php
                            foreach ($modal as $mo) {
                                ?>
                                <tr>
                                    <td><?= $mo['title'] ?><br><?= $mo['address'] ?></td>
                                    <td><?= $mo['distance'] ?> mile</td>
                                    <td>
                                        <?php
                                        if ($selectedStore == $mo['id']) {
                                            echo "Selected";
                                        } else {
                                            ?>
                                            <a href="<?= ROOTPATH ?>savings/selectedStore/<?= $mo['id'] ?>">
                                                <button class="btn btn-default" type="button" tabindex="0">Select
                                                </button>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }else{
                        echo '<p style="text-align: center;">There is no Stores</p>';
                    }
                //}
                ?>

            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-default close" data-dismiss="modal">Close</button>
            </div>-->
        </div>

    </div>
</div>
<div id="myModal1" class="modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Details:</h4>
                <button type="button" class="close close1" data-dismiss="modal">&times;</button>
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
                    <h3>Weekly Circular</h3>
                </div>
                <div class="col-sm-3">
                    <div id="change_store_menu">
                        <i aria-hidden="true" class="material-icons" style="font-size: 35px;">place</i>
                        <div style="display: inline-block;">
                            <h4 style="margin: 0;">
                                My Store
                            </h4>
                            <?php
                            if($selectedStore>0){
                                ?>
                                <p style="line-height: 1;margin: 0;">
                                    <?=$selectedStoreData[0]['title'];?>
                                </p>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    if($selectedStore>0){
                        ?>
                        <div id="my_store_content" style="border: 1px solid #ccc; padding: 10px;position: absolute;display: none; min-width: 200px;z-index: 9;background: #fff;">
                            <p style="margin: 0;"><?=$selectedStoreData[0]['title'];?></p>
                            <p style="margin: 0;"><?=$selectedStoreData[0]['address'];?></p>
                            <p style="margin: 0;text-align: center;"><button type="button" id="change_store" class="btn btn-primary">Change Local Store</button> </p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-sm-3">
                    <div id="change_category_menu">
                        <i aria-hidden="true" class="material-icons" style="font-size: 35px;">view_headline</i>
                        <div style="display: inline-block;">
                            <h4 style="margin: 0;">
                                Category
                            </h4>
                            <p style="line-height: 1;margin: 0;">Shop by Category</p>
                        </div>
                    </div>
                    <div id="my_category_content" style="border: 1px solid #ccc; padding: 10px;position: absolute;display: none; min-width: 200px;z-index: 9;background: #fff;">
                        <?php
                        foreach ($categories as $category) {
                            ?>
                            <p style="margin: 0;"><a href="<?= ROOTPATH ?>savings/#cat_<?= $category['id']; ?>" class="cat_menu"><?= $category['title']; ?></a></p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div id="change_view_menu">
                        <i aria-hidden="true" class="material-icons" style="font-size: 35px;">view_module</i>
                        <div style="display: inline-block;">
                            <h4 style="margin: 0;">
                                Grid View
                            </h4>
                            <p style="line-height: 1;margin: 0;">View Ad Content</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-6">
                <i aria-hidden="true" class="zoom material-icons zoom-m">remove_circle</i>
                <i aria-hidden="true" class="zoom material-icons zoom-p">add_circle</i>
            </div>
            <div class="col-6 col-sm-6" style="text-align: right;">
                <a href="<?= ROOTPATH ?>savings/pdf" target="_blank"><button type="button" class="btn" style="padding: 3px 10px; font-size: 12px;">PDF/PRINT</button></a>
            </div>
        </div>
        <div class="container clearfix">
            <div class="row product_container">
                <?php
                $products=array();
                foreach ($categories as $category) {
                    foreach ($categoryData[$category['id']] as $data) {
                        array_push($products,$data);
                    }
                }
                ?>
                <div id="cat2" class="col-sm-12" style="background: #91d5d6;">
                    <img src="<?=ROOTPATH?>assets/jjmarket/01.jpg" style="width: 100%;" />
                    <div class="row" style="padding: 15px;">
                        <div class="col-sm-12" style="background: url(<?=ROOTPATH?>assets/jjmarket/wood.jpg); background-size:cover; padding: 10px;">
                            <div id="meet"><img src="<?=ROOTPATH?>assets/jjmarket/meet.png" style="width: 380px;max-width:100%;"></div>
                        <div class="item" style="width: 40%;margin-top:10px;">
                            <img src="<?= ROOTPATH ?><?=$products[0]['logo'] ?>"/>
                            <div class="mmodal">
                                <div style="position: absolute;bottom: 30px; text-align: center;  width: 100%;">
                                    <button type="button" class="btn btn-primary">Add list</button>
                                    <button type="button" class="btn btn-primary btn_details">Details</button>
                                    <input type="hidden" class="ptitle" value="<?=$products[0]['title']?>" />
                                    <input type="hidden" class="plogo" value="<?=ROOTPATH?><?=$products[0]['logo']?>" />
                                    <input type="hidden" class="pprice" value="<?=$products[0]['price']?>" />
                                    <input type="hidden" class="pdescription" value="<?=$products[0]['description']?>" />
                                </div>
                            </div>
                        </div>
                        <div class="item">
                        </div>
                        <?php
                        for($i=1;$i<=5;$i++) {
                            ?>
                            <div class="item">
                                <img src="<?= ROOTPATH ?><?= $products[$i]['logo'] ?>"/>
                                <div class="mmodal">
                                    <div style="position: absolute;bottom: 30px; text-align: center;  width: 100%;">
                                        <button type="button" class="btn btn-primary">Add list</button>
                                        <button type="button" class="btn btn-primary btn_details">Details</button>
                                        <input type="hidden" class="ptitle" value="<?= $products[$i]['title'] ?>"/>
                                        <input type="hidden" class="plogo"
                                               value="<?= ROOTPATH ?><?= $products[$i]['logo'] ?>"/>
                                        <input type="hidden" class="pprice" value="<?= $products[$i]['price'] ?>"/>
                                        <input type="hidden" class="pdescription"
                                               value="<?= $products[$i]['description'] ?>"/>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        </div>
                    </div>
                </div>
                <div id="cat3" class="col-sm-12">
                    <div class="row" style="padding: 15px;background: url(<?=ROOTPATH?>assets/jjmarket/04.jpg); background-size:cover;">
                    <div class="col-sm-12" style="border: 5px solid #c69c6e; border-radius: 10px;padding: 10px;">

                        <div class="row">
                            <div class="col-sm-5">
                                <p id="produce1">PRODUCE</p>
                            </div>
                            <div class="col-sm-7">
                                <p id="produce2">We provide the freshest produce!</p>
                            </div>
                        </div>
                    <?php
                    for($i=6;$i<=10;$i++) {
                        ?>
                        <div class="item">
                            <img src="<?= ROOTPATH ?><?= $products[$i]['logo'] ?>"/>
                            <div class="mmodal">
                                <div style="position: absolute;bottom: 30px; text-align: center;  width: 100%;">
                                    <button type="button" class="btn btn-primary">Add list</button>
                                    <button type="button" class="btn btn-primary btn_details">Details</button>
                                    <input type="hidden" class="ptitle" value="<?= $products[$i]['title'] ?>"/>
                                    <input type="hidden" class="plogo"
                                           value="<?= ROOTPATH ?><?= $products[$i]['logo'] ?>"/>
                                    <input type="hidden" class="pprice" value="<?= $products[$i]['price'] ?>"/>
                                    <input type="hidden" class="pdescription"
                                           value="<?= $products[$i]['description'] ?>"/>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                    </div>
                </div>
                <div id="cat4" class="col-sm-12" style="background: #f7de08;">
                    <div class="row" style="padding: 15px;">
                        <div class="col-sm-12" style="padding: 0px; border:3px solid #000;">
                            <div class="item" style="width: 41%;margin:-20px 3px 0 -15px;">
                                <img src="<?=ROOTPATH?>assets/jjmarket/03.jpg" style="width: 100%;" />
                            </div>
                            <?php
                            for($i=11;$i<=21;$i++) {
                                ?>
                                <div class="item">
                                    <img src="<?= ROOTPATH ?><?= $products[$i]['logo'] ?>"/>
                                    <div class="mmodal">
                                        <div style="position: absolute;bottom: 30px; text-align: center;  width: 100%;">
                                            <button type="button" class="btn btn-primary">Add list</button>
                                            <button type="button" class="btn btn-primary btn_details">Details</button>
                                            <input type="hidden" class="ptitle" value="<?= $products[$i]['title'] ?>"/>
                                            <input type="hidden" class="plogo"
                                                   value="<?= ROOTPATH ?><?= $products[$i]['logo'] ?>"/>
                                            <input type="hidden" class="pprice" value="<?= $products[$i]['price'] ?>"/>
                                            <input type="hidden" class="pdescription"
                                                   value="<?= $products[$i]['description'] ?>"/>
                                        </div>
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
    </div>
</section><!-- #content end -->
