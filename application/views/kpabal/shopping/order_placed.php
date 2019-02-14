<style type="text/css">
    @media (max-width: 1024px) {
        .row.content_container {
            margin-left: 0px;
            margin-right: 0px;
        }
    }
    .breadcrumb-item a {
        color: #c71c77;
    }
    .content_container label {
        color: #909090;
        font-size: 12px;
        margin-bottom: 5px;
        text-transform: initial;
    }

    .content_container .form-control {
        font-size: 0.8rem;
    }
    .fa-star {
        color: #cecece;
    }
    .fa-star.checked {
        color: orange;
    }
    .business_prefered {
        position: relative;
    }
    .action_button {
        position: absolute;
        top: 10px;
        right: 0px;
    }
    .business_record {
        float: left;
        margin-left:10px;
        width: calc(100% - 154px);
        overflow: hidden;
        font-size: 0.8rem;
        color: #666666;
    }
    .business_link {
        color: #e4178b !important;
        font-size: 1.0rem;
        font-weight: 600;
        text-decoration: none;
    }
    .business_link:hover {
        text-decoration: underline !important;
    }
    .rating_link {
        position: absolute;
        top: 0;
        right: 0;
        background-color: #e2dede75;
        padding: 4px 10px;
        border-radius: 15px;
        border: solid 1px #8080801c;
    }

</style>

<div class="contents_area_wrap0">    
    <div class="gpe_contents_box">
        <div class="row content_container">
            <div class="col-sm-12" style="text-align: center; margin-top:50px;">
                <h2>Order Placed Successfully.</h2>
                <h3>You can confirm your order from <a href="<?=ROOTPATH?>favorites/my_order">here</a></h3>
            </div>
        </div>
    </div>

    <?php include_once(__DIR__."/../common/sidebar.php");?>

</div><!-- #content end -->