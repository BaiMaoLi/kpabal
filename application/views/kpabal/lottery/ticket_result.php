<!-- start: ticket result-->

<!--<link rel="stylesheet" href="<?=ROOTPATH?>/assets/css/custom1.css" type="text/css">-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<style type="text/css">
    @media (max-width: 1024px) {
        .row.content_container {
            margin-left: 0px;
            margin-right: 0px;
        }
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
    @media (max-width: 575px) {
        .container, #header.full-header .container, .container-fullwidth {
            padding-left: 0px !important;
            padding-right: 0px !important;
        }
    }
    table{
        width:100%;
    }
    .content_container .form-control {
        margin-bottom:15px;
    }
</style>

<form id="payment-form" style="min-height: 60vh;margin-top: 50px;">
<div class="container clearfix">
    <div class="row content_container">
        <div class="col-sm-12 col-md-6">
            <img src="<?=ROOTPATH?>mall/assets/frontend/images/stripe.png" style="width:200px;">
            <table>
                <tr><td>Email Address</td><td><input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Email Address" value="" required=""></td></tr>
                <tr><td>Phone Number</td><td><input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone Number" value="" required=""></td></tr>
            </table>
            <div class="height: 20px;"></div>
        </div>
        <div class="col-sm-12 col-md-6">
            <input type="hidden" name="gameType" id="gameType" value="<?=$gameType?>" />
            <table>
                <tr><td>Payment Amount</td><td><span>$</span> <input type=text class="form-control pay_amount" name="pay_amount" readonly="" value="<?=$lotteryPrice?>" style="width: 100px; display: initial; text-align: right;" required></td></tr>
                <tr><td colspan="2"><div class="gap-2x"></div></td></tr>
                <tr><td>Card Number</td><td><input type="text" class="form-control" data-stripe="number" id="card_number" maxlength="16" style="display: initial;width: 111px;" required></td></tr>
                <tr><td colspan="2"><div class="gap-2x"></div></td></tr>
                <tr><td>Expiration (MM/YY)</td><td><input type="text" class="form-control" data-stripe="exp_month" id="card_month" maxlength="2" style="width: 50px; display: initial;" required> 
                    / <input type="text" class="form-control" data-stripe="exp_year" id="card_year" maxlength="2" style="width: 50px; display: initial;" required></td></tr>
                <tr><td colspan="2"><div class="gap-2x"></div></td></tr>
                <tr><td>CVC</td><td><input type="text" class="form-control" data-stripe="cvc" id="card_cvc" maxlength="3" style="width: 111px; display: initial;" required></td></tr>
                <tr><td colspan="2"><div class="gap-2x"></div></td></tr>
                <tr><td>Name on Card</td><td><input type="text" class="form-control" data-stripe="name" style="width: 111px; display: initial;" required></td></tr>
                <tr><td colspan="2"><div class="gap-2x"></div></td></tr>
                <tr><td colspan="2"><input type="submit" class="submit btn btn-success" id="stripe_button" value="Place Order & Payment"></td></tr>
            </table>
            <div class="height: 20px;"></div>
        </div>
    </div>
</div>
</form>

<!--<script src="<?=ROOTPATH?>/assets/js/lottery-order.js?v=2.0.9"></script>-->
<script>
    /*jQuery(function () {
      LottoOrder.init("content", {
        lotteryTitle: '<?=$lotteryTitle?>',
        lotteryPrice: '<?=$lotteryPrice?>',
        lotteryImage: '<?=$lotteryImage?>',
        lotteryDate: '<?=$lotteryDate?>',
        lotteryData: '<?=$lotteryData?>',
        lotteryAllPrice: '<?=$lotteryAllPrice?>',
      });
    });*/
</script>  