<div class="home_wrapper">
         <div class="container">
            <div class="row">
               <div class="col-md-8 col-sm-8">
                  <div class="left_block">   
				 <div class="Food_blog_img">
				  <img src="<?php echo site_url();?><?php echo $blog_details->image;?>"/>
				 </div>
				 
				 <div class="list_back">
				 <p><?php echo $blog_details->title;?></p>
				 <div class="list_back_1">
				 <h5>Blog Content</h5>
				 <h6><?php echo $blog_details->content;?></h6>
				 </div>
				  <div class="list_back_1">
				 <h5>Published Date</h5>
				 <h6><?php echo $blog_details->posted_date;?></h6>
				 </div>
							 
				 </div>
				 			 

               </div>
               </div>
               <?php include_once(__DIR__."/../common/sidebar2.php");?>
            </div>
         </div>
      </div>
      </div>
