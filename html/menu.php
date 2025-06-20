<?php
include "common.php";      

include "maintop.php";

// 카테고리(menu) 값 받기 (기본값 1)
$menu = isset($_GET['menu']) ? intval($_GET['menu']) : 1;
$sort = isset($_GET['sort']) ? intval($_GET['sort']) : 1;

// 정렬 기준 설정
switch ($sort) {
	case 1: // 신상품
		$order_by = "regday DESC, id DESC";
		break;
	case 2: // 인기상품
		$order_by = "icon_hit DESC, regday DESC, id DESC";
		break;
	case 3: // 상품명
		$order_by = "name ASC";
		break;
	case 4: // 낮은가격
		$order_by = "price ASC";
		break;
	case 5: // 높은가격
		$order_by = "price DESC";
		break;
	default:
		$order_by = "regday DESC, id DESC";
}

// 해당 카테고리의 판매중 상품만 불러오기
$query = "SELECT * FROM product WHERE menu=$menu AND status=1 ORDER BY $order_by LIMIT 20";
$result = mysqli_query($db, $query);
?>

<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<!--  Category 제목 -->
<div class="row mt-5">
	<div class="col" align="center">
		<h2><?= htmlspecialchars($a_menu[$menu]) ?></h2>
	</div>	
</div>	

<!--  상품개수 & 정렬 -->
<div class="row m-0">
	<div class="col-2" align="left" style="font-size:15px">
		Total <b>10</b> items
	</div>	
	<div class="col" align="right" style="font-size:12px">
		<a href="menu.php?menu=<?=$menu?>&sort=1"><b><font color='steelblue'><?=($sort==1?'▶':'')?>신상품</font></b></a>&nbsp;|
		<a href="menu.php?menu=<?=$menu?>&sort=2"><b><font color='steelblue'><?=($sort==2?'▶':'')?>인기상품</font></b></a>&nbsp;|
		<a href="menu.php?menu=<?=$menu?>&sort=3"><b><font color='steelblue'><?=($sort==3?'▶':'')?>상품명</font></b></a>&nbsp;|
		<a href="menu.php?menu=<?=$menu?>&sort=4"><b><font color='steelblue'><?=($sort==4?'▶':'')?>낮은가격</font></b></a>&nbsp;|
		<a href="menu.php?menu=<?=$menu?>&sort=5"><b><font color='steelblue'><?=($sort==5?'▶':'')?>높은가격</font></b></a>
	</div>	
</div>	
<hr class="mt-0 mb-4">

<!--  상품 진열  -->
<div class="row">
<?php
$count = 0;
while ($product = mysqli_fetch_assoc($result)) {
	$id = $product['id'];
	$name = $product['name'];
	$price = $product['price'];
	$discount = $product['discount'];
	$icon_new = $product['icon_new'];
	$icon_hit = $product['icon_hit'];
	$icon_sale = $product['icon_sale'];
	$image = $product['image1'];
	$image_path = !empty($image) ? "product/" . $image : "product/no_image.png";
	$formatted_price = number_format($price);
	if ($icon_sale == 1 && $discount > 0) {
		$price_sale = round($price * (100 - $discount) / 100);
	} else {
		$price_sale = $price;
	}
	$formatted_price_sale = number_format($price_sale);
	$icons_html = "";
	if ($icon_new == 1) $icons_html .= '<img src="images/i_new.gif">&nbsp;';
	if ($icon_hit == 1) $icons_html .= '<img src="images/i_hit.gif">&nbsp;';
	if ($icon_sale == 1) $icons_html .= '<img src="images/i_sale.gif">&nbsp;<font size="2" color="red">' . $discount . '%</font>';
	$price_html = "";
	if ($icon_sale == 1 && $discount > 0) {
		$price_html = '<small><strike>' . $formatted_price . ' 원</strike></small>&nbsp;&nbsp;<b>' . $formatted_price_sale . ' 원</b>';
	} else {
		$price_html = '<b>' . $formatted_price . ' 원</b>';
	}
?>
	<div class="col-sm-3 mb-3">
		<div class="card h-100">
			<div class="zoom_image" align="center">
				<a href="product_detail.php?id=<?=$id?>"><img src="<?=$image_path?>" 
					height="360" class="card-img-top img-fluid"></a>
			</div>
			<div class="card-body bg-light" align="center" style="font-size:15px;">
				<div class="card-title">
					<a href="product_detail.php?id=<?=$id?>"><?=$name?></a><br>
					<?=$icons_html?>
				</div>
				<p class="card-text"><?=$price_html?><br></p>
			</div>
		</div>
	</div>
<?php
	$count++;
}
if ($count == 0) {
	echo '<div class="col-12 text-center"><p>등록된 상품이 없습니다.</p></div>';
}
?>
</div>

<!--  Pagination -->
<div class="row mb-4">
	<div class="col">
		<nav aria-label="Page navigation example">
			<ul class="pagination pagination-sm justify-content-center">
				<li class="page-item">
					<a class="page-link" href="#" aria-label="First">
						<span aria-hidden="true">◀</span>
					</a>
				</li>
				<li class="page-item">
					<a class="page-link" href="#" aria-label="Previous">
						<span aria-hidden="true">◁</span>
					</a>
				</li>
				<li class="page-item"><a class="page-link" href="#">1</a></li>
				<li class="page-item active" aria-current="page">
					<span class="page-link mycolor1">2</span>
				</li>
				<li class="page-item"><a class="page-link" href="#">3</a></li>
				<li class="page-item"><a class="page-link" href="#">4</a></li>
				<li class="page-item"><a class="page-link" href="#">5</a></li>
				<li class="page-item">
					<a class="page-link" href="#" aria-label="Next">
						<span aria-hidden="true">▷</span>
					</a>
				</li>
				<li class="page-item">
					<a class="page-link" href="#" aria-label="Last">
						<span aria-hidden="true">▶</span>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>

<!-------------------------------------------------------------------------------------------->	
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	
	
<?php
include "main_bottom.php";
?>

<!-------------------------------------------------------------------------------------------->	
