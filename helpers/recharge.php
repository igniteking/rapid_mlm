<?php
include("../connections/connection.php");
include("../connections/functions.php");
$req_id = $_GET['req_id'];
$amount = $_GET['amount'];
$user_id = $_GET['user_id'];
$status = $_GET['status'];


$extra_wallet = getPercent(20, $amount);
$compound_wallet =  $amount - $extra_wallet;
$widthrawl_wallet = 0;
$created_at = date('Y-m-d H:s:i');
$insert_into_wallet = mysqli_query($conn, "INSERT INTO `wallet`(`compound_wallet`, `created_at`, `extra_wallet`, `id`, `user_id`, `widthrawl_wallet`) VALUES
                                         ('$compound_wallet','$created_at','$extra_wallet',NULL,'$user_id','$widthrawl_wallet')");
$update = mysqli_query($conn, "UPDATE `request_recharge` SET `status`='$status' WHERE id = '$req_id'");
if ($insert_into_wallet and $update) {
    if ($status == 'accept') {
        echo "recharge_list.php?code=1";
    } else {
        echo "recharge_list.php?code=2";
    }
} else {
    echo "ERROR...!";
}
