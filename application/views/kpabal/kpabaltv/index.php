  <?php
    $animates = ["bounce", "pulse", "rubberBand", "tada", "jello", "bounceIn", "fadeIn", "fadeInRight", "flipInX", "flipInY", "lightSpeedIn", "rotateInDownRight", "slideInRight", "zoomIn", "jackInTheBox"];
  ?>
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bread-sub-cate" style="">        
        <li class="breadcrumb-item active" aria-current="page">All</li>
        <li class="breadcrumb-item">
          News
        </li>
        <li class="breadcrumb-item">
          Drama
        </li>
        <li class="breadcrumb-item">
          Sport
        </li>
        <li class="breadcrumb-item">
          Music
        </li>
        <li class="breadcrumb-item">
          Trending
        </li>
          <select class="sel-sub-cate" id="sel1" name="sellist1"></select>
      </ol>
    </nav>
    <div id="main_pan">
      <!-- Main Video -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
    			<div id="rev_slider_113_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="slide-transitions" style="margin:0px auto;background-color:#000000;padding:0px;margin-top:0px;margin-bottom:0px;">
    				<!-- START REVOLUTION SLIDER 5.0.7 auto mode -->
    				<div id="rev_slider_113_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.0.7">
    					<ul>	<!-- SLIDE  -->
                          <?php 
                            $item=$kpabal['popular'];
                            $index = 341;
                            for ($i=0; $i < count($item) ; $i++) {
                              $videodata=$item[$i];
                              $animate_len = count($animates);
                              $animate = $animates[rand(0,$animate_len -1)];
                              $index++;
                              $rs_transitions = ["fade", "boxslide", "slotslide-horizontal", "slotslide-vertical"
                                        , "boxfade", "fadetoleftfadefromright", "flyin", "curtain-1", "curtain-2"
                                        , "curtain-3", "3dcurtain-horizontal", "3dcurtain-vertical", "cube"
                                        , "cube-horizontal", "incube", "incube-horizontal", "turnoff", "turnoff-vertical"
                                        , "papercut", "parallaxtobottom"];
                              $current_transition = rand(0, count($rs_transitions) - 1);
                              $link = base_url()."Home/viewvideo/".$videodata['video_id'].'/'.$videodata['api_type'];
                          ?>
    						<li data-index="rs-<?php echo $index;?>" data-transition="<?php echo $rs_transitions[$current_transition];?>" data-slotamount="default"  data-easein="default" data-easeout="default" data-masterspeed="default" data-rotate="0"  data-title="Fade" data-description=""
    						 onclick="window.location = '<?php echo $link;?>';">
    							<!-- MAIN IMAGE -->
    							<img src="<?php echo $videodata['image']?>"  alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" >
    							<div style="position: absolute;bottom:0px; left: 0px; width: 100%;height:30px;background: rgba(0,0,0,0.7);z-index: 100;padding: 5px 20px 5px 20px;">
    								<p style="display:block;overflow:hidden; text-overflow:ellipsis;white-space:nowrap; font-size: 18px; color: #ccc;"><?php echo $videodata['title']?></p>
    							</div>
    							<!-- LAYERS -->
    						</li>
                          <?php 
                          }
                          ?>
    					</ul>
    					<div class="tp-bannertimer" style="height: 3px; background: rgb(206, 16, 95);"></div>
    				</div>
    			</div><!-- END REVOLUTION SLIDER -->
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4" >
              <div class="total-list" style="margin-left: -20px!important;">
                <ul class="nav nav-tabs nav-justified week-brief-tabs" style="margin-bottom:0px; margin-top:0px;"  role="tablist">
                    <?php 
                    for($i=0;$i<count($date);$i++){ ?>
                        <?php $i==0?$s=' active':$s='';
                            ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $s;?>" href="" data-target="<?php echo '#week-brief-'.$i;?>" href="#week-brief-<?php echo $i;?>" data-toggle="tab">
                                <h6 class="margin-top-0 margin-bottom-5 weekday" style="margin-bottom: 0;margin-top: 0;"><?php echo $date[$i]['weekday'];?></h6>
                                <h6 class="margin-top-0 margin-bottom-5 week-date" style="margin-bottom: 0; "><?php echo $date[$i]['date'];?></h6>
                            </a>
                        </li>
                    <?php }?>
                </ul>
                <div class="tab-content">
                    <?php 
                    ///******sidevideo********////
                    $keys = array("drama", "news", "sport","music");
                    $icon = array("fas fa-film", "fas fa-newspaper", "fas fa-futbol", "fas fa-music");
                    //print_r(var_dump(count($keys)));
                    for($j = 0; $j < count($date); $j++) {
                       $j == 0 ? $s = ' fade in active ': $s = '';
                    ?>
                    <div id="week-brief-<?=$j?>" class="tab-pane <?php echo $s;?>">
                        <ul style="margin: 0 0 0 0;" class="columns" data-columns="2">
                            
                            <?php
                              for ($l = 0; $l < count($keys); $l++) {
                                // print_r(var_dump($sidevideo[$keys[$l]][$j]));

                                $video_arr = $sidevideo[$keys[$l]][$j];
                                if(!empty($video_arr)) {
                            ?>
                                <li><i class="<?php echo $icon[$l];?>"><?php echo " ".$keys[$l]?></i></li>
                            <?php
                                  for($k = 0; $k < (count($video_arr) > 5 ? 5:count($video_arr)); $k++){
                            ?>
                                <li class="week-subtitle">
                                  <?php
                                    $keys[$l] == 'drama' ? $url = base_url()."Home/dramaview/".$video_arr[$k]['scrap_id']: $url = base_url()."Home/viewvideo/".$video_arr[$k]['video_id'].'/'.$video_arr[$k]['api_type'];
                                    $keys[$l] == 'drama' ? $title = $video_arr[$k]['scrap_title'] : $title = $video_arr[$k]['title'];
                                  ?>
                                  <a href="<?php echo $url?>" ><span class="margin-top-0 margin-bottom-5 truncated" ><?php echo '• '.$title;?></span></a>
                                </li>   
                            <?php
                                }
                              }
                             }  
                            ?>
                            
                        </ul>
                    </div>
                    <?php 
                    }
                    ?>
                </div>
              </div>
            </div>
        </div>

      <!-- News -->
      <div>
        <i class="far fa-newspaper category-prefix" ></i>
        <span class="category-title">News</span>
      </div>
      <?php //echo var_dump($kpabal['news']['SBS'])?>
      <div class="owl-carousel owl-theme owl-demo-style owl-demo1">
        <?php 
          $item=$kpabal['news'];
          for ($i=0; $i < count($item) ; $i++) { 
            $videodata=$item[$i];
            //echo $videodata['image'];
          ?>
          <a href="<?php echo base_url()."Home/viewvideo/".$videodata['video_id'].'/'.$videodata['api_type']?>">
            <div class="item one-category">
              <img class="video-rect" src="<?php echo $videodata['image']?>" alt="The Last of us">
              <h6 class="title truncated"><?php echo $videodata['title']?></h6>
            </div>
          </a>
        <?php }?>
      </div>
     
     <!-- Drama -->
      <div>
        <i class="fas fa-video category-prefix" ></i>
        <span class="category-title">Drama</span>
      </div>
      <?php //echo var_dump($kpabal['news']['SBS'])?>
      <div id="" class="owl-carousel owl-theme owl-demo-style owl-demo1">
        <?php 
          $item=$kpabal['drama'];
          for ($i=0; $i < count($item) ; $i++) { 
            $videodata=$item[$i];
            //echo $videodata['image'];
        ?>
            <a href="<?php echo base_url()."Home/dramaview/".$videodata['scrap_id']?>">
              <div class="item">
                <img class="video-rect" src="<?php 
                if(empty($videodata['image_url'])) echo base_url().'assets/images/default_image.jpg';
                else echo $videodata['image_url'];
                ?>" alt="The Last of us">
                <h6 class="title truncated"><?php echo $videodata['scrap_title']?></h6>
              </div>
            </a>
        <?php }?>
      </div>

      <!-- Sports -->
      <div>
        <i class="fas fa-trophy category-prefix" ></i>
        <span class="category-title">Sports</span>
      </div>
      <?php //echo var_dump($kpabal['news']['SBS'])?>
      <div id="" class="owl-carousel owl-theme owl-demo-style owl-demo1">
        <?php 
          $item=$kpabal['sport'];
          for ($i=0; $i < count($item) ; $i++) { 
            $videodata=$item[$i];
            //echo $videodata['image'];
        ?>
            <a href="<?php echo base_url()."Home/viewvideo/".$videodata['video_id'].'/'.$videodata['api_type']?>">
              <div class="item">
                <img class="video-rect" src="<?php echo $videodata['image']?>" alt="The Last of us">
                <h6 class="title truncated"><?php echo $videodata['title']?></h6>
              </div>
            </a>
        <?php }?>
      </div>

      <!-- Music -->
      <div>
        <i class="fas fa-music category-prefix" ></i>
        <span class="category-title">Music</span>
      </div>
      <div id="" class="owl-carousel owl-theme owl-demo-style owl-demo1">
        <?php 
          $item=$kpabal['music'];
          for ($i=0; $i < count($item) ; $i++) { 
            $videodata=$item[$i];
            //echo $videodata['image'];
        ?>
            <a href="<?php echo base_url()."Home/viewvideo/".$videodata['video_id'].'/'.$videodata['api_type']?>">
              <div class="item">
                <img class="video-rect" src="<?php echo $videodata['image']?>" alt="The Last of us">
                <h6 class="title truncated"><?php echo $videodata['title']?></h6>
              </div>
            </a>
        <?php }?>
      </div>

      <!-- Trending -->
      <div>
        <i class="far fa-thumbs-up category-prefix" ></i>
        <span class="category-title">Trending</span>
      </div>
      <?php //echo var_dump($kpabal['news']['SBS'])?>
      <div id="" class="owl-carousel owl-theme owl-demo-style owl-demo1">
        <?php 
          $item=$kpabal['trending'];
          for ($i=0; $i < count($item) ; $i++) { 
            $videodata=$item[$i];
            //echo $videodata['image'];
        ?>
            <a href="<?php echo base_url()."Home/viewvideo/".$videodata['video_id'].'/'.$videodata['api_type']?>">
              <div class="item">
                <img class="video-rect" src="<?php echo $videodata['image']?>" alt="The Last of us">
                <h6 class="title truncated"><?php echo $videodata['title']?></h6>
              </div>
            </a>
        <?php }?>
      </div>
    </div>

    <!-- End of Main Pan -->
    <div id="grid-pan">
      <div id="video-pan" class="row" style="padding-left: 30px"></div>
      <div class="center">
        <p style="margin: 20px">
         <div id="pager2"></div>
        </p>
      </div>
    </div>
    <!--    Preloader  -->
</div>
    
  <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
  <script type="text/javascript" src="<?=ROOTPATH ?>/assets/js/motypager-2.0.js"></script>
  <script type="text/javascript" src="<?=ROOTPATH ?>/assets/js/motypager-2.0.min.js"></script>
  <!--<script src="<?=ROOTPATH ?>owl/js/owl.carousel.min.js"></script>  -->
  <script src="<?=ROOTPATH ?>assets/js/bootstrap-transition.js"></script>
  <!--<script src="<?=ROOTPATH ?>assets/js/bootstrap-tab.js"></script>-->
  <script src="<?=ROOTPATH ?>assets/js/google-code-prettify/prettify.js"></script>
  <script src="<?=ROOTPATH ?>assets/js/application.js"></script>



