<div class="col-md-4 col-sm-4">
                  <div class="right_block">
                     <div class="login_button">
                        <div class="btn"><a href="<?php echo site_url();?>/login"><img src="<?php echo site_url();?>/assets/star/login_img.png"/>login</a></div>
                        <p>Sign Up   Find ID / Password</p>
                     </div>
                     <div class="side_bar">
                        <h4>Recent reviews</h4>
						<?php 
						$CI =& get_instance();
						$reviews = $CI->restaurant_model->get_recent_restaurant_reviews();
						foreach($reviews as $review){
						?>
												
                        <div class="Recent_reviews">
                           <h3><?php echo $review->user_name;?></h3>
                           <p><?php echo $review->message;?></p>
                        </div>
						
						<?php } ?>
                       
                     </div>
                     <div class="right_block_img">
                        <a href="#"><img src="<?php echo site_url();?>/assets/star/right_block_img.jpg"/></a>
                     </div>
                  </div>
               </div>