<?php
include "../common.php"; // 데이터베이스 연결 포함

$id = get_param('id');

// jumuns 테이블에서 해당 주문과 관련된 레코드 삭제
$sql_jumuns = "DELETE FROM jumuns WHERE jumun_id='$id'";
run_query($sql_jumuns);

// 이후 jumun1 테이블에서 주문 삭제
$sql_jumun = "DELETE FROM jumun1 WHERE id='$id'";
run_query($sql_jumun);

header("Location: jumun.php");
exit;
?>