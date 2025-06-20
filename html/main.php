<?php
include "common.php";      

include "maintop.php";
$query = "SELECT * FROM product WHERE status=1 ORDER BY regday DESC, id DESC LIMIT 8";
$result = mysqli_query($db, $query);
?>
<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<div class="container">
<!--  제목  -->
<div class="row mt-5 mb-1">
	<div class="col" align="center">
		<h2>New Arriable</h2>
	</div>	
</div>	

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
    // 할인 가격 계산
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
<br>

<!-------------------------------------------------------------------------------------------->	
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<?php
include "main_bottom.php";
?>