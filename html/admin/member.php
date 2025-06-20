<?php 
  include "../common.php"; 
  setcookie("user_id", "");

  
  $text1 = get_param("text1", "");
  $sel1 = get_param("sel1", 1);

  
  $where_condition = $sel1 == 1 ? "name LIKE '%$text1%'" : "uid LIKE '%$text1%'";

  
$sql = "SELECT COUNT(*) AS total_members FROM member WHERE $where_condition";
$result = run_query($sql);
$row = mysqli_fetch_assoc($result);
$total_members = $row['total_members'];

$sql = $sel1 == 1 ?
    "SELECT * FROM member WHERE name LIKE '%$text1%' ORDER BY name" :
    "SELECT * FROM member WHERE uid LIKE '%$text1%' ORDER BY name";
$args = "text1=$text1&sel1=$sel1";
$result = mypagination($sql, $args, $count, $pagebar);
?>

<!doctype html>
<html lang="kr">
<head>
  <meta charset="utf-8">
  <title>eric Mall</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/my.css" rel="stylesheet">
  <script src="../js/jquery-3.7.1.min.js"></script>
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script src="../js/my.js"></script>
</head>
<body>
<div class="container">
  <script>
    document.write(admin_menu());
  </script>

<div class="row mx-1 justify-content-center">
  <div class="col" align="center">

<h4 class="m-0 mb-2">회원</h4>

<form name="form1" method="post" action="member.php">
  <table class="table table-sm table-borderless m-0">
    <tr>
      <td align="left" style="padding-top:12px">
        &nbsp;회원수 : <font color="red"><?php echo $total_members; ?></font>
      </td>
      <td align="right">
        <div class="d-inline-flex">
          <div class="input-group input-group-sm">
            <select name="sel1" class="form-select form-select-sm bg-light myfs12" style="width:92px;">
              <option value="1" <?php if($sel1==1){echo "selected";} ?>>이름</option>
              <option value="2" <?php if($sel1==2){echo "selected";} ?>>아이디</option>
            </select>
            <input type="text" name="text1" value="<?php echo $text1; ?>" style="width:100px;" class="form-control myfs12"
              onkeydown="if (event.keyCode==13){form1.submit();}">
            <button class="btn mycolor1 myfs12" type="button" onclick="form1.submit();">검색</button>
          </div>
        </div>
      </td>
    </tr>
  </table>
</form>

<table class="table table-sm table-bordered table-hover m-0 mb-1">
  <tr class="bg-light">
    <td>아이디</td>
    <td>이름</td>
    <td>핸드폰</td>
    <td>E-Mail</td>
    <td width="10%">구분</td>
    <td width="15%">수정 / 삭제</td>
  </tr>

  <?php 
  foreach($result as $row){
    $id = $row["id"];
    // 전화번호 분리
    $tel1 = substr($row["tel"],0,3); 
        $tel2 = substr($row["tel"],3,4); $tel3 = substr($row["tel"],7,4);
        $tel = $tel1 . "-" . $tel2 . "-" . $tel3;
  ?>
  <tr>
    <td><?=$row["uid"]?></td>
    <td><?=$row["name"]?></td>
    <td><?=$tel?></td>
    <td class="px-2" align="left"><?=$row["email"]?></td>
    <td><?php echo ($row["gubun"]==0) ? "회원" : "탈퇴"; ?></td>
    <td>
      <a href="member_edit.php?id=<?=$id?>" class="btn btn-sm btn-outline-info mybutton-blue">수정</a>
      <a href="member_delete.php?id=<?=$id?>" class="btn btn-sm btn-outline-danger mybutton-red"
         onclick="return confirm('삭제할까요 ?');">삭제</a>
    </td>
  </tr>
  <?php } ?>
</table>

<?php 
    echo $pagebar;
?>

  </div>
</div>
</div>
</body>
</html>
