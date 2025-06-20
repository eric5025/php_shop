<?
  $db=mysqli_connect("localhost","shop15","1234","shop15");
  if (!$db) exit("DB연결에 실패했습니다.");

  $page_line = 5;
  $page_block = 5;
?>