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
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" style="height: 30px;">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>profile">My Profile</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Orders</li>
                  </ol>
                </nav>
            </div>
            <div class="col-sm-12">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="order-tab" data-toggle="tab" href="#" role="tab" aria-selected="false">Order History</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="payment-tab" data-toggle="tab" href="#" role="tab" aria-selected="false">Payment History</a>
                  </li>
                </ul>
                <div class="tab-content" id="mall_list">
                  <div class="tab-pane fade show active" role="tabpanel" id="content_table">
                  </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once(__DIR__."/../common/sidebar.php");?>

</div><!-- #content end -->