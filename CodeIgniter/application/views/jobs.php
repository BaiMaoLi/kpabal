<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome to CodeIgniter</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<style type="text/css">
        input,textarea{
            width:100%;
            margin:5px;
        }
        select{
            margin:5px;
        }
	</style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <form name="frm" method="post" style="margin:0px">
                    <div class="col-sm-2">
            			직종 분류 :
                        <select name="careers_occupation1" id="careers_occupation1" class="form-control">
                        	<option value="0">선택하세요</option>
                        	<?php
                        	foreach($p_cats as $p_cat){
                        	?>
                        	<option value="<?=$p_cat['id']?>" <?php if($careers_occupation1==$p_cat['id']) echo "selected"; ?>><?=$p_cat['nickname']?></option>
                        	<?php
                        	}
                        	?>
                        </select>
                    </div>
                    <div class="col-sm-2"><br />
                        <select name="careers_occupation2" id="careers_occupation2" class="form-control">
                        	<option value="0">전체</option>
                        	<?php
                        	foreach($s_cats as $s_cat){
                        	?>
                        	<option value="<?=$s_cat['id']?>" <?php if($careers_occupation2==$s_cat['id']) echo "selected"; ?>><?=$s_cat['name']?></option>
                        	<?php
                        	}
                        	?>
                        </select>
                    </div>
                    <div class="col-sm-2">
            			근무형태 : 
            			<select name="careers_type" class="form-control">
            			<option value="0">선택하세요</option>
                        	<?php
                        	foreach($j_types as $j_type){
                        	?>
                        	<option value="<?=$j_type['id']?>" <?php if($careers_type==$j_type['id']) echo "selected"; ?>><?=$j_type['name']?></option>
                        	<?php
                        	}
                        	?>
            			</select>
                    </div>
                    <div class="col-sm-2">
            			지역 :
                        <select name="company_location" id="company_location" class="form-control">
                        	<option value="0">선택하세요</option>
                        	<?php
                        	foreach($locations as $location){
                        	?>
                        	<option value="<?=$location['id']?>" <?php if($company_location==$location['id']) echo "selected"; ?>><?=$location['name']?></option>
                        	<?php
                        	}
                        	?>
                        </select>
                    </div>
                    <div class="col-sm-3">
            			검색어 :
            			<input name="keyword" type="text" size="16" value="<?=$keyword?>" class="form-control" >
                    </div>
                    <div class="col-sm-1"><br />
            			<button class="btn btn-primary">검색</button>
                    </div>
            	</form><p>&nbsp;</p><hr />
                <table class="table">
                    <thead>
                        <tr>
                            <th>제목</th>
                            <th>회사명</th>
                            <th>지역</th>
                            <th>급여</th>
                            <th>조회</th>
                            <th>등록날짜</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($data as $details){
                        ?>
                        <tr>
                            <td><a href="./details?id=<?=$details['id']?>"><?=$details['title']?></a></td>
                            <td><?=$details['company_name']?></td>
                            <td><?=$details['company_location']?></td>
                            <td><?=$details['careers_salary']?></td>
                            <td><?=$details['lookup']+1?></td>
                            <td><?=$details['post_date']?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function(){
        $("#careers_occupation1").change(function(){
            $.ajax({
                url: "./ajax_cat",
                type: "post",
                data:{"id":$("#careers_occupation1").val()},
                success: function(result){
                    $("#careers_occupation2").html('<option value="0">전체</option>'+result);
                }
            });
        });
    });
    </script>
</body>
</html>