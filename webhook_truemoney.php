<?php
session_start();
header("Content-type:application/json");
include 'config.inc.php';

 $transaction_id = $_GET['transaction_id'];
 $password = $_GET['password'];
 $amount = $_GET['real_amount'];
 $status = $_GET['status'];
 $user_id = $_GET['user_id'];

// อัพขึ้นจริงให้เอา comment ออก
// if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
//   $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
// }

if($status == 1 ){ // ถ้าใช้งานจริงให้ใส่  && $_SERVER['REMOTE_ADDR'] == '203.146.127.112' เพิ่ม 

    $data['message'] = "คุณ $user_id เติมเงินสำเร็จ คุณได้รับ $amount point";
    $pusher->trigger('truemoney', 'topup', $data);


}  else if ($status == 3){

    echo json_encode(array("status"=>false,"message"=>"บัตรถูกใช้ไปแล้ว"));

} else if ($status == 4){


    echo json_encode(array("status"=>false,"message"=>"บัตรเติมเงินไม่ถูกต้อง"));

} else if ($status == 5){

    echo json_encode(array("status"=>false,"message"=>"ไม่ใช่บัตร Truemoney"));
}

?>