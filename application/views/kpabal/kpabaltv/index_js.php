  <script type="text/javascript">
        var monthname="";
        var categoryname="";
        var currentpage=1;
        var item_count=12;
        var data2 = ["JavaScript", "Swift", "Python", "Java", "C++", "Ruby", "Rust", "Elixir", "Scala", "PHP"];
          var page_count=10;
          $("#pager2").motypager({
              norefresh: true,
              pc_style: true,
              clicked: function(index, update) {
                  $('#span2').text(data2[index - 1]);
                  update(page_count.toFixed(0)+1);
                  //alert(page_count.toFixed(0));
                  $.ajax({
                          url:'<?php echo base_url(); ?>Home/pagination',
                          dataType : "json",
                          data: {'cate_name': monthname.replace(/\s/g, ''),
                                  'sub_name':categoryname,
                                  'limit_count':12,
                                  'page_number':index},
                           type:'post',
                          success : function(data) {
                              //console.log(data['categoryname']);
                              // do something
                              if(data['video'][0] !== undefined && data['video'][0]['scrap_id'] == undefined) {
                                $('.video-card-body').remove();
                                var myhtmlcode="";
                                
                                for (var i = data['video'].length - 1; i >= 0; i--) {
                                    var item=data['video'][i];
                                    //console.log(item);
                                    htmlcode=
                                    '<div class="video-card-body col-xs-12 col-sm-6 col-md-4 col-lg-3">'+
                                      
                                     '<a class="as" href="'+"<?php echo base_url()?>"+'Home/viewvideo/'+item['video_id']+'/'+item['api_type']+'">'+
                                         '<img src="'+item['image']+'"'+' width="100%" height="auto">'+
                                         '<span class="video-card-title">'+item['title']+'</span>'+
                                         '<span class="video-card-title">'+item['create_date']+'</span>'+
                                      '</a>'+
                                    '</div>';
                                    myhtmlcode+=htmlcode;
                                    //console.log(htmlcode);
                                    $('#video-pan').append(htmlcode);
                                }
                              }else{
                                $("#sel1").css("display","none");
                                $('.video-card-body').remove();
                                var myhtmlcode="";
                                
                                for (var i = data['video'].length - 1; i >= 0; i--) {
                                    var item=data['video'][i];
                                    if(item['image_url'] == "")
                                      item['image_url'] = "<?=ROOTPATH ?>/assets/images/default_image.jpg";
                                    //console.log(item);
                                    //console.log(item);
                                    htmlcode=
                                    '<div class="video-card-body col-xs-12 col-sm-6 col-md-4 col-lg-3">'+
                                      
                                     '<a class="as" href="'+"<?php echo base_url()?>"+'Home/dramaview/'+item['scrap_id']+'">'+
                                         '<img src="'+item['image_url']+'"'+' width="100%" height="auto">'+
                                         '<span class="video-card-title">'+item['scrap_title']+'</span>'+
                                         '<span class="video-card-title">'+item['scrap_date']+'</span>'+
                                      '</a>'+
                                    '</div>';
                                    myhtmlcode+=htmlcode;
                                    //console.log(htmlcode);
                                    $('#video-pan').append(htmlcode);
                                }
                              }
                          },
                          error : function(data) {
                              // do something
                              console.log("asdf");
                          }
                  });

              }
          }).motypager("pageTo", 1);
          
          $('select').on('change', function() {
            categoryname=this.value;
            $("#pager2").motypager("pageTo", 1);
              //alert( categoryname );
              $.ajax({
                          url:'<?php echo base_url(); ?>Home/pagination',
                          dataType : "json",
                          data: {'cate_name': monthname.replace(/\s/g, ''),
                                  'sub_name':categoryname,
                                  'limit_count':12,
                                  'page_number':1},
                           type:'post',
                          success : function(data) {
                              //console.log(data['category']);
                              // do something
                              $('.video-card-body').remove();
                              var myhtmlcode="";
                              page_count=data['total_count']/item_count;
                              for (var i = data['video'].length - 1; i >= 0; i--) {
                                  var item=data['video'][i];
                                  //console.log(item);
                                  htmlcode=
                                  '<div class="video-card-body col-xs-12 col-sm-6 col-md-4 col-lg-3">'+
                                   '<a class="as" href="'+"<?php echo base_url()?>"+'Home/viewvideo/'+item['video_id']+'/'+item['api_type']+'">'+
                                       '<img src="'+item['image']+'"'+' width="100%" height="auto">'+
                                       '<span class="video-card-title">'+item['title']+'</span>'+
                                       '<span class="video-card-title">'+item['create_date']+'</span>'+
                                    '</a>'+
                                  '</div>';
                                  myhtmlcode+=htmlcode;
                                  //console.log(htmlcode);
                                  $('#video-pan').append(htmlcode);
                              }
                              
                              //document.getElementById('#play-list').innerHTML=htmlcode;
                          },
                          error : function(data) {
                              // do something
                              console.log("asdf");
                          }
              });
            });
                     
          $( ".breadcrumb-item" ).click(function() {
              monthname =  $(this).text();
              console.log(monthname.replace(/\s/g, ''));
              if (monthname=="All") {
                $("#main_pan").css("display","block");
                $("#grid-pan").css("display","none");
                $("#sel1").css("display","none");
              }
              else{
                $("#main_pan").css("display","none");
                $("#grid-pan").css("display","block");
                $("#sel1").css("display","block");
              }
              $("li").css("color","black");
              $(this).css("color","#ff1c77");
              
              $.ajax({
                          url:'<?php echo base_url(); ?>Home/pagination',
                          dataType : "json",
                          data: {'cate_name': monthname.replace(/\s/g, ''),
                                  'sub_name':'',
                                  'limit_count':12,
                                  'page_number':1},
                           type:'post',
                          success : function(data) {
                              //console.log(data['video'][0]['scrap_id']);
                              // do something
                            if(data['video'][0]['scrap_id'] == undefined) {
                              $('option').remove();
                              
                                for (var i = 0; i < data['category'].length ; i++) {
                                  var item=data['category'][i];
                                  var htmlcode=' <option class="selitem">'+item+'</option>'
                                  $('#sel1').append(htmlcode);
                                }

                                $('.video-card-body').remove();
                                var myhtmlcode="";
                                page_count=data['total_count']/item_count;
                                for (var i = (data['video'].length - 1)<item_count?data['video'].length - 1 :item_count-1; i >= 0; i--) {
                                    var item=data['video'][i];
                                    //console.log(item);
                                    htmlcode=
                                    '<div class="video-card-body col-xs-12 col-sm-6 col-md-4 col-lg-3">'+
                                     '<a class="as" href="'+"<?php echo base_url()?>"+'Home/viewvideo/'+item['video_id']+'/'+item['api_type']+'">'+
                                         '<img src="'+item['image']+'"'+' width="100%" height="auto">'+
                                         '<span class="video-card-title">'+item['title']+'</span>'+
                                         '<span class="video-card-title">'+item['create_date']+'</span>'+
                                      '</a>'+
                                    '</div>';
                                    myhtmlcode+=htmlcode;
                                    $('#video-pan').append(htmlcode);
                                }
                              }else{
                                $("#sel1").css("display","none");
                                $('.video-card-body').remove();
                                var myhtmlcode="";
                                page_count=data['total_count']/item_count;
                                for (var i = (data['video'].length - 1)<item_count?data['video'].length - 1 :item_count-1; i >= 0; i--) {
                                    var item=data['video'][i];
                                    if(item['image_url'] == "")
                                      item['image_url'] = "<?=ROOTPATH ?>/assets/images/default_image.jpg";
                                    //console.log(item);
                                    //console.log(item);
                                    htmlcode=
                                    '<div class="video-card-body col-xs-12 col-sm-6 col-md-4 col-lg-3">'+
                                     '<a class="as" href="'+"<?php echo base_url()?>"+'Home/dramaview/'+item['scrap_id']+'">'+
                                         '<img src="'+item['image_url']+'"'+' width="100%" height="auto">'+
                                         '<span class="video-card-title">'+item['scrap_title']+'</span>'+
                                         '<span class="video-card-title">'+item['scrap_date']+'</span>'+
                                      '</a>'+
                                    '</div>';
                                    myhtmlcode+=htmlcode;
                                    //console.log(htmlcode);
                                    $('#video-pan').append(htmlcode);
                                }
                            }
                          },
                          error : function(data) {
                              // do something
                              console.log("asdf");
                          }
                      });
          });
          
          $( ".drama-item" ).click(function() {
            
            monthname =  $(this).text();

              console.log(monthname.replace(/\s/g, ''));
              if (monthname=="All") {
                $("#main_pan").css("display","block");
                $("#grid-pan").css("display","none");
                $("#sel1").css("display","none");
              }
              else{
                $("#main_pan").css("display","none");
                $("#grid-pan").css("display","block");
                $("#sel1").css("display","block");
              }
              $("li").css("color","black");
              $(this).css("color","#ff1c77");
              
              $.ajax({
                          url:'<?php echo base_url(); ?>Home/drama_pagination',
                          dataType : "json",
                          data: { 'limit_count':12,
                                  'page_number':1},
                           type:'post',
                          success : function(data) {
                              //console.log(data['category']);
                              // do something
                              $('option').remove();
                              for (var i = 0; i < data['category'].length ; i++) {
                                var item=data['category'][i];
                                var htmlcode=' <option class="selitem">'+item+'</option>'
                                $('#sel1').append(htmlcode);
                              }

                              $('.video-card-body').remove();
                              var myhtmlcode="";
                              page_count=data['total_count']/item_count;
                              for (var i = (data['video'].length - 1)<item_count?data['video'].length - 1 :item_count-1; i >= 0; i--) {
                                  var item=data['video'][i];
                                  //console.log(item);
                                  htmlcode=
                                  '<div class="video-card-body col-xs-12 col-sm-6 col-md-4 col-lg-3">'+
                                    
                                   '<a class="as" href="'+"<?php echo base_url()?>"+'Home/viewvideo/'+item['video_id']+'/'+item['api_type']+'">'+
                                       '<img src="'+item['image']+'"'+' width="100%" height="auto">'+
                                       '<span class="video-card-title">'+item['title']+'</span>'+
                                       '<span class="video-card-title">'+item['create_date']+'</span>'+
                                    '</a>'+
                                  '</div>';
                                  myhtmlcode+=htmlcode;
                                  //console.log(htmlcode);
                                  $('#video-pan').append(htmlcode);
                              }
                              
                              //document.getElementById('#play-list').innerHTML=htmlcode;
                          },
                          error : function(data) {
                              // do something
                              console.log("asdf");
                          }
              });
          });
          
          function showPreloader(){
              
          }
          
          function hidePreloader(){
              
          }
  </script>
  <script>

    $(document).ready(function() {
      $("#grid-pan").css("display","none");
      $("#sel1").css("display","none");
    //   $("#owl-demo").owlCarousel({
    //       autoplay: 2000, //Set AutoPlay to 3 seconds
    //       autoplayHoverPause: true,
    //       nav: false,
    //       dots: false,    
    //       items : 1, 
    //       loop: true,
    //       animateIn: "pulse"
    //   });
      $(".owl-demo1").owlCarousel({
        dots: false,
        nav: false,
        loop: true,
        autoWidth: true
      });
    });
    
  </script>
  
  
<script>
		var tpj=jQuery;
		var revapi113;
		tpj(document).ready(function() {
			tpj('#rev_slider_113_1').find('li').each(function() {
				var li = jQuery(this),
					o = new Object();
				o = jQuery.extend(o,li.data());
				li.data('saved',o);
			});

			if(tpj("#rev_slider_113_1").revolution == undefined){
				revslider_showDoubleJqueryError("#rev_slider_113_1");
			}else{
				revapi113 = tpj("#rev_slider_113_1").show().revolution({
					sliderType:"standard",
					jsFileLocation:"include/rs-plugin/js/",
					sliderLayout:"auto",
					dottedOverlay:"none",
					delay:5000,
					navigation: {
						keyboardNavigation:"off",
						keyboard_direction: "horizontal",
						mouseScrollNavigation:"off",
						onHoverStop:"off",
						arrows: {
							style:"uranus",
							enable:true,
							hide_onmobile:false,
							hide_under:200,
							hide_onleave:true,
							hide_delay:200,
							hide_delay_mobile:1200,
							tmp:'<div class="tp-arr-allwrapper">	<div class="tp-arr-imgholder"></div></div>',
							left: {
								h_align:"left",
								v_align:"center",
								h_offset:20,
								v_offset:0
							},
							right: {
								h_align:"right",
								v_align:"center",
								h_offset:20,
								v_offset:0
							}
						}
						,
						touch:{
							touchenabled:"on",
							swipe_threshold: 75,
							swipe_min_touches: 1,
							swipe_direction: "horizontal",
							drag_block_vertical: false
						}
					},
					gridwidth:830,
					gridheight:492,
					lazyType:"single",
					shadow:0,
					spinner:"off",
					stopLoop:"on",
					stopAfterLoops:1,
					stopAtSlide:1,
					shuffle:"off",
					autoHeight:"off",
					disableProgressBar:"off",
					hideThumbsOnMobile:"on",
					hideSliderAtLimit:0,
					hideCaptionAtLimit:0,
					hideAllCaptionAtLilmit:0,
					debugMode:false,
					fallbacks: {
						simplifyAll:"off",
						nextSlideOnWindowFocus:"off",
						disableFocusListener:false,
					}
				});
			}

			revapi113.bind('revolution.slide.onafterswap',function (e,d) {
				console.log("Slider After Swap");
				console.log(d.currentslide.data());
				var datas,txt;
				txt = "";
				jQuery.each(d.currentslide.data('saved'),function(k,v) {
					if (k!==undefined)
					txt="<strong>data-"+k+"=</strong>'"+v+"' "+txt;
				});
				txt = '<span class="markup">&lt;li </span>' + txt + '<span class="markup">&gt;</span><br>';
				txt = txt+'&nbsp;&nbsp;<span class="markup">&lt;img</span> <strong>src=</strong>"include/rs-plugin/demos/assets/images/newscarousel6.jpg"  <strong>alt=</strong>"" <strong>data-bgposition=</strong>"center center" <strong>data-bgfit=</strong>"cover" <strong>data-bgrepeat=</strong>"no-repeat" <strong>class=</strong>"rev-slidebg" <span class="markup">&gt;</span><br>';
				txt = txt+'<span class="markup">&lt;/li&gt;</span>';
				jQuery('#selected-transition').html(txt);

			});
		});	/*ready*/
</script>