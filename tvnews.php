<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

require "vendor/autoload.php";
use Goutte\Client;

$client = new Client();
$crawler = $client->request('GET', 'https://in.tradingview.com/ideas/news/');
$list=array();
$crawler->filter('a.tv-widget-idea__title')->each(function ($node) use (&$list) {
   // print $node->text()."<br>";
	$list['name'][]=trim($node->text());
	$list['url'][]=trim('https://in.tradingview.com'.$node->attr('href'));
});

$crawler->filter('.tv-widget-idea__cover')->each(function ($node) use (&$list) {
   
	$list['img'][]=trim($node->attr('src'));
});



$refinelist=array();
$xc=0;
foreach($list['img'] as $img){
	if($xc<15){
	$refinelist['img'][]=$img;
	$refinelist['name'][]=$list['name'][$xc];
	$refinelist['url'][]=$list['url'][$xc];
	}
	$xc++;
}
header('Content-type: application/json');
echo json_encode(array('data'=>$refinelist));
?>