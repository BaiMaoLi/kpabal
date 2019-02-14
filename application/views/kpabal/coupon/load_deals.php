<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>KPABAL</title>
    <link type="text/css" rel="stylesheet" href="<?php echo site_url().PROJECT_CSS_DIR;?>load-deals.css">
	<meta name="robots" content="noindex,nofollow">
</head>
<body id="interstitial">
    <div class="int-wrap">
        <div class="interstitial-box prox-r">
            <div class="mimage_wrapper">
                <img class="mimage" src="<?php echo site_url('coupon/get_safe_res'); ?>?url=<?=$img_logo?>">
            </div>
			<div id="default-panel" class="int-content faded-in">
                <div class="moment">One moment please<img src="<?php echo site_url().PROJECT_IMG_DIR;?>load-deals.gif"></div>
                <div class="congratulations">Congratulations , you're on your way to</div>
                <div class="on-way prox-b"> <?=$cashback?>% Cash Back </div>
				<div class="smalltxt">KPABAL Shopping Trip opened</div>
                <div class="smalltxt redirectLink">
                    <a class="grn" href="<?=$track_url?>">Click here</a>
                    if you are not automatically redirected to <?=$merchant?> .
                </div>
				<div class="nothing grn thatSimple border-t-0">Nothing more for you to do. It's that simple!</div>
                <style>.border-t-0{border-top:none !important;}</style>
				<div class="smalltxt report-msg">Cash Back will be automatically added to your KPABAL account within a few days.</div>
			</div>
        </div>
    </div>
    <script type="text/javascript">
        setTimeout(function(){
            window.location.href = "<?=$track_url?>";
        }, 3000);
    </script>
</body>
</html>