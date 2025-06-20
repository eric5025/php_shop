<?php
include "common.php";
include "maintop.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) exit('잘못된 접근입니다.');

$sql = "SELECT * FROM product WHERE id=$id";
$result = mysqli_query($db, $sql);
if (!$result || mysqli_num_rows($result) == 0) exit('상품이 존재하지 않습니다.');
$product = mysqli_fetch_assoc($result);

$opt1 = $product['opt1'];
$opt2 = $product['opt2'];
$opts1 = [];
$opts2 = [];
if ($opt1) {
    $sql_opt1 = "SELECT * FROM opts WHERE opt_id = $opt1";
    $result_opt1 = mysqli_query($db, $sql_opt1);
    while ($row = mysqli_fetch_assoc($result_opt1)) {
        $opts1[] = $row;
    }
}
if ($opt2) {
    $sql_opt2 = "SELECT * FROM opts WHERE opt_id = $opt2";
    $result_opt2 = mysqli_query($db, $sql_opt2);
    while ($row = mysqli_fetch_assoc($result_opt2)) {
        $opts2[] = $row;
    }
}

$image = $product['image1'];
$image_path = !empty($image) ? "product/" . $image : "product/no_image.png";
$price = $product['price'];
$discount = $product['discount'];
$icon_sale = $product['icon_sale'];
if ($icon_sale == 1 && $discount > 0) {
    $price_sale = round($price * (100 - $discount) / 100);
} else {
    $price_sale = $price;
}
$formatted_price = number_format($price);
$formatted_price_sale = number_format($price_sale);
$icon_new = $product['icon_new'];
$icon_hit = $product['icon_hit'];
$icons_html = "";
if ($icon_new == 1) $icons_html .= '<span class="badge bg-warning text-dark me-1"><i class="fa-solid fa-star"></i> NEW</span>';
if ($icon_hit == 1) $icons_html .= '<span class="badge bg-danger me-1"><i class="fa-solid fa-fire"></i> HIT</span>';
if ($icon_sale == 1) $icons_html .= '<span class="badge bg-primary"><i class="fa-solid fa-bolt"></i> SALE ' . $discount . '%</span>';

$contents = nl2br(htmlspecialchars($product['contents']));
?>
<!-- 슈퍼카 상품상세 카드 레이아웃 -->
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card p-4" style="background:#232323; border-radius:2rem; box-shadow:0 4px 24px #000a;">
        <div class="row g-4 align-items-center">
          <div class="col-md-6 text-center">
            <img src="<?=$image_path?>" class="img-fluid rounded shadow mb-3" style="max-height:400px; background:#111; object-fit:cover; border-radius:1.5rem;">
          </div>
          <div class="col-md-6">
            <h2 style="color:#FFD600; font-weight:900; letter-spacing:-1px;"><?=htmlspecialchars($product['name'])?></h2>
            <div class="mb-2">
              <?=$icons_html?>
            </div>
            <hr style="border-top:2px solid #FFD600; opacity:0.2;">
            <div class="mb-2">
              <span class="text-secondary text-decoration-line-through" style="font-size:1.1rem;">₩<?=$formatted_price?></span>
              <span class="ms-2" style="color:#FFD600; font-size:1.5rem; font-weight:900;">₩<?=$formatted_price_sale?></span>
            </div>
            <form name="form2" method="post" action="">
              <input type="hidden" name="kind" value="insert">
              <input type="hidden" name="id" value="<?=$id?>">
              <input type="hidden" name="price" value="<?=$price_sale?>">
              <input type="hidden" name="name" value="<?=htmlspecialchars($product['name'])?>">
              <input type="hidden" name="image" value="<?=$image_path?>">
              <div class="mb-2">
                <label class="form-label">옵션1</label>
                <select name="opts1" class="form-select form-select-sm mb-2" style="width:100%;font-size:14px;" onchange="document.form2.opts1_name.value=this.options[this.selectedIndex].text;">
                  <option value="0" selected>옵션을 선택하세요.</option>
                  <?php foreach ($opts1 as $o) { ?>
                  <option value="<?=$o['id']?>"><?=$o['name']?></option>
                  <?php } ?>
                </select>
                <input type="hidden" name="opts1_name" value="">
              </div>
              <div class="mb-2">
                <label class="form-label">옵션2</label>
                <select name="opts2" class="form-select form-select-sm mb-2" style="width:100%;font-size:14px;" onchange="document.form2.opts2_name.value=this.options[this.selectedIndex].text;">
                  <option value="0" selected>옵션을 선택하세요.</option>
                  <?php foreach ($opts2 as $o) { ?>
                  <option value="<?=$o['id']?>"><?=$o['name']?></option>
                  <?php } ?>
                </select>
                <input type="hidden" name="opts2_name" value="">
              </div>
              <div class="mb-2">
                <label class="form-label">수량</label>
                <input type="text" name="num" size="5" value="1" class="form-control form-control-sm text-center" style="max-width:100px; display:inline-block; background:#181818; color:#FFD600; border:1.5px solid #FFD600;" onchange="cal_price()">
              </div>
              <div class="mb-3">
                <label class="form-label">금액</label>
                <input type="text" name="prices" value="<?=$formatted_price_sale?>" size="10" class="form-control form-control-sm text-center" style="max-width:150px; display:inline-block; background:#181818; color:#FFD600; border:1.5px solid #FFD600; font-size:1.3rem; font-weight:700;" readonly>
              </div>
              <div class="d-flex gap-2 mt-3">
                <a href="javascript:check_form2('D')" class="btn btn-primary btn-lg flex-fill" style="color:#fff;"><i class="fa-solid fa-bolt"></i> 바로 구매</a>
                <a href="javascript:check_form2('C')" class="btn btn-outline-secondary btn-lg flex-fill"><i class="fa-solid fa-cart-plus"></i> 장바구니</a>
              </div>
            </form>
          </div>
        </div>
        <hr class="my-4" style="border-top:2px solid #FFD600; opacity:0.2;">
        <div class="mt-3" style="color:#fff; font-size:1.1rem;">
          <?=$contents?>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
function cal_price() {
  var num = parseInt(document.form2.num.value) || 1;
  var price = parseInt(document.form2.price.value) || 0;
  document.form2.prices.value = (num * price).toLocaleString();
}
function check_form2(str) {
  if (document.form2.opts1 && document.form2.opts1.value==0) {
    alert("옵션1을 선택하십시요.");
    document.form2.opts1.focus();
    return;
  }
  if (document.form2.opts2 && document.form2.opts2.value==0) {
    alert("옵션2를 선택하십시요.");
    document.form2.opts2.focus();
    return;
  }
  if (!document.form2.num.value) {
    alert("수량을 입력하십시요.");
    document.form2.num.focus();
    return;
  }
  if (str == "D") {
    document.form2.action = "order.php";
    document.form2.kind.value = "order";
    document.form2.submit();
  }
  else {
    document.form2.action = "cart_edit.php";
    document.form2.submit();
  }
}
</script>
<?php
include "main_bottom.php";
?>