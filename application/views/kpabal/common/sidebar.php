<style type="text/css">
    .popu_li {
        height: 30px; 
        overflow: hidden;
        line-height: 30px;
    }
    .popu_li a {
        word-break: break-all;
    }
    tr {
        height: 28px;
        line-height: 28px;
    }
</style>
    <!--SIDE 컨텐츠(우측)-->
    <div class="gpe_side_contents_R">
        <!--로그인-->
        <div>
            <div class="xe-widget-wrapper">
                <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
				
				<div class="product-upload-block">
				<div class="choose_file"> 
							<?php
                            $userid = $loggedinuser['memberIdx'];
                            $username = $loggedinuser['username'];
                            if($userid != NULL){
							?>
								<span><a href="<?=site_url('Productupload'); ?>" style="color: white;padding-left: 60px;">Product upload</a></span>
							<?php } else{?>
								<span><a href="https://www.kpabal.com/login" style="color: white;padding-left: 60px;">Product upload</a></span>
							<?php } ?>	
				</div>
				</div>
				
				<div class="Wish-List-block" style="display: block;">
    				<div class="block-wrapp">
    					<div class=""><i class="fa fa-heart" aria-hidden="true"></i></div>
    					<span><a href="<?php echo site_url();?>login" style="color: black;">Wish List</a></span> </div>
    				<div class="block-wrapp">
    					<div class=""><i class="fa fa-home" aria-hidden="true"></i></div>
    					<span><a href="<?php echo site_url();?>" style="color: black;">View My Store</a></span> </div>
				</div>
				
                    <div class="GPE_login_area" style="display: block;">
                        <?php
                            $userid = $loggedinuser['memberIdx'];
                            $username = $loggedinuser['username'];
                            
                            if($userid != NULL){
                                ?>
                                <form class="formGPE_login" style="clear: both;">
                                    <fieldset class="text-center">
                                        <span>
                                            <?php echo $username;?> 님 환영합니다.
                                        </span>
                                        <div>
                                            <a class="btn btn-outline-danger" style="font-size: 12px;" href="<?=ROOTPATH?>favorites/business"><i class="fas fa-business-time"></i> &nbsp; My Business</a>
                                        </div>
                                        <div class="btn_sns">
                                            <a href="<?=ROOTPATH?><?php echo FRONTEND_USER_PROFILE_DIR;?>">프로필</a>
                                        </div>
                                    </fieldset>
                                </form>
                                
                                <?php
                            }else{
                                ?>
                                <form method="post" class="formGPE_login" id="login-form" style="clear: both;">
                                    <fieldset>
                                        
                                        <!--회원가입+아이디비번찾기+인증메일-->
                                        <ul class="help">
                                            <li>
                                                <a href="<?=ROOTPATH?>register" class="help_join" style="font-size: 14px;">회원가입</a>
                                            </li>
                                        </ul>
                                        <!--아이디+패스워드+로긴버튼-->
                                        <div class="idpwWrap" style="width: 315px;">
                                            <span class="idpw">
                                                <!--아이디+패스워드-->
                                                <input name="user_id" class="user_id" name="user_id" id="uid" type="text" title="아이디 입력" value="아이디" style=""
                                                    onblur="if(this.value == &#39;&#39;){this.style.border=&#39;1px solid #bebebe&#39;;this.value=&#39;아이디&#39;}" onfocus="if(this.value == &#39;아이디&#39;){this.style.border=&#39;1px solid #333&#39;;this.value=&#39;&#39;}" class="idpw_id">
                                                <!--아이디-->
                                                <input name="password" class="user_password" name="user_password" id="upw" type="password" title="비밀번호 입력" value="비밀번호" 
                                                    onblur="if(this.value == &#39;&#39;){this.style.border=&#39;1px solid #bebebe&#39;;this.value=&#39;비밀번호&#39;}" onfocus="if(this.value == &#39;비밀번호&#39;){this.style.border=&#39;1px solid #333&#39;;this.value=&#39;&#39;}" class="idpw_pass">
                                                <!--패스워드-->
                                            </span>
                                            <span class="loginbutton">
                                                <input type="button" class="submit btn btn-inverse login-form-submit" alt="로그인" value="Sign In">
                                            </span>
                                        </div>
                                        <!--로긴유지-->
                                        <div class="keep_login">
                                            <input type="checkbox" name="keep_signed" id="keep_signed" value="Y" title="체크하시면 로그인이 유지됩니다.">
                                            <label for="keep_signed">Keep me signed in.</label>
                                        </div>
                                        <!--쇼셜로그인-->
                                        <div class="btn_sns">
                                            <a href="<?=ROOTPATH?>login">쇼셜로그인</a>
                                        </div>
                                        <div class="alert fade display-none" role="alert">
                                            <span class="msgContent"></span>
                                        </div>
                                    </fieldset>
                                </form>
                                <?php
                            }
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
        <!--사이드메뉴-->
        <!--공지사항-->
        <div class="paddSide" style="display:block;">
            <div class="xe-widget-wrapper">
                <div class="gpe_WS_box">
                    <div class="gpe_WS_h2box" style="margin-bottom:px;">
                        <h2 class="gpe_side_contents_wsTitle" style=" /*위젯스타일 컬러셋에 경우 html 직접삽입방식*/ color:#333;">공지사항 </h2>
                    </div>
                    <a href="<?=ROOTPATH?>notices" class="widgetMoreLink"></a>
                    <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
                        <div class="widgetNOVAContainer">
                            <div class="gpe_wgListADIV" style="margin-top:-5px;">
                                <table class="gpe_wgListA" cellspacing="0">
                                    <tbody>
                                    	<?php foreach($notices as $notice){?>
                                        <tr>
                                            <td class="title sideContents">
                                                <a href="<?=ROOTPATH?>notices/<?=$notice->id?>" class="title"><?=$notice->page_title?></a>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <!--prev_next_bottom-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--사이드배너-->
        <div>
            <div class="gpe_pm_sideban">
				<div class="gpe_pm_ban_imgbox" style="margin: auto;">
					<?php foreach($sidebar_sliders as $slider){?>
					<a href="<?=$slider->content?>"><img src="<?=ROOTPATH?>api/image/media/<?=$slider->id?>/360/200" alt="<?=$slider->title?>"/></a>
					<?php }?>
				</div>
				<span class="gpe_prev"></span>
				<span class="gpe_next"></span>
			</div>
            <script>
                var j_bsr = jQuery;
                j_bsr(function() {
                    j_bsr('.gpe_pm_sideban').slides({
                        preload: true,
                        preloadImage: '<?=ROOTPATH.PROJECT_IMG_DIR?>loading.gif',
                        play: 5500,
                        pause: 1,
                        hoverPause: true
                    });
                });
            </script>
        </div>
        <!--위젯코드1-10번-->
        <div class="paddSide boderB1px">
            <div class="xe-widget-wrapper">
                <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
                    <!--사용자 컬러만 스타일뺏음-->
                    <div class=" gpe_wgPopularT1 /*레이아웃 컬러셋선택*/ cp /*레이아웃 사용자컬러*/">
                        <span class="gpe_wgPoTapbg2"></span>
                        <ul style="height:200px;">
                            <li class="active" onclick="jQuery(this).parent().find(&#39;li.active&#39;).removeClass(&#39;active&#39;);jQuery(this).addClass(&#39;active&#39;);return false;">
                                <p class="wgP_title" style="width:108px; width:69px;">인기글</p>
                                <!--newest title-->
                                <!--newest contents-->
                                <ul class="wgP_contents">
	                            	<?php foreach($side_articles1 as $key => $article){?>
	                                <li class="popu_li">
	                                    <span class="Ncolor wgp_num0<?=$key+1?>">
	                                        <?=$key+1?><span class="wgp_numR">위</span>
	                                    </span>
	                                    <a href="<?=ROOTPATH?>article/<?=$article->id?>" onclick="window.location.href='<?=ROOTPATH?>article/<?=$article->id?>'"><?=$article->article_title?></a>
	                                    <?php if($article->reply_count):?>
	                                    <a href="<?=ROOTPATH?>article/<?=$article->id?>#comment" class="reNum">+<?=$article->reply_count?></a>
	                                    <?php endif?>
	                                </li>
	                                <?php }?>
                                </ul>
                            </li>
                            <li class="" onclick="jQuery(this).parent().find(&#39;li.active&#39;).removeClass(&#39;active&#39;);jQuery(this).addClass(&#39;active&#39;);return false;">
                                <p class="wgP_title" style="width:108px; width:69px;">최신글</p>
                                <!--newest title-->
                                <!--newest contents-->
                                <ul class="wgP_contents">
	                            	<?php foreach($side_articles2 as $key => $article){?>
	                                <li class="popu_li">
	                                    <a href="<?=ROOTPATH?>article/<?=$article->id?>" onclick="window.location.href='<?=ROOTPATH?>article/<?=$article->id?>'"><?=$article->article_title?></a>
	                                </li>
	                                <?php }?>
                                </ul>
                            </li>
                            <!--newest-->
                            <li class="" onclick="jQuery(this).parent().find(&#39;li.active&#39;).removeClass(&#39;active&#39;);jQuery(this).addClass(&#39;active&#39;);return false;">
                                <p class="wgP_title" style="width:109px; width:69px;">최신댓글</p>
                                <!--comments title-->
                                <!--comments contents-->
                                <ul class="wgP_contents">
	                            	<?php foreach($side_articles3 as $key => $article){?>
	                                <li class="popu_li">
	                                    <a href="<?=ROOTPATH?>article/<?=$article->articleIdx?>#comment" onclick="window.location.href='<?=ROOTPATH?>article/<?=$article->articleIdx?>#comment'"><?=$article->reply_content?></a>
	                                </li>
	                                <?php }?>
                                </ul>
                            </li>
                            <!--comments-->
                        </ul>
                        <span class="gpe_wgPoTapbg"></span>
                        <span class="gpe_wgPoTapbg3"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="paddSide boderB1px">
            <div class="xe-widget-wrapper">
                <div class="gpe_WS_box">
                    <div class="gpe_WS_h2box" style="margin-bottom:px;">
                        <h2 class="gpe_side_contents_wsTitle" style=" /*위젯스타일 컬러셋에 경우 html 직접삽입방식*/ /*레이아웃 컬러셋선택*/ color:#c71c77; /*레이아웃 사용자컬러*/">포인트랭킹 </h2>
                    </div>
                    <a href="#" class="widgetMoreLink" style="display: none;"></a>
                    <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
                        <div class="gpe_wgPointDIV">
                            <table class="gpe_wgPoint" cellspacing="0">
                                <thead>
                                    <tr class="wgP_titGroup">
                                        <th class="title red">순위</th>
                                        <th class="nick red">닉네임</th>
                                        <th class="point red TextRight">포인트</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $idx=0; ?>
                                	<?php foreach($ranking_members as $key => $member) {
                                		if($member->member_point <= 0) break;
                                		if($member->user_id != "admini"){
                                		    $idx++;
                                		    if($idx>5) break;
                                	?>
                                    <tr class="wgP_listGroup">
                                        <td class="Ncolor wgp_num0<?=$idx?>"><?=$idx?>위</td>
                                        <td class="TextBold">
                                            <?=$member->user_id?>
                                        </td>
                                        <td class="Pcolor TextRight TextBold"><?=number_format($member->member_point)?>점</td>
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		  <!--공지사항-->
        <div class="paddSide" style="min-height:350px;">
            <div class="xe-widget-wrapper">
                <div class="gpe_WS_box">
				
				
                <!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
  {
  "showChart": true,
  "locale": "en",
  "width": "100%",
  "height": "450px",
  "largeChartUrl": "",
  "plotLineColorGrowing": "rgba(60, 188, 152, 1)",
  "plotLineColorFalling": "rgba(255, 74, 104, 1)",
  "gridLineColor": "rgba(233, 233, 234, 1)",
  "scaleFontColor": "rgba(214, 216, 224, 1)",
  "belowLineFillColorGrowing": "rgba(60, 188, 152, 0.05)",
  "belowLineFillColorFalling": "rgba(255, 74, 104, 0.05)",
  "symbolActiveColor": "rgba(242, 250, 254, 1)",
  "tabs": [
    {
      "title": "Indices",
      "symbols": [
        {
          "s": "INDEX:SPX",
          "d": "S&P 500"
        },
        {
          "s": "INDEX:IUXX",
          "d": "Nasdaq 100"
        },
        {
          "s": "INDEX:DOWI",
          "d": "Dow 30"
        },
        {
          "s": "INDEX:NKY",
          "d": "Nikkei 225"
        },
        {
          "s": "INDEX:DAX",
          "d": "DAX Index"
        },
        {
          "s": "OANDA:UK100GBP",
          "d": "FTSE 100"
        }
      ],
      "originalTitle": "Indices"
    },
    {
      "title": "Commodities",
      "symbols": [
        {
          "s": "CME_MINI:ES1!",
          "d": "E-Mini S&P"
        },
        {
          "s": "CME:E61!",
          "d": "Euro"
        },
        {
          "s": "COMEX:GC1!",
          "d": "Gold"
        },
        {
          "s": "NYMEX:CL1!",
          "d": "Crude Oil"
        },
        {
          "s": "NYMEX:NG1!",
          "d": "Natural Gas"
        },
        {
          "s": "CBOT:ZC1!",
          "d": "Corn"
        }
      ],
      "originalTitle": "Commodities"
    },
    {
      "title": "Bonds",
      "symbols": [
        {
          "s": "CME:GE1!",
          "d": "Eurodollar"
        },
        {
          "s": "CBOT:ZB1!",
          "d": "T-Bond"
        },
        {
          "s": "CBOT:UD1!",
          "d": "Ultra T-Bond"
        },
        {
          "s": "EUREX:GG1!",
          "d": "Euro Bund"
        },
        {
          "s": "EUREX:II1!",
          "d": "Euro BTP"
        },
        {
          "s": "EUREX:HR1!",
          "d": "Euro BOBL"
        }
      ],
      "originalTitle": "Bonds"
    },
    {
      "title": "Forex",
      "symbols": [
        {
          "s": "FX:EURUSD"
        },
        {
          "s": "FX:GBPUSD"
        },
        {
          "s": "FX:USDJPY"
        },
        {
          "s": "FX:USDCHF"
        },
        {
          "s": "FX:AUDUSD"
        },
        {
          "s": "FX:USDCAD"
        }
      ],
      "originalTitle": "Forex"
    }
  ]
}
  </script>
</div>
<!-- TradingView Widget END -->

			<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <div class="tradingview-widget-copyright"><a href="https://in.tradingview.com/markets/stocks-india/market-movers-gainers/" rel="noopener" target="_blank"><span class="blue-text">Stock Market</span></a> by TradingView</div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-hotlists.js" async>
  {
  "exchange": "US",
  "showChart": true,
  "locale": "in",
  "largeChartUrl": "",
  "width": "400",
  "height": "600",
  "plotLineColorGrowing": "rgba(60, 188, 152, 1)",
  "plotLineColorFalling": "rgba(255, 74, 104, 1)",
  "gridLineColor": "rgba(242, 243, 245, 1)",
  "scaleFontColor": "rgba(214, 216, 224, 1)",
  "belowLineFillColorGrowing": "rgba(60, 188, 152, 0.05)",
  "belowLineFillColorFalling": "rgba(255, 74, 104, 0.05)",
  "symbolActiveColor": "rgba(242, 250, 254, 1)"
}
  </script>
</div>
<!-- TradingView Widget END -->


                </div>
            </div>
        </div>
        <!--사이드배너-->
		
		
    </div>