<?php
include "common.php";
include "maintop.php";

$findtext = isset($_POST['find_text']) ? $_POST['find_text'] : '';

$sql = "SELECT * FROM product WHERE name LIKE '%$findtext%' ORDER BY name";
$result = mysqli_query($db, $sql);
?>
<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	
<div class="row m-1 mt-4 mb-0">
	<div class="col" align="center">

		<h4 class="m-3">상품검색</h4>

		<hr class="m-0">
		<table class="table table-sm mb-4">
			<tr height="40" class="bg-light">
				<td width="15%">이미지</td>
				<td width="45%">상품정보</td>
				<td width="20%">판매가</td>
				<td width="20%">금액</td>
			</tr>
			<?php
			$count = 0;
			while ($row = mysqli_fetch_assoc($result)) {
				$id = $row['id'];
				$name = $row['name'];
				$price = $row['price'];
				$discount = $row['discount'];
				$icon_new = $row['icon_new'];
				$icon_hit = $row['icon_hit'];
				$icon_sale = $row['icon_sale'];
				$image = $row['image1'];
				$image_path = !empty($image) ? "product/" . $image : "product/no_image.png";
				$formatted_price = number_format($price);
				if ($icon_sale == 1 && $discount > 0) {
					$price_sale = round($price * (100 - $discount) / 100);
				} else {
					$price_sale = $price;
				}
				$formatted_price_sale = number_format($price_sale);
				$icons_html = "";
				if ($icon_new == 1) $icons_html .= '<img src="images/i_new.gif"> ';
				if ($icon_hit == 1) $icons_html .= '<img src="images/i_hit.gif"> ';
				if ($icon_sale == 1) $icons_html .= '<img src="images/i_sale.gif"> <font size="2" color="red">' . $discount . '%</font>';
			?>
			<tr height="85" style="font-size:14px;">
				<td>
					<a href="product_detail.php?id=<?=$id?>"><img src="<?=$image_path?>" width="60" height="70"></a>
				</td>
				<td align="left" valign="middle">
					<a href="product_detail.php?id=<?=$id?>" style="color:#0066CC"><?=$name?></a><br>
					<?=$icons_html?>
				</td>
				<td><?php if ($icon_sale == 1 && $discount > 0) { ?><strike><?=$formatted_price?> 원</strike><?php } else { ?><?=$formatted_price?> 원<?php } ?></td>
				<td><b><?=$formatted_price_sale?> 원</b></td>
			</tr>
			<?php
				$count++;
			}
			if ($count == 0) {
				echo '<tr><td colspan="4" class="text-center">검색 결과가 없습니다.</td></tr>';
			}
			?>
		</table>
	</div>
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

<br><br><br>
<?php
include "main_bottom.php";
?>