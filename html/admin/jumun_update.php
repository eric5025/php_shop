<?php
include "../common.php"; // 데이터베이스 연결 포함

$id = get_param('id');
$state = get_param('state');

// 데이터베이스에서 주문 상태 업데이트
$sql = "UPDATE jumun1 SET state='$state' WHERE id='$id'";
run_query($sql);

// 리디렉션
header("Location: jumun.php");
exit;
?>