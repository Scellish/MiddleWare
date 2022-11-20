
<?php
require_once('crp.php');
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$ipwhitelist = array('WHITELIST');
    $garbage = 0;
  }else {
  die("IP: $ip is not whitelisted");
}
if ($ip == "MASTER IP"){
  $webhook = file_get_contents('php://input'); 
  echo "Role: "."*Server Master*\n";
  if (str_contains($webhook, 'webhook')) {
    $corecode = encrypt($webhook);
    $myfile = fopen("deco.json", "w") or die("Unable to open file!");
    fwrite($myfile, $corecode);
     echo "Info: "."Webhook Updated\n";
}
if (str_contains($webhook, 'Whitelist')) {
    echo json_encode($ipwhitelist);
}
if (str_contains($webhook, 'MasterIP')) {
    echo "Master IP: ".$ip;
}
if (str_contains($webhook, 'Current')) {
    $book = file_get_contents("deco.json");
    $gook = decrypt($book);
    $obj = json_decode($gook);
    $webhookurl = $obj->{'webhook'};
    echo "$webhookurl";
}
if (str_contains($webhook, 'Config')) {
   $data =  file_get_contents("config.json");
   $obj = json_decode($data);
   $concore = $obj->{'core'};
   echo "$concore";
}


} else {
$coredata = file_get_contents('php://input'); 
$book = file_get_contents("deco.json");
$gook = decrypt($book);
echo "Role: "."*Server Admin*\n";
$obj = json_decode($gook);
$webhookurl = $obj->{'webhook'};
$json_data = "$coredata";
$ch = curl_init( $webhookurl );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);  
  
}
  
