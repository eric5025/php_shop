<?php
    include "../common.php";
    $filterStatus = isset($_REQUEST['filterStatus']) ? $_REQUEST['filterStatus'] : 0;
    $filterEvent = isset($_REQUEST['filterEvent']) ? $_REQUEST['filterEvent'] : 0;
    $filterCategory = isset($_REQUEST['filterCategory']) ? $_REQUEST['filterCategory'] : 0;
    $searchType = isset($_REQUEST['searchType']) ? $_REQUEST['searchType'] : 1;
    $searchKeyword = isset($_REQUEST['searchKeyword']) ? $_REQUEST['searchKeyword'] : '';
    $whereClauses = array();
    if ($filterStatus != 0) { $whereClauses[] = "status=" . intval($filterStatus); }
    if ($filterEvent == 1) { $whereClauses[] = "icon_new=1"; }
    elseif ($filterEvent == 2) { $whereClauses[] = "icon_hit=1"; }
    elseif ($filterEvent == 3) { $whereClauses[] = "icon_sale=1"; }
    if ($filterCategory != 0) { $whereClauses[] = "menu=" . intval($filterCategory); }
    if ($searchKeyword) {
        if ($searchType == 1) { $whereClauses[] = "name like '%" . addslashes($searchKeyword) . "%'"; }
        elseif ($searchType == 2) { $whereClauses[] = "code like '%" . addslashes($searchKeyword) . "%'"; }
    }
    $whereSql = '';
    if (count($whereClauses) > 0) {
        $whereSql = " WHERE " . implode(" AND ", $whereClauses);
    }
    $query = "SELECT * FROM product" . $whereSql . " ORDER BY name";
    $productResult = mysqli_query($db, $query);
    $productResult = mypagination($query, $queryString, $totalCount, $paginationHtml);
    if (!$productResult) {
        exit("에러: " . mysqli_error($db));
    }
    $queryString = "filterStatus=$filterStatus&filterEvent=$filterEvent&filterCategory=$filterCategory&searchType=$searchType&searchKeyword=$searchKeyword";
?>

<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>eric Mall</title>
	<link  href="../css/bootstrap.min.css" rel="stylesheet">
	<link  href="../css/my.css" rel="stylesheet">
	<script src="../js/jquery-3.7.1.min.js"></script>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/my.js"></script>
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->	
<script> document.write(admin_menu());</script>
<!-------------------------------------------------------------------------------------------->	

<div class="row mx-1  justify-content-center">
	<div class="col" align="center">

	<h4 class="m-0 mb-3">제품</h4>
	
	<form name="searchForm" method="post" action="product.php">
	
	<table class="table table-sm table-borderless m-0 p-0">
		<tr>
			<td width="20%" align="left" style="padding-top:8px">
                제품수 : <font color="red"><?php echo $totalCount; ?></font>
			</td>
			<td align="right">
				<div class="d-inline-flex">
					<!-- 각 sel에 해당하는 셀렉트 박스를 생성합니다. -->
                    <?php
                    echo("<select name='filterStatus' class='form-select form-select-sm bg-light myfs12' style='width:100px'>");
                    for($i=0;$i<$n_status;$i++)
                    {
                        $selected = ($i==$filterStatus) ? "selected" : "";
                        echo("<option value='$i' $selected>$a_status[$i]</option>");
                    }
                    echo("</select>");
                    ?>
				</div>
				<div class="d-inline-flex">
                    <?php
                    echo("<select name='filterEvent' class='form-select form-select-sm bg-light myfs12' style='width:100px'>");
                    for($i=0;$i<$n_icon;$i++)
                    {
                        $selected = ($i==$filterEvent) ? "selected" : "";
                        echo("<option value='$i' $selected>$a_icon[$i]</option>");
                    }
                    echo("</select>");
                    ?>&nbsp;
                </div>
                <div class="d-inline-flex">
                    <?php
                    echo("<select name='filterCategory' class='form-select form-select-sm bg-light myfs12' style='width:100px'>");
                    for($i=0;$i<$n_menu;$i++)
                    {
                        $selected = ($i==$filterCategory) ? "selected" : "";
                        echo("<option value='$i' $selected>$a_menu[$i]</option>");
                    }
                    echo("</select>");
                    ?>&nbsp;
					<?php
                    echo("<select name='searchType' class='form-select form-select-sm bg-light myfs12' style='width:100px'>");
                    for($i=1;$i<$n_text1;$i++)
                    {
                        $selected = ($i==$searchType) ? "selected" : "";
                        echo("<option value='$i' $selected>$a_text1[$i]</option>");
                    }
                    echo("</select>");
                    ?>
				</div>
				<div class="d-inline-flex">
					<div class="input-group input-group-sm">
                        <!-- 검색어 남아있게 코딩 -->
						<input type="text" name="searchKeyword" value="<?php echo htmlspecialchars($searchKeyword); ?>" size="10" 
							class="form-control myfs12" 
							onKeydown="if (event.keyCode == 13) { searchForm.submit(); }"> 
						<button class="btn mycolor1 myfs12" type="button" 
							onClick="searchForm.submit();">검색</button>&nbsp;&nbsp;
					</div>
				</div>
				<div class="d-inline-flex">
					<a href="product_new.php" class="btn btn-sm mycolor1 myfs12">추가</a>&nbsp;
				</div>
				
			</td>
		</tr>
	</table>
	
	</form>

	<table class="table table-sm table-bordered table-hover mb-1">
		<tr class="bg-light">
			<td width="10%">제품분류</td>
			<td width="10%">제품코드</td>
			<td width="35%">제품명</td>
			<td width="10%">판매가</td>
			<td width="10%">상태</td>
			<td width="15%">이벤트</td>
			<td width="10%">수정/삭제</td>
		</tr>
		<?php
        while ($product = mysqli_fetch_assoc($productResult)) {
            $productId = $product["id"];
            $formattedPrice = number_format($product['price']);
            echo "<tr>";
            echo "<td>" . $a_menu[$product['menu']] . "</td>";
            echo "<td>" . $product['code'] . "</td>";
            echo "<td align='left'>" . $product['name'] . "</td>";
            echo "<td align='right' class='px-2'>" . $formattedPrice . "</td>";
            echo "<td>" . $a_status[$product['status']] . "</td>"; 
            echo "<td>";
                if ($product['icon_new'] == 1) echo "New ";
                if ($product['icon_hit'] == 1) echo "Hit ";
                if ($product['icon_sale'] == 1) echo "Sale(" . $product['discount'] . "% )";
            echo "</td>";

        ?>
            <td>
				<a href="product_edit.php?id=<?=$productId;?>" class="btn btn-sm btn-outline-info mybutton-blue">수정</a>
				<a href="product_delete.php?id=<?=$productId;?>" class="btn btn-sm btn-outline-danger mybutton-red" onclick="javascript:return confirm('삭제할까요 ?');">삭제</a>				
			</td>
        <?
            echo "</tr>";
        }
        ?>
	</table>

    <?php echo $paginationHtml; ?>

	</div>
</div>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html> 