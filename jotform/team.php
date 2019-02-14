<?php
$email="teamsnaptest@outlook.com";
$pass="JSON2hockey";
$client_id="d4606a1366e8bc6c8126ada4588fee0f1a9595451cae99ced331178c591b6cdd";
$client_secret="5af86b1fa7e628a60da5a21dca7d7c3c51d7a334691dba12d148ffa28d6a9883";
$redirect=urlencode("https://www.kpabal.com/CI/jotform/team.php");
$team="5732571";
$url = 'https://auth.teamsnap.com/oauth/token';
/*if(!isset($_GET['code'])) {
    $org_url = "https://auth.teamsnap.com/oauth/authorize?client_id=$client_id&redirect_uri=$redirect&response_type=authorization_code";
    ?>
<script>
    location.href="<?=$org_url?>";
</script>
<?php
}*/
//$ch = curl_init();
/*
$CODE=$_GET['code'];
$fields = array(
    'code' => $CODE,
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect,
    'grant_type' => "authorization_code"
);
//set the url, number of POST vars, POST data
$token_url=$url."?client_id=$client_id&client_secret=$client_secret&redirect_uri=$redirect&code=$CODE&grant_type=authorization_code";

curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_URL, $token_url);

//execute post
$result = curl_exec($ch);
print_r($result);

//close connection
curl_close($ch);
*/
my_curl("https://api.teamsnap.com/v3/me");
function my_curl($token_url){
    $access_token="7cc6982cbe9d6c88e522204dcb04e3ba765079026f47b5fd11731e1818d333b8";
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_POST,0);
    curl_setopt($ch,CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$access_token)
    );
    $res=curl_exec($ch);
    $result =json_decode( $res );
    print_r($result);
}