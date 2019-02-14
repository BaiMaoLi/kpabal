<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

require "vendor/autoload.php";
use Goutte\Client;

$client = new Client();
$crawler = $client->request('GET', 'https://in.reuters.com/finance/markets/us');
$list=array();
$crawler->filter('.story-content a')->each(function ($node) use (&$list) {
 
	$list['name'][]=trim($node->text());
	$list['url'][]=trim('https://reuters.com'.$node->attr('href'));
});

$cont=file_get_contents('https://www.reuters.com/assets/jsonWireNews?startTime='.microtime()); 
$xyz=json_decode($cont,true);

$refinelist=array();
$refinelist1=array();
$xc=0;
foreach($xyz['headlines'] as $img){
	if($img['mainPicUrl']!=''){
	if($xc<4){
	$refinelist['tname'][]=$img['headline'];
	$refinelist['turl'][]='https://reuters.com'.$img['url'];
	$refinelist['tpic'][]=$img['mainPicUrl'];
	}
	$xc++;
	}
	
}
$xc=0;
foreach($list['name'] as $img){
	if($xc<15){
	$refinelist['name'][]=$list['name'][$xc];
	$refinelist['url'][]=$list['url'][$xc];
	}
	$xc++;
}
//print_r($refinelist);
header('Content-type: application/json');
echo json_encode(array('data'=>$refinelist));
?>