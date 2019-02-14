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
    #change_store_menu:hover, #change_category_menu:hover, #change_view_menu:hover, .zoom:hover{
        cursor: pointer;
    }


    @media (max-width: 767px){
        #change_view_menu{
            margin: 20px 0;
        }
        .modal-dialog {
            margin: 0.5rem 0;
        }
    }
    .mmodal div{
        display: none;
    }
    .mmodal:hover div{
        display: block;
    }
    .fa.fa-caret-square-o-up:hover, .fa.fa-caret-square-o-down:hover{
        cursor: pointer;
    }
    .content-wrap {
        padding: 40px 0 0;
    }
</style>
<?php
if($form_type=="modal"){
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
                    <input type="hidden" name="form_type" value="modal">
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
</div>
<section id="content">
    <div class="content-wrap" style="padding-top: 0;">
        <div class="market_menu container clearfix">
            <div class="row">
                <?php
                $idx=0;
                foreach ($stores as $store){
                    ?>
                    <div class="col-sm-2 col-4">
                        <a href="/savings/selectedStore/<?=$store['id']?>" ><img src="<?=ROOTPATH ?><?=$store['logo']?>" /></a>
                    </div>
                    <?php
                    $idx++;
                    if($idx>6)break;
                }
                ?>
            </div>
            <hr />
            <!-- Post Content
            ============================================= -->
            <div class="row" style="padding-top: 10px;">
                <div class="col-sm-4">
                    <h3>Weekly Circular</h3>
                </div>
                <div class="col-sm-4">
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
                            <p style="margin: 0;text-align: center;"><button type="button" id="change_store" class="btn btn-primary" style="width: 100%;">Change Local Store</button> </p>
                            <form method="post" style="margin:5px 0;text-align: center;">
                                <input type="hidden" name="land" value="land">
                                <button class="btn btn-primary" style="width: 100%;">Go to Landing page</button>
                            </form>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <!--<div class="col-sm-3">
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
                            <p style="margin: 0;"><a href="<?=ROOTPATH ?>savings/#cat_<?= $category['id']; ?>" class="cat_menu"><?= $category['title']; ?></a></p>
                            <?php
                        }
                        ?>
                    </div>
                </div>-->
                <div class="col-sm-4">
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
        <div class="row" style="padding:0 20px 5px 0;">
            <div class="col-6 col-sm-6">
                <!--<i aria-hidden="true" class="zoom material-icons zoom-m">remove_circle</i>
                <i aria-hidden="true" class="zoom material-icons zoom-p">add_circle</i>-->
            </div>
            <div class="col-6 col-sm-6" style="text-align: right;">
                <a href="<?= ROOTPATH ?>savings/pdf" target="_blank">
                    <button type="button" class="btn" style="padding: 3px 10px; font-size: 12px;margin-right: 15px; margin-top: -6px;">PDF/PRINT</button>
                </a>
                <i class="fa fa-caret-square-o-up" style="font-size: 25px;"></i>
                <i class="fa fa-caret-square-o-down" style="font-size: 25px;display: none;"></i>
            </div>
        </div>
        <div class="content-wrap" style="border-top: 1px solid #ccc;padding: 20px 0; background: url(<?=ROOTPATH?>assets/saving_store/bg_body.jpg);background-size: cover;">
            <div class="container">
                    <?php
                    if($selectedStore>0){
                        ?>
                <div class="clearfix market-container zoom" data-zoom="<?=ROOTPATH ?><?=$storeData[0]['img']?>" style="min-height: 60vh; overflow: hidden;box-shadow: 1px 1px 2px 1px #777;">
                        <img src="<?=ROOTPATH ?><?=$storeData[0]['img']?>" style="width:100%;" />
                </div>
                    <?php
                    }else{
                        ?>
                <div class="row" style="min-height: 50vh;">
                    <div class="col-sm-8" style="padding: 0;">
                        <div class="modal-dialog" style="top:0;">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Enter ZIP code:</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="" >
                                        <input type="hidden" name="form_type" value="">
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
                                    if (count($modal) > 0) {
                                        ?>
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
                                    ?>

                                </div>
                            </div>

                        </div>
                    </div>
                        <div class="col-sm-4" style="background: #fff;padding: 0;">
                            <div style="width: 100%; background: #555;">
                                <h2 style="color: #fff;text-align: center;">MARKETING NEWS</h2>
                            </div>
                            <div style="padding: 0 30px;">
                            <ul id="slideframe">
                                <li><a href="#">좋은 안경을 싸게 파는 정직한 안...</a></li>
                                <li><a href="#">노동절 연휴 다양한 서부투어 상품...</a></li>
                                <li><a href="#">■ 브라이언 타필라 변호사</a></li>
                                <li><a href="#">■ 연세 메디칼 클리닉</a></li>
                                <li><a href="#">“노동절 연휴에 환상의 골프여행 ...</a></li>
                                <li><a href="#">낮은 칼로리, 살아있는 청량감</a></li>
                                <li><a href="#">■ PNC 뱅크 제인 최</a></li>
                                <li><a href="#">■ 우미노시즈쿠 후코이단</a></li>
                                <li><a href="#">■ 웰컴 치과그룹</a></li>
                                <li><a href="#">■ 도요타 다운타운 LA</a></li>
                                <li><a href="#">새콤달콤 맛과 향 살린 과일소주...</a></li>
                                <li><a href="#">어린이 사랑하는 치과전문의</a></li>
                                <li><a href="#">■ 덴트웨이 바디샵</a></li>
                                <li><a href="#">■ 티지아이 코리안 바비큐</a></li>
                            </ul>
                            </div>
                        </div>
                </div>
                    <?php
                    }
                    ?>
            </div>
        </div>
    </div>
</section>
<div>
<!-- #content end -->
