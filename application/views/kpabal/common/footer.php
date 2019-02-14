<?php
			
			/*print_r($categories);
			print_r($news_categories);
			print_r($blog_categories);*/
			$footermenu=array();
			foreach($footers as $c){
				if($c['parentIdx']=='02'){
					$footermenu[]=$c;
				}
			}
			?>
		</div>
        <div class="footer_Util_wrap00">
            <div class="footer_Util_wrap0" style="">
                <div class="gpe_utilMenu">
                    <ul>
                	<?php 
                    if($footers):
                        foreach($footermenu as $footer) { ?>
                        <li>
                            <a href="<?=$footer['menuURL']?>"><?=$footer['menuName']?> </a>
                        </li>
	                <?php }
                    endif
                    ?>
                    </ul>
                </div>
                <div class="gpe_copytxt">
                    <p>
                        소재지: <?=SITE_ADDRESS?> / 대표전화: <?=SITE_PHONE?> / 팩스: <?=SITE_FAX?><br>
                        Copyright ⓒ <?=date("Y")?> <span style="font-weight:bold; color:#00a6d4;"><?=SITE_COMPANY?></span> All Rights Reserved 
                    </p>
                </div>
            </div>
        </div>
        <div class="gpe_movetop">
            <div class="gpe_mt top"></div>
            <div class="gpe_mt bottom"></div>
            <script>
                var j_mt = jQuery;
                j_mt(document).ready(function() {
                    j_mt('.gpe_movetop>.gpe_mt.top').click(function() {
                        j_mt('body,html').animate({
                            scrollTop: 0
                        }, 500);
                        return false;
                    });
                    j_mt('.gpe_movetop>.gpe_mt.bottom').click(function() {
                        j_mt('body,html').animate({
                            scrollTop: document.body.scrollHeight
                        }, 500);
                        return false;
                    });
                });
            </script>
            <div class="gpe_myMenu">
                <ul>
                    <li class="gpe_myMenu_relative first">
                        <a></a>
                        <ul style="display: none;">
	                	<?php foreach($categories as $key => $main_category) { ?>
                            <li>
                                <a href="<?php if($main_category->menuURL) echo ROOTPATH.substr($main_category->menuURL, 1); else echo '#';?>"> <?=$main_category->menuName?></a>
                            </li>
    	                <?php }?>
                            <li class="titleBox">
                                <span class="title">바로가기</span>
                                <span class="close" onclick="jQuery(&#39;.gpe_myMenu_relative&gt;ul&#39;).slideToggle(200);"></span>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <script>
                jQuery(function(e) {
                    var g = e(".gpe_myMenu>ul");
                    var d = g.find(">li");
                    var c = g.find(">ul>li");
                    var b = null;
                    d.find(">ul").hide();
                    d.filter(":first").addClass("first");
                    function f() {
                        var h = e(this);
                        if (h.next("ul").is(":hidden") || h.next("ul").length == 0) {
                            d.find(">ul").slideUp(200);
                            d.find("a").removeClass("hover");
                            h.next("ul").slideDown(200);
                            h.addClass("hover")
                        }
                    }
                    function a() {
                        d.find("ul").slideUp(200);
                        d.find("a").removeClass("hover")
                    }
                    d.find(">a").click(f).focus(f);
                    d.mouseleave(a)
                });
            </script>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myMapModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document" style="margin: 3.75rem auto;">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 modal_body_map">
                                <div class="location-map" id="location-map">
                                    <div style="width: 600px; height: 400px;" id="map_canvas"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_se" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <div class="modal-body">
                <div class="image-sec text-center"><span> <img src="" class="fmtc_default_logo" id="fmtc_logo"></span> </div>
                <div class="sep_ttl"> <a href="" id="fmtc_url" target="_blank"></a></div>
                <div class="text-center">
                <a href="" class="btn btn-hlw" id="fmtc_url_details" target="_blank">See Details</a>
                </div>
                  <div class="sep_highlight">
                    <div class="row">
                    <div class="col-sm-6"><div class="inset_"> <span class="show-date"> EXPIRES IN <span id="fmtc_date" class="f-grn"></span> </span> </div></div>
                    <div class="col-sm-6"><div class="inset_"> <span class="coupon-code"> <strong>Couponcode:</strong> <span id="fmtc_code" class="f-grn"></span> </span> </div></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script>
            var j_height_m = jQuery;
            var MDsearchHeight = j_height_m(".contents_area_wrap0").height();
            j_height_m(".gpe_MDsearch_con, .gpe_MDsearch_Dcon, .gpe_MDsearch_Ccon, .gpe_MDsearch_Tcon, .gpe_MDsearch_Mcon, .gpe_MDsearch_Fcon").css('height', MDsearchHeight);
        </script>
        <script>
            jQuery(function($) {
                $(function() {
                    var go_leftM = $('.gpe_sideMenu>.sleft_d_02_m, .layG_mobileM_menu>.mbM_sleft_d_01_m, .layG_mobileM_menu>.mbM_sleft_d_01_m>.mbM_sleft_d_02_m');
                    go_leftM.find("li").click(function() {
                        var t = $(this);
                        t.find(">span, >a").siblings("ul:not(:animated)").slideDown(200);
                        t.siblings().find(">span, >a").siblings("ul").slideUp(200);
                    }).mouseleave(function() {});
                });
            });
        </script>
        <?php 
	      if(isset($additional_js)):
	        foreach($additional_js as $js) {
	    ?>
	        <script src="<?=$js?>" type="text/javascript"></script>
        <?php } endif ?>
        <!-- External JavaScripts
        ============================================= -->
        <script src="<?php echo DEFAULT_JS_DIR;?>plugins.js"></script>
        <!-- Footer Scripts
        ============================================= -->
        <script src="<?php echo DEFAULT_JS_DIR;?>components/datepicker.js"></script>
        <script src="<?php echo DEFAULT_JS_DIR;?>functions.js"></script>
        <!-- Bootstrap Data Table Plugin -->
        <script src="<?php echo DEFAULT_JS_DIR;?>components/bs-datatable.js"></script>
        <script src="<?php echo DEFAULT_JS_DIR;?>plugins/jquery.validation.js" type="text/javascript"></script>

        <!--<script src="<?php echo DEFAULT_JS_DIR;?>owl.carousel.js" type="text/javascript"></script>-->
        <script src="<?=ROOTPATH ?>owl/js/owl.carousel.min.js"></script> 
		 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    	<script>
            jQuery(document).ready(function($) {
                $('.js-example-basic-single').select2();
            });
        </script>
        <script>
    		
    		function openCity(cityName) {
                var i;
                var x = document.getElementsByClassName("city");
                for (i = 0; i < x.length; i++) {
                   x[i].style.display = "none";  
                }
                document.getElementById(cityName).style.display = "block";  
            }
    
            function ajax_proc(url, param, before_callback, success_callback, error_callback) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: param,
                        contentType: "application/x-www-form-urlencoded;",
                        dataType: "json",
                        beforeSend: function() {
                            if (before_callback != null) before_callback();
                        },
                        error: function(data) {
                            if (error_callback != null) error_callback(data);
                        },
                        success: function(data) {
                            if (success_callback != null) success_callback(data);
                        },
                        statusCode: {
                            404: function() {
                                alert('page not found');
                            }
                        }
                    });
                }
            $(document).ready(function(){
                    $(".login-form-submit").click(function(){
                        var url = '<?php echo ROOTPATH.API_DIR;?>/user_login';
                        var data =  "user_id=" + $(".user_id").val() + "&user_password=" + $(".user_password").val();
                        ajax_proc(url,data, function(){
                            $(".msgContent").text('');
                            $(".alert").addClass('fade').addClass('display-none');
                        },function(data){
                            var status = data.status;
                            var email = data.result.email;
                            if(status) {
                                window.location.href = '<?php echo ROOTPATH.$redirect;?>';
                            }
                            else{
                                var msg = data.result;
                                $(".msgContent").text(msg);
                                $(".alert").removeClass('fade').removeClass('display-none');
                            }
                        },function(data){
                            
                            console.log(data);
                        });
                    });
                });
        </script>
		
	
		
    </body>
</html>