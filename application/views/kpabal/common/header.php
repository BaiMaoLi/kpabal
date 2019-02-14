<?php
			
			/*print_r($categories);
			print_r($news_categories);
			print_r($blog_categories);*/
			$parentmenu=array();
			foreach($categories as $c){
				if($c['parentIdx']=='01'){
					$parentmenu[]=$c;
				}
			}
		
			?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<title>
		<?php if($caption) echo $caption.' - ';?>
		<?=SITE_TITLE?>
	</title>
	<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>assets/images/logo-title.gif">


	<link rel="stylesheet" href="<?=base_url() ?><?=PROJECT_CSS_DIR?>basic.css">
	<link rel="stylesheet" href="<?=base_url() ?><?=PROJECT_CSS_DIR?>none.css">
	<link rel="stylesheet" href="<?=base_url() ?><?=PROJECT_CSS_DIR?>font-awesome.min.css">
	<link rel="stylesheet" href="<?=base_url() ?><?=PROJECT_CSS_DIR?>default.css">
	<link rel="stylesheet" href="<?=base_url() ?><?=PROJECT_CSS_DIR?>widget.css">
	<link rel="stylesheet" href="<?=base_url() ?><?=PROJECT_CSS_DIR?>style.css">
	<link rel="stylesheet" href="<?=base_url() ?><?=PROJECT_CSS_DIR?>LoginWidget.css">
	<link rel="stylesheet" href="<?=base_url() ?><?=PROJECT_CSS_DIR?>mediaQ_wg.css">
	<link rel="stylesheet" href="<?=base_url() ?><?=PROJECT_CSS_DIR?>layout.css">
	<link rel="stylesheet" href="<?=base_url() ?><?=PROJECT_CSS_DIR?>style3.css">
	<link rel="stylesheet" href="<?=base_url() ?><?=PROJECT_CSS_DIR?>owl.carousel.css">
	<link rel="stylesheet" href="<?=base_url() ?><?=PROJECT_CSS_DIR?>owl.theme.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/bootstrap_mine.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/style.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/dark.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/animate.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/magnific-popup.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/styled.css" type="text/css" />
	<link rel='stylesheet prefetch' href='https://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
	<link rel="stylesheet" href="<?=base_url().PROJECT_DIR?>fontawesome-free/css/all.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/components/datepicker.css" type="text/css" />
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/components/bs-datatable.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/responsive.css" type="text/css" />

	<!-- ^ ^ :)-->
	<!--    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600,700' rel='stylesheet' type='text/css'>-->
	<!--<link href="<?=base_url() ?>assets/css/bootstrapTheme.css" rel="stylesheet">-->
	<!--<link href="<?=base_url() ?>assets/css/custom.css" rel="stylesheet">-->
	<!--<link href="<?=base_url() ?>owl/css/owl.carousel.min.css" rel="stylesheet">-->
	<!--<link href="<?=base_url() ?>owl/css/animate.css" rel="stylesheet">-->
	<!--<link href="<?=base_url() ?>owl/css/owl.theme.default.min.css" rel="stylesheet">-->
	<!--<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">-->
	<!--<link rel="stylesheet" type="text/css" href="<?=base_url() ?>assets/css/motypager.css">-->
	<!--<link rel="stylesheet" type="text/css" href="<?=base_url() ?>assets/css/pages/kpabal.css">-->
	<!--<link rel="stylesheet" type="text/css" href="<?=base_url() ?>assets/css/pages/landing-main-right.css">-->

	<style>
		img{max-width:100%;}
            .menu-item{
                display: block;
                margin-left: 10px;                
            }
            .menu-item a {
                color: #000000bb;
            }

            .menu-item a:hover {
                color: #000000;
            }
        </style>
	<?php 
          $userid = $loggedinuser['memberIdx'];
          $username = $loggedinuser['username'];
          if(isset($additional_css)):
            foreach($additional_css as $css) {
        ?>
	<link rel="stylesheet" href="<?=$css?>">
	<?php } endif ?>

	<script src="<?=base_url().PROJECT_JS_DIR?>jquery.min.js"></script>
	<script src="<?=base_url().PROJECT_JS_DIR?>x.min.js"></script>
	<script src="<?=base_url().PROJECT_JS_DIR?>xe.min.js"></script>
	<script src="<?=base_url().PROJECT_JS_DIR?>news_ticker.js"></script>
	<script src="<?=base_url().PROJECT_JS_DIR?>content_widget.js"></script>
	<script src="<?=base_url().PROJECT_JS_DIR?>m_pm_ban.js"></script>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-8278499645225256",
        enable_page_level_ads: true
      });
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-132321621-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-132321621-1');
    </script>
</head>

<body>
	<div class="layG_mobileM_G_bg" onclick="jQuery(&#39;.layG_mobileM_G_bg, .layG_mobileM_G&#39;).fadeToggle(&#39;fast&#39;); jQuery(&#39;html&#39;).removeClass(&#39;sb-scroll-lock&#39;);"></div>


	<div class="layG_mobileM_G">
		<div class="layG_mobileM_nameClose">
			<div class="layG_mobileM_G_name">방문을 환영합니다.</div>
			<div class="layG_mobileM_G_close" onclick="jQuery(&#39;.layG_mobileM_G_bg, .layG_mobileM_G&#39;).fadeToggle(&#39;fast&#39;); jQuery(&#39;html&#39;).removeClass(&#39;sb-scroll-lock&#39;);">
				<i class="fa fa-times"></i>
			</div>
		</div>
		<div class="layG_mobileM_login">
			<ul>
				<li>
					<a class="Log" href="https://www.kpabal.com/business" style="cursor:pointer;">
						<i class="fas fa-briefcase"></i>
						업소록
					</a>
				</li>
				<?php
                        $userid = $loggedinuser['memberIdx'];
                        $username = $loggedinuser['username'];
                            
                        if($userid != NULL):
                    ?>
				<li>
					<a href="https://www.kpabal.com/profile" class="Mem">
						<i class="fas fa-user-check"></i>
						PROFILE
					</a>
				</li>
				<li>
					<a class="Log" href="https://www.kpabal.com/logout" style="cursor:pointer;">
						<i class="fa fa-power-off"></i>
						LOGOUT
					</a>
				</li>
				<?php else:?>
				<li>
					<a href="https://www.kpabal.com/register" class="Mem">
						<i class="fas fa-user-check"></i>
						JOIN
					</a>
				</li>
				<li>
					<a class="Log" href="https://www.kpabal.com/login" style="cursor:pointer;">
						<i class="fa fa-power-off"></i>
						LOGIN
					</a>
				</li>
				<?php endif?>
			</ul>
		</div>
	
		<div class="layG_mobileM_search" style="height: 2px;">
		</div>
		<div class="layG_mobileM_menu">
		<ul class="mbM_sleft_d_01_m">
							<?php 
							$count=0;
							foreach($parentmenu as $p){
								
							?>
								<li class="mbM_sleft_d_01 <?php if($count==0){ echo 'first';}?>"> 
								<?php 
								
								$found=0;
								foreach($categories as $ct){
									if($ct['parentIdx']==$p['menuIdx']){
								$found++;
									}
								}
								?>
								<?php if($found>0){?>
									<span class="on1_no">
								<a href="<?=$p['menuURL']?>" class="on1_no"> <?=$p['menuName']?> </a> <i class="fa fa-chevron-down"></i></span>
								<?php }else{?>
									<span class="on1_no">
								<a href="<?=$p['menuURL']?>" class="on1_no"> <?=$p['menuName']?> </a></span>
								<?php } ?>
								<ul class="mbM_sleft_d_02_m" style="display: none;">
									
										<?php foreach($categories as $ct){
											if($ct['parentIdx']==$p['menuIdx']){
											?>
										<li class="mbM_sleft_d_02">
										
											
												<?php 
								
								$found=0;
								foreach($categories as $pct){
									if($pct['parentIdx']==$ct['menuIdx']){
								$found++;
									}
								}
								?>
								<?php if($found>0){?>
									<span class="on2_no">
								<a href="<?=$ct['menuURL']?>" class="on2_no"> <?=$ct['menuName']?> </a> <i class="fa fa-chevron-down"></i></span>
								<?php }else{?>
									<a href="<?=$ct['menuURL']?>" class="on2_no"><i class="fa fa-angle-right"></i>
												<?=$ct['menuName']?></a>
								<?php } ?>
								
								
								
								
												<ul class="mbM_sleft_d_03_m" style="display: none;">
										
										<?php foreach($categories as $pct){
											if($pct['parentIdx']==$ct['menuIdx']){
											?>
										<li class="mbM_sleft_d_03">
											
													<?php 
								
								$found=0;
								foreach($categories as $xpct){
									if($xpct['parentIdx']==$pct['menuIdx']){
								$found++;
									}
								}
								?>
								<?php if($found>0){?>
									<span class="on3_no">
								<a href="<?=$pct['menuURL']?>" class="on3_no"> <?=$pct['menuName']?> </a> <i class="fa fa-chevron-down"></i></span>
								<?php }else{?>
									<a href="<?=$pct['menuURL']?>" class="on3_no"><i class="fa fa-angle-right"></i>
												<?=$pct['menuName']?></a>
								<?php } ?>
								
								
													<ul class="mbM_sleft_d_04_m" style="display: none;">
										
										<?php foreach($categories as $xpct){
											if($xpct['parentIdx']==$pct['menuIdx']){
											?>
										<li class="mbM_sleft_d_04">
											<a href="<?=$xpct['menuURL']?>" class="on4_no">
												<?=$xpct['menuName']?></a>
										</li>
											<?php }} ?>
										</ul>
										
										</li>
											<?php }} ?>
										</ul>
										
										</li>
											<?php }} ?>
										</ul>
								</li>
							<?php 
							$count++;
							}  ?>
							</ul>
							
							
			
		</div>
	</div>


	<div class="gnb1_area_wrap00">
	
		<div class="gnb1_area_wrap0">
			<div class="gpe_logo" style="z-index:5;">
				<a href="<?=base_url()?>">
					<img src="<?=base_url().PROJECT_IMG_DIR?>logo-dark.png" alt="로고">
				</a>
			</div>
			<div class="xe-widget-wrapper " style="">
				<div style="*zoom:1;padding:0px 0px 0px 0px !important;">
					<div class="layG_newsCon" id="layG_newsCon_id" style="left:px;">
						<ul>
							<?php
                                if(isset($notices)):
                                    foreach($notices as $notice){?>
							<li>
								<a href="#" class="subject">
									<?=$notice->page_title?></a>
								<span class="date">[
									<?=date("M j, Y", strtotime($notice->page_date))?>]</span>
							</li>
							<?php }
                                endif
                                ?>
						</ul>
					</div>
					<script>
						xAddEventListener(window, 'load', function() {
							doStartScroll("layG_newsCon_id", 26, 40);
						});

					</script>
				</div>
			</div>
			<div class="gpe_login">
				<ul>
					<li>
						<a href="https://www.kpabal.com/business" accesskey="B">
							<span>업소록</span>
						</a>
						<span class="m_space_login"></span>
					</li>
					<?php
                        $userid = $loggedinuser['memberIdx'];
                        $username = $loggedinuser['username'];
                            
                        if($userid != NULL):
                    ?>
					<li>
						<a href="https://www.kpabal.com/profile">
							<span><b>PROFILE</b></span>
						</a>
						<span class="m_space_login"></span>
					</li>
					<li>
						<a href="https://www.kpabal.com/logout" accesskey="L">
							<span>LOGOUT</span>
						</a>
					</li>
					<?php else:?>
					<li>
						<a href="https://www.kpabal.com/register">
							<span><b>JOIN</b></span>
						</a>
						<span class="m_space_login"></span>
					</li>
					<li>
						<a href="https://www.kpabal.com/login" accesskey="L">
							<span>LOGIN</span>
						</a>
					</li>
					<?php endif?>
				</ul>
			</div>
			
			<div class="tmenu1_wrap00_Fheight">
				<div class="tmenu1_wrap00">
					<div class="tmenu1_wrap0">
						<div class="gpe_munu">
							<ul class="topnav">
							<?php 
							$count=0;
							foreach($parentmenu as $p){
								
							?>
								<li class="mnav_li <?php if($count==0){ echo 'first';}?>"> <a href="<?=$p['menuURL']?>" class="mnav"> <?=$p['menuName']?> </a> 
								
								<ul class="subnav_d02_m" style="display: none;">
									
										<?php foreach($categories as $ct){
											if($ct['parentIdx']==$p['menuIdx']){
											?>
										<li class="subnav_d02">
											<a href="<?=$ct['menuURL']?>" class="on2_no">
												<?=$ct['menuName']?></a>
												
												<ul class="subnav_d03_m" style="display: none;">
										
										<?php foreach($categories as $pct){
											if($pct['parentIdx']==$ct['menuIdx']){
											?>
										<li class="subnav_d03">
											<a href="<?=$pct['menuURL']?>" class="on3_no">
												<?=$pct['menuName']?></a>
												
													<ul class="subnav_d03_m" style="display: none;">
										
										<?php foreach($categories as $xpct){
											if($xpct['parentIdx']==$pct['menuIdx']){
											?>
										<li class="subnav_d04">
											<a href="<?=$xpct['menuURL']?>" class="on4_no">
												<?=$xpct['menuName']?></a>
										</li>
											<?php }} ?>
										</ul>
										
										</li>
											<?php }} ?>
										</ul>
										
										</li>
											<?php }} ?>
										</ul>
								</li>
							<?php 
							$count++;
							}  ?>
							</ul>
						</div>
						<span class="allmenu" onclick="jQuery(&#39;.allmenu_list&#39;).fadeToggle();"></span>
						<div class="allmenu_list" style="display: none;">
							<span class="allmenu_close" onclick="jQuery(&#39;.allmenu_list&#39;).fadeToggle();"></span>
							<div style="position:relative;">
								<span class="triang" style="top:-21px; top:-23px\9; left:8px; border-color:transparent transparent #353940 transparent;"></span>
							</div>
							<div class="allmenu_left_margin"></div>
							
							<ul class="allmenu_ul">
							<?php 
							$count=0;
							foreach($parentmenu as $p){
								
							?>
								<li class="section_group <?php if($count==0){ echo 'first';}?>"> <a href="<?=$p['menuURL']?>" class="section_1dep" > <?=$p['menuName']?> </a> 
								
								<ul>
									
										<?php foreach($categories as $ct){
											if($ct['parentIdx']==$p['menuIdx']){
											?>
										<li class="subnav_d02">
											<a href="<?=$ct['menuURL']?>" class="section_2dep">
												<?=$ct['menuName']?></a>
												
												<ul>
										
										<?php foreach($categories as $pct){
											if($pct['parentIdx']==$ct['menuIdx']){
											?>
										<li class="subnav_d03">
											<a href="<?=$pct['menuURL']?>" class="section_3dep">
												<?=$pct['menuName']?></a>
												
													<ul >
										
										<?php foreach($categories as $xpct){
											if($xpct['parentIdx']==$pct['menuIdx']){
											?>
										<li class="subnav_d04">
											<a href="<?=$xpct['menuURL']?>" class="section_4dep">
												<?=$xpct['menuName']?></a>
										</li>
											<?php }} ?>
										</ul>
										
										</li>
											<?php }} ?>
										</ul>
										
										</li>
											<?php }} ?>
										</ul>
								</li>
							<?php 
							$count++;
							}  ?>
							</ul>
							
							
							
						</div>
					</div>
				</div>
			</div>
			
			
			<script>
				jQuery(function(e) {
					var g = e(".topnav");
					var d = g.find(">li");
					var c = g.find(">ul>li");
					var b = null;
					d.find(">ul").hide();
					d.filter(":first").addClass("first");

					function f() {
						var h = e(this);
						if (h.next("ul").is(":hidden") || h.next("ul").length == 0) {
							d.find(">ul").fadeOut(200);
							d.find("a").removeClass("hover");
							h.next("ul").fadeIn(200);
							h.addClass("hover")
						}
					}

					function a() {
						d.find("ul").fadeOut(200);
						d.find("a").removeClass("hover")
					}
					d.find(">a").mouseover(f).focus(f);
					d.mouseleave(a)
				});

				jQuery(function(e) {
					var g = e(".subnav_d02_m");
					var d = g.find(">li");
					var c = g.find(">ul>li");
					var b = null;
					d.find(">ul").hide();
					d.filter(":first").addClass("first");

					function f() {
						var h = e(this);
						if (h.next("ul").is(":hidden") || h.next("ul").length == 0) {
							d.find(">ul").fadeOut(200);
							d.find("a").removeClass("hover");
							h.next("ul").fadeIn(200);
							h.addClass("hover")
						}
					}

					function a() {
						d.find("ul").fadeOut(200);
						d.find("a").removeClass("hover")
					}
					d.find(">a").mouseover(f).focus(f);
					d.mouseleave(a)
				});

			</script>
			<script>
				var j_stm = jQuery;
				j_stm(document).ready(function() {
					var a = j_stm(".tmenu1_wrap00").offset().top - parseFloat(j_stm(".tmenu1_wrap00").css("marginTop").replace(/auto/, 0));
					j_stm(window).scroll(function(b) {
						var c = j_stm(this).scrollTop();
						if (c >= a) {
							j_stm(".tmenu1_wrap00, .tmenu1_wrap0").addClass("fixed")
						} else {
							j_stm(".tmenu1_wrap00, .tmenu1_wrap0").removeClass("fixed")
						}
					})
				});

			</script>

			<div class="layG_munu_MobileBtn layG_iecss3" onclick="jQuery(&#39;.layG_mobileM_G_bg&#39;).on(&#39;touchmove&#39;, false); jQuery(&#39;.layG_mobileM_G_bg, .layG_mobileM_G&#39;).fadeToggle(); jQuery(&#39;html&#39;).addClass(&#39;sb-scroll-lock&#39;);">
				<i class="fa fa-bars"></i>
			</div>
		</div>
		<span class="gnb1_area_cenLine1"></span>
		<span class="gnb1_area_cenLine2"></span>
		<span class="gnb1_area_botline"></span>
		<span class="gnb1_area_top2typeBG layG_iecss3"></span>
	</div>
	
			<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container" id="top-stock" style="    padding-top: 38px;">
  <div class="tradingview-widget-container__widget"></div>
  
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-tickers.js" async>
  {
  "symbols": [
    {
      "title": "S&P 500",
      "proName": "INDEX:SPX"
    },
    {
      "title": "Nasdaq 100",
      "proName": "INDEX:IUXX"
    },
    {
      "title": "EUR/USD",
      "proName": "FX_IDC:EURUSD"
    },
    {
      "title": "BTC/USD",
      "proName": "BITFINEX:BTCUSD"
    },
    {
      "title": "ETH/USD",
      "proName": "BITFINEX:ETHUSD"
    },
    {
      "description": "NASDAQ",
      "proName": "NASDAQ:NDAQ"
    },
    {
      "description": "CRUDE OIL",
      "proName": "SP:SPGSCL"
    },
    {
      "description": "DXY",
      "proName": "INDEX:DXY"
    }
  ],
  "locale": "in"
}
  </script>
</div>
<!-- TradingView Widget END -->
	<div class="notice_MQarea"></div>
	<div class="gpe_allcon_wrap0">
