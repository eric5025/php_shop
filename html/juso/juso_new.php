<!doctype html>
<html lang="kr">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>JUSO</title>
 <link href="css/bootstrap.min.css" rel="stylesheet">
 <link href="css/my.css" rel="stylesheet">
 <script src="js/jquery-3.7.1.min.js"></script>
 <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->
<br>

<form name="form1" method="post" action="juso_insert.php">

<!-- 주소록 항목을 입력하는 폼 -->
<table class="table table-sm table-bordered mymargin5">
 <tr height="40">
  <td width="20%" class="mycolor2">ID</td>
  <td width="80%" align="left">&nbsp;</td> <!-- ID 입력란 -->
 </tr>
 <tr>
  <td class="mycolor2">이름</td>
  <td align="left">
   <div class="d-inline-flex">
    <input type="text" name="name" size="20" value=""
     class="form-control form-control-sm"> <!-- 이름 입력란 -->
   </div>
  </td>
 </tr>
 <tr>
  <td class="mycolor2">전화</td>
  <td align="left">
   <div class="d-inline-flex">
    <!-- 전화번호 입력란 (3자리-4자리-4자리) -->
    <input type="text" name="tel1" size="3" value=""
     class="form-control form-control-sm"> -
    <input type="text" name="tel2" size="4" value=""
     class="form-control form-control-sm"> -
    <input type="text" name="tel3" size="4" value=""
     class="form-control form-control-sm">
   </div>
  </td>
 </tr>
 <tr height="40">
  <td class="mycolor2">음력/양력</td>
  <td align="left">
   <!-- 음력/양력 선택 라디오 버튼 -->
   &nbsp;<input type="radio" name="sm" value="0"
    class="form-check-input" checked> 양력
   &nbsp;<input type="radio" name="sm" value="1"
    class="form-check-input"> 음력
  </td>
 </tr>
 <tr>
  <td class="mycolor2">생일</td>
  <td align="left">
   <div class="d-inline-flex">
    <!-- 생일 입력란 (년도-월-일) -->
    <input type="text" name="birthday1" size="4" value=""
     class="form-control form-control-sm"> -
    <input type="text" name="birthday2" size="2" value=""
     class="form-control form-control-sm"> -
    <input type="text" name="birthday3" size="2" value=""
     class="form-control form-control-sm">
   </div>
  </td>
 </tr>
 <tr>
  <td class="mycolor2">주소</td>
  <td align="left">
   <input type="text" name="juso" value=""
    class="form-control form-control-sm"> <!-- 주소 입력란 -->
  </td>
 </tr>
</table>

<!-- 저장 및 이전 버튼 -->
<div align="center">
 <input type="submit" value="저장" class="btn btn-sm mycolor1">&nbsp;
 <input type="button" value="이전화면" class="btn btn-sm mycolor1"
  onClick="history.back();">
</div>

</form>

<!-------------------------------------------------------------------------------------------->
</div>

</body>
</html>