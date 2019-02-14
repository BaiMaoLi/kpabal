<?php
session_start();
set_time_limit(0);
$redirect= "https://www.kpabal.com/CI/jotform/pullimage.php";
$client_id="130af85a21684d2c9278d122031104b0";
$secret='01f641f3a0194dd393c26fcf734a7e3d';
if($_SESSION['token'] =="") {

    if (isset($_GET['code'])){
        $code = $_GET['code'];
        $uri = 'https://api.instagram.com/oauth/access_token';
        $data = [
            'client_id' => $client_id,
            'client_secret' => $secret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirect,
            'code' => $code
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri); // uri
        curl_setopt($ch, CURLOPT_POST, true); // POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // POST DATA
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // RETURN RESULT true
        curl_setopt($ch, CURLOPT_HEADER, 0); // RETURN HEADER false
        curl_setopt($ch, CURLOPT_NOBODY, 0); // NO RETURN BODY false / we need the body to return
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // VERIFY SSL HOST false
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // VERIFY SSL PEER false
        $result = json_decode(curl_exec($ch)); // execute curl
        $_SESSION['token']=$result->access_token;
        header('Location: '.$redirect);
        // ecit directly the result
    }else{
        $get_url = 'https://www.instagram.com/oauth/authorize/?client_id='.$client_id.'&redirect_uri=' . $redirect . '&response_type=code&scope=public_content';
        header('Location: '.$get_url);
    }
}else {
    $token = $_SESSION['token'];//"5321482928.54da896.e0390db6973f464b86637eaea7ecd8fc";
    //echo $token;
    $tag1 = "shoes";
    $tag2 = "nike";
    $url = "https://api.instagram.com/v1/tags/".$tag1."/media/recent?access_token=".$token."&count=50";
    $data = json_decode(file_get_contents($url));
    if($data->meta->code!=200){
        $_SESSION['token']="";
        header('Location: '.$get_url);
    }
    $idx = 0;
    foreach ($data->data as $media) {
        $img = $media->images->standard_resolution->url;

        if (in_array($tag2, $media->tags)) {
            save_curl($img);
            $idx++;
        } else {
            if ($media->comments->count > 0) {
                //echo $media->link."<br>";
                $comment_data = json_decode(file_get_contents($media->link . "?__a=1"));
                $edges = $comment_data->graphql->shortcode_media->edge_media_to_comment->edges;
                foreach ($edges as $edge) {
                    //echo $edge->node->text."<br>";
                    if (strpos($edge->node->text, $tag2) !== false) {
                        save_curl($img);
                        break;
                    }
                }
            }
        }
    }
    echo "Saved " . $idx . " Pictures";
}
function save_curl($img){
    $file_name=basename($img);
    $image = file_get_contents($img);
    file_put_contents('./images/'.$file_name, $image);
}