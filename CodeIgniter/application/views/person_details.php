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
                <p><?=$data[0]['title']?>&nbsp;</p>
                <p>&nbsp;</p>
                <h4>신상정보</h4>
                <hr />
                <div class="col-sm-2">이름:</div><div class="col-sm-10"><p><?=$data[0]['name']?>&nbsp;</p></div>
                <div class="col-sm-2">전화번호:</div><div class="col-sm-10"><p><?=$data[0]['phone']?>&nbsp;</p></div>
                <div class="col-sm-2">이메일:</div><div class="col-sm-10"><p><?=$data[0]['email']?>&nbsp;</p></div>
                <div class="col-sm-2">홈페이지:</div><div class="col-sm-10"><p><?=$data[0]['homepage']?>&nbsp;</p></div>
                
                <p>&nbsp;</p>
                <h4>채용정보</h4>
                <hr />
                <div class="col-sm-2">지원분야:</div><div class="col-sm-10"><p><?=$data[0]['category']?>&nbsp;</p></div>
                <div class="col-sm-2">희망지역:</div><div class="col-sm-10"><p><?=$data[0]['company_location']?>&nbsp;</p></div>
                <div class="col-sm-2">구직형태:</div><div class="col-sm-10"><p><?=$data[0]['careers_type']?>&nbsp;</p></div>
                <div class="col-sm-2">희망급여:</div><div class="col-sm-10"><p><?=$data[0]['careers_salary']?>&nbsp;</p></div>
                <div class="col-sm-2">기타사항:</div><div class="col-sm-10"><p><?=$data[0]['careers_etc']?>&nbsp;</p></div>
                <p>&nbsp;</p>
                <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;"><?=$data[0]['content']?></div>
            </div>
        </div>
    </div>
</body>
</html>