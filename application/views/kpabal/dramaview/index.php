<style type="text/css">
	#bottom-pan{
		max-height: 730px;
		overflow: auto;
		padding-left: 10px;
		padding-right: 10px;
	}
	.ytp-chrome-top .ytp-button, .ytp-chrome-controls .ytp-button, .ytp-replay-button {
    opacity: .9;
    display: none!important;
    width: 36px;
    -moz-transition: opacity .1s cubic-bezier(0.4,0.0,1,1);
    -webkit-transition: opacity .1s cubic-bezier(0.4,0.0,1,1);
    transition: opacity .1s cubic-bezier(0.4,0.0,1,1);
    overflow: hidden;
}
	#similar-pan{
		background-color: rgb(245,245,245);
		
	}
	
	#play-list{
		padding-left: 30px!important;
		position: relative;
		height: 100%;
		overflow: auto;
	}
	#date{
		text-align: center;
		}
	.list{
		float: inline-block;
		padding-top: 3px;

	}	
	.list:hover{
		background-color: rgb(200,200,200);
		border-radius: 8px;
	}
	.video-card-image{
		border-radius: 8px;
	}
	.video-card-body{
		padding-top: 10px;
		transition: .5s;
		text-align: center;
	}
	
	.video-card-body:hover{
		border-radius: 8px;
		background-color: rgba(100,100,100,.3);
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(10,10,10, 0.19);
   		text-align: center;
   		padding: 0px,0px,0px,0px;
	}
	
	.as{
		color: black;
	}
	.as:hover{
		color:blue;
	}
	
	#video-title{
		text-align: center;
		line-height: 60px;
	    color: white;
   		text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;
   		animation-name: video-titile-frame;
   		animation-duration: 2s;
   		animation-iteration-count: infinite;
	}
	@keyframes video-titile-frame {
    	0% {color: red;}
    	50% {color: yellow;}
    	100%{color: red;}
	}
	#popup-video{
		position: fixed;
		width: 400px;
		height: 200px;
		bottom: 10%;
		right: 10%;
		display: none;
	}
	.preload-img{
		position: absolute;
		text-align: center;
	
		  top: 50%;
		  width: 100%;
		  height: auto;
		  margin-left: -32px; /* -1 * image width / 2 */
		  margin-top: -32px; /* -1 * image height / 2 */
	}
	#preload-pan{
		position: fixed;
		display: none;
		width: 100%;
		height: 100%;
		top: 0%;
		left: 0%;
		background-color: rgba(255,255,255,0);
		align-items: center;
		
	}
	.center {
          position: absolute;
          right: 3%;
   
      }
      .textc{
      	width: 100%; /* Full width */
	    padding: 12px; /* Some padding */  
	    border: 1px solid #ccc; /* Gray border */
	    border-radius: 4px; /* Rounded borders */
	    box-sizing: border-box; /* Make sure that padding and width stays in place */
	    margin-top: 6px; /* Add a top margin */
	    margin-bottom: 16px; /* Bottom margin */
	    resize: vertical /* Allow the user to vertically resize the textarea (not horizontally) */
      }
      input[type=text], select, textarea {
	    width: 100%; /* Full width */
	    padding: 12px; /* Some padding */  
	    border: 1px solid #ccc; /* Gray border */
	    border-radius: 4px; /* Rounded borders */
	    box-sizing: border-box; /* Make sure that padding and width stays in place */
	    margin-top: 6px; /* Add a top margin */
	    margin-bottom: 16px; /* Bottom margin */
	    resize: vertical /* Allow the user to vertically resize the textarea (not horizontally) */
	}
      input[type=submit] {
		    background-color: #4CAF50;
		    color: white;
		    padding: 6px 10px;
		    border: none;
		    border-radius: 4px;
		    cursor: pointer;
		}
		input[type=submit]:hover {
		    background-color: #45a049;
		}
	
	 {

	}
	h4{
		margin-bottom: 100px;
	}
	#top-pan{
		margin-top:  50px !important;
		margin-right: 0 !important;
		position: relative;
	}
	#main-pan{
		position: relative;
		text-align: center;
	}
	iframe {
			
			left:10px;
			right: 10px;
		}

	@media only screen and (max-width: 2300px){
    	iframe {
			width: 724px;
			height: 520px;
			left:10px;
			right: 10px;
		}
	}
	@media only screen and (min-width: 800px){
    	iframe {
			width: 724px;
			height: 500px;
			left: 10px;
			right: 10px;
		}
	}
	@media only screen and (max-width: 724px){
    	iframe {
			width: 524px;
			height: 320px;
			left: 10px;
			right: 10px;
		}
	}
	@media only screen and (max-width: 624px){
    	iframe {
			width: 524px;
			height: 320px;
			left: 10px;
			right: 10px;
		}
	}		
	@media only screen and (max-width: 524px){
    	iframe {
			width: 400px;
			height: 300px;
			left: 10px;
			right: 10px;
		}
	}
	.link-btn{
       padding-left: 15px !important;
	}		
	h3{
       margin-left: 15px !important;
       
	}
	button .btn.btn-primary.active {
		margin-bottom:  25px !important;
	}
	.detail-main-view{
		margin: auto;
	}

	.btn-link{
		outline: none;
		background: #eee;
		color: #000;
		transition: all 0.3s;
	}

	.btn-link a{
		color: #000;
	}

	.btn-link a:hover{
		text-decoration: !important;
	}

	.btn-link:hover{
		background: #fff;
		border: rgb(168, 19, 214) solid 1px;

	}
	.relative-title{
		font-size: 28px;
		color: rgb(168, 19, 214);
		margin-bottom: 15px;
	}
	.video-card-title{
		color: rgb(133, 5, 140);
		margin-top: 10px;
	    white-space: nowrap;
	    overflow: hidden;
	    text-overflow: ellipsis;
	    -o-text-overflow: ellipsis;
	}
</style>
<script >
	
</script>

<div class="container">
	<div id="top-pan" class="row">
		<div class="col-xl-12 " id="title" >
				<h3 id="video-title"><?php echo $video['sel_video']['scrap_title']?></h3>
				<?php //echo var_dump($video)?>
		</div>
		<div  class="col-xs-12 col-sm-12 col-lg-12" id="main-pan">
			
			<!-- <div id="video-dis" class="videw-view"></div> -->
			<!-- <div id="video-dis" class="videw-view"> -->
				<!-- <?php var_dump($video['sel_video']['scrap_url']);  ?> -->
			<iframe class="detail-main-view"  src="<?php echo $video['sel_video']['scrap_url']?>"></iframe>	
			<!-- </div> -->
			
		</div>
		<!-- <div id="similar-pan" class="col-xs-12 col-sm-12 col-lg-4"> -->
			<!-- <div><h4>재생목록</h4></div>
			<?php //echo var_dump($videolist);?> -->
			<!-- <div id="play-list" class="row" style="height: auto!important;"> -->
		<!-- </div> -->

	</div>
	<div id="date" class="col-xs-12">
			<!-- <h4 ><?php echo ($video['sel_video']['scrap_date'])?></h4> -->
	</div>	
</div>
	<div class="link-btn mt-3">
		<?php
			foreach ($video['sames'] as $link) {
		?>
				<button type="button" class="btn btn-link" style = "margin: 0 20px 25px 0;"><a href="<?php echo base_url()."Home/dramaview/".$link['scrap_id']?>"><?php echo $link['scrap_sub_link']?></a></button>
		<?php	
			}
		?>
		<hr>
	</div>
		<div class="relative-title">관련동영상</div>
		<div class="row" id="bottom-pan">

			<?php for($i = 0; $i < count($video['seores']); $i++){
					$item=$video['seores'][$i];
					?>
						<div class="video-card-body col-xs-12 col-sm-6 col-md-4 col-lg-3">
							<a href="<?php echo base_url()."Home/dramaview/".$item['scrap_id']?>" target="">
							<img class="video-card-image" src="<?php 
								if(empty($item['image_url'])) echo base_url().'assets/images/default_image.jpg';
                                 else echo $item['image_url'];
							?>" width="100%" height="auto">
							<p class="video-card-title tru" title="<?php echo $item['scrap_title'].' '.$item['scrap_date'];?>"><?php echo $item['scrap_title'].' '.$item['scrap_date'];?></p>
 							<!--<span class="video-card-title"><?php echo $item['scrap_title']?></span>
							<span class="video-card-title"><?php echo $item['scrap_date']?></span> -->
							</a>
						</div>
			<?php }?>
		</div>
		<div id="button-popu">
				
		</div><br>
		
		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="">
				<div id="commet_c">
					
					
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="">
				<div><h3>댓글</h3><br></div>
				<label for="fname"><i class="fa fa-user"></i> Full Name</label>
	            <input type="text" id="fname" name="firstname" placeholder="John M. Doe"><br>
	            <label for="email"><i class="fa fa-envelope"></i> Email</label>
	            <input type="text" id="email" name="email" placeholder="john@example.com"><br>
	            <div style="width: 100%">
	            	<label for="subject">Subject</label>
					<input id="submit1" type="submit" value="Submit" class="center"><br>
	            </div>
				
    			<textarea id="subject" name="subject" placeholder="Write something.." style="height:200px;width: 100%"></textarea><br>
    			
			</div>
		</div>

</div>
<div id="popup-video" class="videw-view">

</div>
<div id="preload-pan">
    <div class="preload-img">
        <img src="<?php echo base_url()?>themes/withyou/images/loading-transparent-ajax-loader-5.gif" width="10%" height="auto" >
	    <p>Connecting...</p>
    </div>
	
	
</div>