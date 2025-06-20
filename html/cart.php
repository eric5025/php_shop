<?
include "maintop.php";
include "common.php";

// 장바구니 쿠키 읽기
$cart = array();
if (isset($_COOKIE['cart'])) {
    $cart = json_decode($_COOKIE['cart'], true);
    if (!is_array($cart)) $cart = array();
}

// 합계 계산
$total_price = 0;
foreach ($cart as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
$baesongbi = 2500;
$max_baesongbi = 50000;
if ($total_price >= $max_baesongbi) {
    $baesongbi = 0;
}
$final_price = $total_price + $baesongbi;
?>

<!-- 슈퍼카 장바구니 카드 레이아웃 -->
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card p-4" style="background:#232323; border-radius:2rem; box-shadow:0 4px 24px #000a;">
        <h2 class="mb-4 text-center" style="color:#FFD600; font-weight:900; letter-spacing:-1px;">장바구니</h2>
        <hr class="mb-4" style="border-top:2px solid #FFD600; opacity:0.2;">
        <form name="form2" method="post" action="">
          <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-4" style="border-radius:1rem; overflow:hidden;">
              <thead>
                <tr style="background:#181818; color:#FFD600;">
                  <th style="width:10%;">이미지</th>
                  <th style="width:35%;">상품정보</th>
                  <th style="width:10%;">판매가</th>
                  <th style="width:20%;">수량</th>
                  <th style="width:10%;">금액</th>
                  <th style="width:10%;">삭제</th>
                </tr>
              </thead>
              <tbody>
                <? if (count($cart) == 0) { ?>
                  <tr>
                    <td colspan="6" class="text-center py-5">
                      <div class="alert alert-danger mb-0" style="background:#232323; color:#D90429; border:1.5px solid #D90429;">
                        <i class="fa-solid fa-cart-shopping fa-lg me-2"></i>장바구니가 비어 있습니다.
                      </div>
                    </td>
                  </tr>
                <? } else { $i=1; foreach ($cart as $pid => $item) { ?>
                  <tr style="font-size:15px;">
                    <td>
                      <a href="product_detail.php?id=<?= $pid ?>">
                        <img src="<?= htmlspecialchars($item['image']) ?>" width="70" height="70" class="rounded shadow-sm" style="background:#111; object-fit:cover;">
                      </a>
                    </td>
                    <td class="text-start">
                      <a href="product_detail.php?id=<?= $pid ?>" style="color:#FFD600; font-weight:700; font-size:1.1rem;">
                        <?= htmlspecialchars($item['name']) ?>
                      </a><br>
                      <small style="color:#aaa;">
                        <b>[옵션]</b> 
                        <?php
                        if (!empty($item['opts1_name'])) echo htmlspecialchars($item['opts1_name']) . ' ';
                        else if (!empty($item['opts1'])) echo htmlspecialchars($item['opts1']) . ' ';
                        if (!empty($item['opts2_name'])) echo htmlspecialchars($item['opts2_name']);
                        else if (!empty($item['opts2'])) echo htmlspecialchars($item['opts2']);
                        if (empty($item['opts1']) && empty($item['opts2']) && empty($item['opts1_name']) && empty($item['opts2_name'])) echo '-';
                        ?>
                      </small>
                    </td>
                    <td style="color:#FFD600; font-weight:700;"><?= number_format($item['price']) ?>원</td>
                    <td>
                      <div class="d-flex align-items-center">
                        <input type="text" name="num<?= $pid ?>" size="2" value="<?= $item['quantity'] ?>" class="form-control form-control-sm text-center me-2" style="max-width:60px; background:#181818; color:#FFD600; border:1.5px solid #FFD600;">
                        <a href = "javascript:cart_edit('update','<?= $pid ?>')" class="btn btn-primary btn-sm" style="font-size:13px;">수정</a> 
                      </div>
                    </td>
                    <td style="color:#FFD600; font-weight:700;"><?= number_format($item['price'] * $item['quantity']) ?>원</td>
                    <td>
                      <a href = "javascript:cart_edit('delete','<?= $pid ?>')" class="btn btn-danger btn-sm" style="font-size:13px;">삭제</a> 
                    </td>
                  </tr>
                <? $i++; }} ?>
                <? if (count($cart) > 0) { ?>
                <tr style="background:#181818; color:#FFD600; font-size:16px;">
                  <td align="center"><i class="fa-solid fa-coins fa-lg"></i></td>
                  <td colspan="5" class="text-end pe-4">
                    <span style="color:#FFD600; font-weight:700;">총 합계금액</span> : 상품구매금액( <?= number_format($total_price) ?>원 ) + 배송비( <?= number_format($baesongbi) ?>원 ) = <span style="font-size:18px; color:#FFD600; font-weight:900;"> <?= number_format($final_price) ?>원</span>
                  </td>
                </tr>
                <? } ?>
              </tbody>
            </table>
          </div>
          <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
            <a href="index.html"  class="btn btn-outline-secondary btn-lg px-4"><i class="fa-solid fa-arrow-left"></i> 계속 쇼핑하기</a>
            <a href="javascript:cart_edit('deleteall',0)"  class="btn btn-danger btn-lg px-4"><i class="fa-solid fa-trash"></i> 장바구니 비우기</a>
            <a href="order.php"  class="btn btn-primary btn-lg px-4"><i class="fa-solid fa-credit-card"></i> 결제하기</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  function cart_edit(kind, pos) {
    if (kind == "deleteall")
      location.href = "cart_edit.php?kind=deleteall";
    else if (kind == "delete")
      location.href = "cart_edit.php?product_id=" + pos + "&quantity=0";
    else if (kind == "insert" || kind == "update") {
      var num = document.forms['form2']["num" + pos].value;
      var item = cart_items[pos];
      var opts1 = (item.opts1 !== undefined && item.opts1 !== null) ? item.opts1 : "";
      var opts2 = (item.opts2 !== undefined && item.opts2 !== null) ? item.opts2 : "";
      var opts1_name = (item.opts1_name !== undefined && item.opts1_name !== null) ? item.opts1_name : "";
      var opts2_name = (item.opts2_name !== undefined && item.opts2_name !== null) ? item.opts2_name : "";
      location.href = "cart_edit.php?product_id=" + pos
        + "&name=" + encodeURIComponent(item.name)
        + "&price=" + item.price
        + "&image=" + encodeURIComponent(item.image)
        + "&quantity=" + num
        + "&opts1=" + encodeURIComponent(opts1)
        + "&opts2=" + encodeURIComponent(opts2)
        + "&opts1_name=" + encodeURIComponent(opts1_name)
        + "&opts2_name=" + encodeURIComponent(opts2_name);
    }
  }
  // PHP에서 cart 배열을 JS로 전달
  var cart_items = <?php echo json_encode($cart); ?>;
</script>
<?
include "main_bottom.php";
?>
