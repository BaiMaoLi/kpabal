<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome to CodeIgniter</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style type="text/css">
        input{
            width:100%;
            margin:5px;
        }
        select {
            margin: 5px;
            max-width: 200px;
            display: inline-block !important;
        }
	</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="../tinymce/jquery.tinymce.min.js" type="text/javascript"></script>

</head>
<body>
    <form method="post" action="./post_update">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <input type="text" name="title" placeholder="Title" class="form-control" value="<?=$data[0]['title']?>" />
                <input type="hidden" name="id" value="<?=$data[0]['id']?>" />
                <p>&nbsp;</p>
                <h4>회사정보</h4>
                <hr />
                <div class="col-sm-2">회사명:</div><div class="col-sm-10"><input type="text" name="company_name" class="form-control" value="<?=$data[0]['company_name']?>" /></div>
                <div class="col-sm-2">사업내용:</div><div class="col-sm-10"><input type="text" name="company_business" class="form-control" value="<?=$data[0]['company_business']?>" /></div>
                <div class="col-sm-2">지역:</div><div class="col-sm-10">
                    <select name="company_location" id="company_location" class="form-control">
                    	<?php
                    	foreach($locations as $location){
                    	?>
                    	<option value="<?=$location['id']?>" <?php if($data[0]['company_location']==$location['id']) echo "selected"; ?>><?=$location['name']?></option>
                    	<?php
                    	}
                    	?>
                    </select>
                </div>
                <div class="col-sm-2">회사주소:</div><div class="col-sm-10"><input type="text" name="company_address" class="form-control" value="<?=$data[0]['company_address']?>" /></div>
                <div class="col-sm-2">인근교통:</div><div class="col-sm-10"><input type="text" name="company_Traffic" class="form-control" value="<?=$data[0]['company_Traffic']?>" /></div>
                <div class="col-sm-2">홈페이지:</div><div class="col-sm-10"><input type="text" name="company_homepage" class="form-control" value="<?=$data[0]['company_homepage']?>" /></div>
                <div class="col-sm-2">전화번호:</div><div class="col-sm-10"><input type="text" name="company_phone" class="form-control" value="<?=$data[0]['company_phone']?>" /></div>
                
                <p>&nbsp;</p>
                <h4>채용정보</h4>
                <hr />
                <div class="col-sm-2">모집직종:</div><div class="col-sm-10">
                   <select name="careers_occupation1" id="careers_occupation1" class="form-control">
                    <?php 
                    foreach($p_cats as $p_cat){ 
                    ?>
                    <option value="<?=$p_cat['id']?>" <?php if($data[0]['category']==$p_cat['id']) echo "selected"; ?>><?=$p_cat['name']?></option>
                    <?php
                    }
                    ?>
                  </select>
                  <select name="careers_occupation2" id="careers_occupation2" class="form-control">
                    <?php 
                    foreach($s_cats as $s_cat){ 
                    ?>
                    <option value="<?=$s_cat['id']?>" <?php if($data[0]['subcat']==$s_cat['id']) echo "selected"; ?>><?=$s_cat['name']?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <div class="col-sm-2">담당업무:</div><div class="col-sm-10"><input type="text" name="careers_responsibilities" class="form-control" value="<?=$data[0]['careers_responsibilities']?>" /></div>
                <div class="col-sm-2">자격조건:</div><div class="col-sm-10"><input type="text" name="careers_qualifications" class="form-control" value="<?=$data[0]['careers_qualifications']?>" /></div>
                <div class="col-sm-2">급여:</div><div class="col-sm-10"><input type="text" name="careers_salary" class="form-control" value="<?=$data[0]['careers_salary']?>" /></div>
                <div class="col-sm-2">근무형태:</div><div class="col-sm-10">
                    <select name="careers_type" class="form-control">
                    <?php 
                    foreach($j_types as $j_type){ 
                    ?>
                    <option value="<?=$j_type['id']?>" <?php if($data[0]['careers_type']==$j_type['id']) echo "selected"; ?>><?=$j_type['name']?></option>
                    <?php
                    }
                    ?>
                    </select>
                </div>
                <div class="col-sm-2">근무시간:</div><div class="col-sm-10"><input type="text" name="careers_time" class="form-control" value="<?=$data[0]['careers_time']?>" /></div>
                <div class="col-sm-2">근무요일:</div><div class="col-sm-10"><input type="text" name="careers_weekly" class="form-control" value="<?=$data[0]['careers_weekly']?>" /></div>
                <div class="col-sm-2">채용담당:</div><div class="col-sm-10"><input type="text" name="careers_charge" class="form-control" value="<?=$data[0]['careers_charge']?>" /></div>
                <div class="col-sm-2">지원방법:</div><div class="col-sm-10"><input type="text" name="careers_method" class="form-control" value="<?=$data[0]['careers_method']?>" /></div>
                <div class="col-sm-2">등록마감:</div><div class="col-sm-10"><input type="text" name="careers_end" class="form-control" value="<?=$data[0]['careers_end']?>" /></div>
                <div class="col-sm-2">기타사항:</div><div class="col-sm-10"><input type="text" name="careers_etc" class="form-control" value="<?=$data[0]['careers_etc']?>" /></div>
                <p>&nbsp;</p>
                <textarea id="editor" name="content" ><?=$data[0]['content']?></textarea>
                <br />
                <p><button class="btn btn-primary">Update</button></p>
            </div>
        </div>
    </div>
    </form>

    <script>
    $(document).ready(function(){
        $("#careers_occupation1").change(function(){
            $.ajax({
                url: "./ajax_cat",
                type: "post",
                data:{"id":$("#careers_occupation1").val()},
                success: function(result){
                    $("#careers_occupation2").html(result);
                }
            });
        });
    });
    </script>
<script>
tinymce.init({
  selector: '#editor',
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste imagetools wordcount"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | table",
  // enable title field in the Image dialog
  image_title: true, 
  // enable automatic uploads of images represented by blob or data URIs
  automatic_uploads: true,
  // add custom filepicker only to Image dialog
  file_picker_types: 'image',
  file_picker_callback: function(cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');

    input.onchange = function() {
      var file = this.files[0];
      var reader = new FileReader();
      
      reader.onload = function () {
        var id = 'blobid' + (new Date()).getTime();
        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
        var base64 = reader.result.split(',')[1];
        var blobInfo = blobCache.create(id, file, base64);
        blobCache.add(blobInfo);

        // call the callback and populate the Title field with the file name
        cb(blobInfo.blobUri(), { title: file.name });
      };
      reader.readAsDataURL(file);
    };
    
    input.click();
  }
});
</script>
</body>
</html>