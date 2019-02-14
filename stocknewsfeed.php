<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

require "vendor/autoload.php";
use Goutte\Client;

$client = new Client();
$crawler = $client->request('GET', 'https://www.marketscreener.com/news/markets/');
$list=array();
$crawler->filter('td.newsColCT  > a')->each(function ($node) use (&$list) {
   // print $node->text()."<br>";
	$list['name'][]=trim($node->text());
	$list['url'][]=trim('https://www.marketscreener.com'.$node->attr('href'));
});
$count=0;
$newlist=array();
foreach($list['url'] as $url){
	if($count<=15){
$crawler = $client->request('GET', $url);
$imgx='';	
$crawler->filter('span.clearfix div img')->each(function ($node) use (&$imgx) {
   // print $node->text()."<br>";
   if($imgx==''){
	$imgx=trim($node->attr('src'));
   }
});

$newlist['img'][]=$imgx;
	}else{
		break;
	}
	
$count++;
}

$refinelist=array();
$xc=0;
foreach($newlist['img'] as $img){
	$refinelist['img'][]=$img;
	$refinelist['name'][]=$list['name'][$xc];
	$refinelist['url'][]=$list['url'][$xc];
	$xc++;
}
header('Content-type: application/json');
echo json_encode(array('data'=>$refinelist));
?>