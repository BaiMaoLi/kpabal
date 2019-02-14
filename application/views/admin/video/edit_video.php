
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Video</h3>
            </div>
        </div>
    </div>

    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">Edit Video</h3>
                    </div>
                </div>
                
            </div>
            <div class="m-portlet__body">

                <!--begin: Datatable -->
                <form method="post" action="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/video/update_product" enctype="multipart/form-data">
                    <input type="hidden" name="video_id" value="<?=$video_info['video_id']?>" />
                    <table class="table table-striped- table-bordered table-hover table-checkable data_table">
                        <tbody>
                        <tr>
                            <td style="width: 150px;">Player</td>
                            <td align="center">
                            	<?php
                            		if($video_info['api_type'] == 'Y'){
                            	?>
                                	<iframe width="420" height="345" src="https://www.youtube.com/embed/<?=$video_info['video_id']?>"></iframe>

                                <?php
                            		}else{
								?>
                            		<iframe frameborder="0" width="420" height="345" src="https://www.dailymotion.com/embed/video/<?=$video_info['video_id']?>?PARAMS" allowfullscreen allow="autoplay"></iframe>
                                
                                <?php
									}
                                ?>
                            </td>
                        </tr>	
                        <tr>
                            <td style="width: 150px;">Category</td>
                            <td>
                                <select  name="category" class="form-control" onchange="func(value)">
                                	
                                	<?php
                                    	//alert($main_cate);
                                    	foreach ($main_cate as $one) {
                                    	if($video_info['news_id'] != "0" ){
                                    ?>
                                        	<option value="<?=$one?>"<?php if($one == "news")echo "selected"?>><?=$one?></option>                                        	
                                     <?php
                                 		}else{
                                     ?>
											<option value="<?=$one?>"<?php if($one == $main_cate[$video_info['category_id']-1])echo "selected"?>><?=$one?></option>

                                    <?php
                                    	}
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td   style="width: 150px;">Sub Category</td>
                            <td>
                                <select id="select_id" name="subcategory" class="form-control">
                                	
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;"> Title</td><td><input type="text" name="title" class="form-control" value="<?=$video_info['title']?>" required /> </td>
                        </tr>
                        
                        </tbody>
                    </table>
                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	function func(main_category){
    	//console.log(<?php echo json_encode($main_cate); ?>);
    	var cate = <?php echo json_encode($categories); ?>;
    	var videoinfo = <?php echo json_encode($video_info); ?>;
    	var out = "";
        var i = 0;
        //console.log(cate);
        //console.log(videoinfo.news_id);
        if(main_category == 'news'){
        	var sub_cate = cate[main_category];
        	
	        for (i = 0; i < sub_cate.length; i++) {
	        	//console.log(cate_data[2]['news_name']);
	        	if((i+1) == videoinfo.news_id ){
	        		//console.log(videoinfo.news_id);
	        		out +='<option value="'+sub_cate[i]['news_name'] + '" selected>'+sub_cate[i]['news_name'] + '</option><br>';
	        	}
	            out +='<option value="'+sub_cate[i]['news_name'] + '">'+sub_cate[i]['news_name'] + '</option><br>';

	        }
	        document.getElementById("select_id").innerHTML = out;
		}
		else
		{
			var sub_cate = cate['country'];
			//console.log(sub_cate);
			//console.log(videoinfo.country_id);
			for (i = 0; i < sub_cate.length; i++) {
				if((i+1) == videoinfo.country_id)
					out += '<option value="' + sub_cate[i].country_name + '" selected>'+sub_cate[i].country_name + '</option><br>';

	            	out += '<option value="' + sub_cate[i].country_name + '">'+sub_cate[i].country_name + '</option><br>';
	                

	        }
	        document.getElementById("select_id").innerHTML = out;
		}
    }
    
    $(document).ready(function(){
    	
    	var main = <?php echo json_encode($main_cate); ?>;
    	var main_id = <?php echo json_encode($video_info['category_id']); ?>;
    	var main_cate = main[main_id-1];
    	if (main_id == '0')
    		main_cate = "news";
    		//main_id = <?php echo json_encode($video_info['news_id']); ?>;
    	//console.log(main);
    	//console.log(main_cate);
    	func(main_cate);
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#img_logo").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#product_logo").change(function(){
            readURL(this);
        });

    });

</script>