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
	#top-pan{
		        position: relative;
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
</style>

<div class="container">
	<div id="top-pan" class="row">
		<div class="col-xl-12"><??>
				<h2 id="video-title"><?php echo $video['title']?></h2>
				<?php //echo var_dump($video)?>
		</div>
		<div  class="col-xs-12 col-sm-12 col-lg-8" id="main-pan">
			
			<div id="video-dis" class="videw-view">
			</div>
		</div>
		<div id="similar-pan" class="col-xs-12 col-sm-12 col-lg-4">
			<div><h4>재생목록</h4></div>
			<!--<?php echo var_dump($videolist);?>-->
			<div id="play-list" class="row" style="height: auto!important;">
			</div>
		</div>
	</div>
	<div id="date" class="col-xs-12">
		<h5 ><?php echo substr($video['create_date'],0,10)?></h5>
	</div>
		<div><h4>관련동영상</h4></div>
		<div class="row" id="bottom-pan">
			<?php for($i=0;$i<count($videolist['relatedlist']);$i++){
					$item=$videolist['relatedlist'][$i];
					if ($item['image']=="")continue;
					?>
					
						<div class="video-card-body col-xs-12 col-sm-6 col-md-4 col-lg-3">
							<a href="<?php echo base_url()."Home/viewvideo/".$item['video_id'].'/'.$item['api_type']?>" target="">
							<img class="video-card-image" src="<?php echo $item['image']?>" width="100%" height="auto">
							<span class="video-card-title"><?php echo $item['title']?></span>
							<span class="video-card-title"><?php echo substr($item['create_date'],0,10)?></span>
							</a>
						</div>
					
			<?php }?>
			
		</div>
		<div id="button-popu">
				
		</div><br>
		<div><h4>댓글</h4></div>
		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="">
				<div id="commet_c">
					
					
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="">
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