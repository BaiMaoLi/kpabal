<?php 
	//echo var_dump($videodata); 
?>
<!DOCTYPE html>
<html>
<head>        
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600,700' rel='stylesheet' type='text/css'>
    <link href="<?=ROOTPATH ?>/assets/css/bootstrapTheme.css" rel="stylesheet">
    <link href="<?=ROOTPATH ?>/assets/css/custom.css" rel="stylesheet">
    <link href="<?=ROOTPATH ?>/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="<?=ROOTPATH ?>/owl-carousel/owl.theme.css" rel="stylesheet">
    
</head>
<body >
  <div class="container" style="padding-left: 40px;">
  	<div>
  		<nav aria-label="breadcrumb">
	      <ol class="breadcrumb" style="height: auto; position: static !important; padding: 0.75rem 1rem !important; margin: 0 0 1rem 0 !important; background-color: #e9ecef !important;">        
	        <label class="top">
			  <input type="radio" checked="checked" name="radio">
			  <span class="checkmark">SBS</span>
			</label>
			<label class="top">
			  <input type="radio" name="radio">
			  <span class="checkmark">MBC</span>
			</label>
			<label class="top">
			  <input type="radio" name="radio">
			  <span class="checkmark">Three</span>
			</label>
			<label class="top">
			  <input type="radio" name="radio">
			  <span class="checkmark">Four</span>
			</label>
	        
	      </ol>
	    </nav>
  	</div>
    <div class="row" id="bottom-pan">
			<?php for($i=0;$i<12;$i++){
					$item=$videodata[$i];
					//echo var_dump($item);
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
  </div>
</body>
    <script src="<?=ROOTPATH ?>/assets/js/jquery-1.9.1.min.js"></script> 
    <script src="<?=ROOTPATH ?>/owl-carousel/owl.carousel.js"></script>
    <style>
    	.top {

    padding-left: 10px;
    cursor: pointer;

}

/* Hide the browser's default radio button */
.top input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
    background-color: #eee;
}

/* On mouse-over, add a grey background color */
.top:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.top input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the indicator (dot/circle) when checked */
.top input:checked ~ .checkmark:after {
    display: block;
}

/* Style the indicator (dot/circle) */
.top .checkmark:after {
 	
	background: white;
}
    	.breadcrumb{

    	}
		
    	.breadcrumb-item{
    		cursor: pointer;
    	}
    	input:checked + .slider {
		  background-color: #2196F3;
		}

		input:focus + .slider {
		  box-shadow: 0 0 1px #2196F3;
		}
	      
	    .breadcrumb-item + .breadcrumb-item::before {
	          content: "|";
	      }
	      .breadcrumb-item.active {
	          color: blue;
	      }
	      
	      .breadcrumb-item:hover {
	          color: red;

	      }
    	#bottom-pan{
			max-height: 730px;
			overflow: auto;
			padding-left: 10px;
			padding-right: 10px;
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
		#video-title{
			text-align: center;
			line-height: 60px;
		    color: white;
	   		text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;
	   		animation-name: video-titile-frame;
	   		animation-duration: 2s;
	   		animation-iteration-count: infinite;
		}
		a{
			color: black;
		}
		a:hover{
			color:blue;
		}
    </style>


    <script>
	   $( ".checkmark" ).click(function() {
		  var monthname =  $(this).text();
   		  //console.log(monthname);
   		   $.ajax({
                    url:'<?php echo base_url(); ?>Home/getdata',
                    dataType : "json",
                    data: {'key': monthname,
                            'page':1},
                     type:'post',
                    success : function(data) {
                        //console.log(data);
                        // do something
                        var myhtmlcode="";
                        load_state++;
                        for (var i = data.length - 1; i >= 0; i--) {
                            htmlcode=
                            '<a class="as" href="'+"<?php echo base_url()?>"+'Home/viewvideo/'+data[i]['video_id']+'/'+data[i]['api_type']+'">'
                                 +'<div class="video-card-body row " style="padding-right: 2px!important,padding-left: 10px!important,width:100%"  >'
                                        +'<div class="col-4 child" style="float:left;" title='+'"'+data[i]['title']+'">'
                                             +'<img src="'+data[i]['image']+'"'+' width="96px" height="54px">'
                                        +'</div>'
                                        +'<div class="col-8 row" style="float:right;padding-left: 0px !important;padding-right:0px!important;">'
                                                +'<div class="col-12 " style="word-break: break-all!important;max-height: 40px;overflow: hidden;">'+data[i]['title']+'</div>'
                                                +'<div class="col-12" style="text-align: center;" >'+data[i]['create_date']+'</div>'
                                        +'</div>'
                                    +'</div>'
                            +'</a>';
                            myhtmlcode+=htmlcode;
                            console.log(htmlcode);
                            $('#bottom-pan').append(htmlcode);
                        }
                        
                        //document.getElementById('#play-list').innerHTML=htmlcode;
                    },
                    error : function(data) {
                        // do something
                        console.log("asdf");
                    }
                });
		});
      
  
    </script>
    <script src="<?=ROOTPATH ?>/assets/js/bootstrap-collapse.js"></script>
    <script src="<?=ROOTPATH ?>/assets/js/bootstrap-transition.js"></script>
    <script src="<?=ROOTPATH ?>/assets/js/bootstrap-tab.js"></script>

    <script src="<?=ROOTPATH ?>/assets/js/google-code-prettify/prettify.js"></script>
    <script src="<?=ROOTPATH ?>/assets/js/application.js"></script>

</html>

