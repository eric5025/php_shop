<?php
    
    include "../common.php";

    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $id1 = isset($_GET['id1']) ? $_GET['id1'] : '';
	$sql_sub = "SELECT * FROM opts WHERE id= $id1";
    $result_sub = mysqli_query($db, $sql_sub);
    if (!$result_sub) {
        exit("소옵션 정보 로딩 실패");
    }
	$sub_row = mysqli_fetch_assoc($result_sub);
?>
<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>eric</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/my.css" rel="stylesheet">
	<script src="..js/jquery-3.7.1.min.js"></script>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/my.js"></script>
</head>
<body>
<div class="container">
<!-------------------------------------------------------------------------------------------->	
<script> document.write(admin_menu());</script>
<!-------------------------------------------------------------------------------------------->	
<form name="form1" method="post" action="opts_update.php">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="id1" value="<?=$id1;?>">
<div class="row mx-1  justify-content-center">
	<div class="col-sm-10" align="center">
		<h4 class="m-0 mb-3">소옵션</h4>
		<table class="table table-sm table-bordered myfs12">
			<tr>
				<td width="30%" class="bg-light p-2">소옵션번호</td>
				<td align="left" class="ps-3"><?=$sub_row["id"];?></td>
			</tr>
			<tr>
				<td class="bg-light">소옵션명</td>
				<td align="left" class="ps-2">
					<div class="d-inline-flex">
						<input type="text" name="name" size="30" value="<?=$sub_row["name"];?>" class="form-control form-control-sm">
					</div>
				</td>
			</tr>
		</table>
		<a href="javascript:form1.submit();"  class="btn btn-sm btn-dark text-white my-2">&nbsp;저 장&nbsp;</a>&nbsp;
		<a href="javascript:history.back();"  class="btn btn-sm btn-outline-dark my-2">&nbsp;돌아가기&nbsp;</a>
	</div>
</div>
<br>
<!-------------------------------------------------------------------------------------------->	
</div>
</body>
</html>