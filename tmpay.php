<?php
header("Content-type:application/json");

$truemoney_password = $_POST['truemoney_password'];
$user_id = $_POST['user_id'];


$url_web = "https://a6dc5308.ngrok.io/truemoney/webhook_truemoney.php"; // แก้เป็น url เว็บของตัวเอง หากทดสอบใน localhost ให้เปิด ngrok
$merchant_id = "test"; // แก้ id ร้านค้าของตัวเอง ค่าเทสเอาไว้สำหรับทดสอบ

function tmn_refill ($truemoney_password,$user_id,$url_web,$merchant_id)
{
if(function_exists('curl_init')){
$curl =
curl_init('https://www.tmpay.net/TPG/backend.php?merchant_id='.$merchant_id.'&password=' . $truemoney_password . '&resp_url='.$url_web.'?user_id='.$user_id.'');
curl_setopt($curl, CURLOPT_TIMEOUT, 10);
curl_setopt($curl, CURLOPT_HEADER, FALSE);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
$curl_content = curl_exec($curl);
curl_close($curl);
} else {
$curl_content = file_get_contents('http://www.tmpay.net/TPG/backend.php?merchant_id='.$merchant_id.'&password=' . $truemoney_password .'&resp_url='.$url_web.'?user_id='.$user_id.'');
}
if(strpos($curl_content,'SUCCEED') !== FALSE){
return true;
}else{
return false;
}
}

if(isset($truemoney_password) && isset($user_id)){
    $status = tmn_refill($truemoney_password,$user_id,$url_web,$merchant_id);
    if($status == true){
        echo json_encode(array("status"=>true,"message"=>"กำลังตรวจสอบ เปิดหน้านี้ค้างไว้สักครู่"));
    } else {
        echo json_encode(array("status"=>false,"message"=>"ไม่สามารถเติมเงินได้ในขณะนี้"));
    }
} else {
       echo json_encode(array("status"=>false,"message"=>"ระบุค่าไม่ครบ"));
}

?>