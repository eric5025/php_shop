<?php
include "common.php";      

include "maintop.php";
$member = null;
if (isset($_COOKIE['cookie_id'])) {
    $cookie_id = $_COOKIE['cookie_id'];
    $sql = "SELECT * FROM member WHERE id=$cookie_id";
    $result = mysqli_query($db, $sql);
    if ($result) {
        $member = mysqli_fetch_array($result);
    }
}
$cart = array();
if (isset($_COOKIE['cart'])) {
    $cart = json_decode($_COOKIE['cart'], true);
    if (!is_array($cart)) $cart = array();
}
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

<!-- 슈퍼카 주문 카드 레이아웃 -->
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card p-4" style="background:#232323; border-radius:2rem; box-shadow:0 4px 24px #000a;">
        <h2 class="mb-4 text-center" style="color:#FFD600; font-weight:900; letter-spacing:-1px;">주문/배송 정보</h2>
        <hr class="mb-4" style="border-top:2px solid #FFD600; opacity:0.2;">
        <div class="table-responsive mb-4">
          <table class="table table-dark table-hover align-middle mb-0" style="border-radius:1rem; overflow:hidden;">
            <thead>
              <tr style="background:#181818; color:#FFD600;">
                <th style="width:10%;">이미지</th>
                <th style="width:35%;">상품정보</th>
                <th style="width:15%;">판매가</th>
                <th style="width:20%;">수량</th>
                <th style="width:15%;">금액</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($cart) == 0) { ?>
                <tr><td colspan="5" class="text-center py-5">
                  <div class="alert alert-danger mb-0" style="background:#232323; color:#D90429; border:1.5px solid #D90429;">
                    <i class="fa-solid fa-cart-shopping fa-lg me-2"></i>장바구니가 비어 있습니다.
                  </div>
                </td></tr>
              <?php } else { foreach ($cart as $pid => $item) { ?>
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
                <td style="color:#FFD600; font-weight:700;"> <?= number_format($item['price']) ?>원</td>
                <td style="color:#FFD600; font-weight:700;"> <?= $item['quantity'] ?> </td>
                <td style="color:#FFD600; font-weight:700;"> <?= number_format($item['price'] * $item['quantity']) ?>원</td>
              </tr>
              <?php }} ?>
              <?php if (count($cart) > 0) { ?>
              <tr style="background:#181818; color:#FFD600; font-size:16px;">
                <td align="center"><i class="fa-solid fa-coins fa-lg"></i></td>
                <td colspan="4" class="text-end pe-4">
                  <span style="color:#FFD600; font-weight:700;">총금액</span> : 상품( <?= number_format($total_price) ?>원 ) + 배송비( <?= number_format($baesongbi) ?>원 ) = <span style="font-size:18px; color:#FFD600; font-weight:900;"> <?= number_format($final_price) ?>원</span>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- 주문/배송 정보 폼 -->
        <form name="form2" method="post" action="order_pay.php" onsubmit="return Check_Value();">
          <div class="row g-4 mb-4">
            <div class="col-md-6">
              <div class="p-3 rounded" style="background:#181818;">
                <h5 class="mb-3" style="color:#FFD600; font-weight:700;">주문자 정보</h5>
                <div class="mb-2">
                  <label class="form-label">이름 <span style="color:#D90429;">*</span></label>
                  <input type="text" name="o_name" value="<?= $member ? htmlspecialchars($member['name']) : '' ?>" class="form-control" required>
                </div>
                <div class="mb-2">
                  <label class="form-label">휴대폰 <span style="color:#D90429;">*</span></label>
                  <div class="d-flex gap-2">
                    <input type="text" name="o_tel1" maxlength="3" value="<?= $member ? htmlspecialchars(substr($member['tel'],0,3)) : '010' ?>" class="form-control" style="max-width:70px;" required> -
                    <input type="text" name="o_tel2" maxlength="4" value="<?= $member ? htmlspecialchars(substr($member['tel'],3,4)) : '' ?>" class="form-control" style="max-width:90px;" required> -
                    <input type="text" name="o_tel3" maxlength="4" value="<?= $member ? htmlspecialchars(substr($member['tel'],7,4)) : '' ?>" class="form-control" style="max-width:90px;" required>
                  </div>
                </div>
                <div class="mb-2">
                  <label class="form-label">이메일 <span style="color:#D90429;">*</span></label>
                  <input type="email" name="o_email" value="<?= $member ? htmlspecialchars($member['email']) : '' ?>" class="form-control" required>
                </div>
                <div class="mb-2">
                  <label class="form-label">주소 <span style="color:#D90429;">*</span></label>
                  <div class="d-flex gap-2 mb-2">
                    <input type="text" name="o_zip" maxlength="5" value="<?= $member ? htmlspecialchars($member['zip']) : '' ?>" class="form-control" style="max-width:100px;" required>
                    <a href="javascript:FindZip(1)" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-magnifying-glass-location"></i> 우편번호 찾기</a>
                  </div>
                  <input type="text" name="o_juso" value="<?= $member ? htmlspecialchars($member['juso']) : '' ?>" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded" style="background:#181818;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5 style="color:#FFD600; font-weight:700;">수령자 정보</h5>
                  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="SameCopy('Y')"><i class="fa-solid fa-arrow-down"></i> 주문자와 동일</button>
                  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="SameCopy('N')"><i class="fa-solid fa-eraser"></i> 초기화</button>
                </div>
                <div class="mb-2">
                  <label class="form-label">이름 <span style="color:#D90429;">*</span></label>
                  <input type="text" name="r_name" class="form-control" required>
                </div>
                <div class="mb-2">
                  <label class="form-label">휴대폰 <span style="color:#D90429;">*</span></label>
                  <div class="d-flex gap-2">
                    <input type="text" name="r_tel1" maxlength="3" class="form-control" style="max-width:70px;" required> -
                    <input type="text" name="r_tel2" maxlength="4" class="form-control" style="max-width:90px;" required> -
                    <input type="text" name="r_tel3" maxlength="4" class="form-control" style="max-width:90px;" required>
                  </div>
                </div>
                <div class="mb-2">
                  <label class="form-label">이메일 <span style="color:#D90429;">*</span></label>
                  <input type="email" name="r_email" class="form-control" required>
                </div>
                <div class="mb-2">
                  <label class="form-label">주소 <span style="color:#D90429;">*</span></label>
                  <div class="d-flex gap-2 mb-2">
                    <input type="text" name="r_zip" maxlength="5" class="form-control" style="max-width:100px;" required>
                    <a href="javascript:FindZip(2)" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-magnifying-glass-location"></i> 우편번호 찾기</a>
                  </div>
                  <input type="text" name="r_juso" class="form-control" required>
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg px-5"><i class="fa-solid fa-credit-card"></i> 결제 단계로 이동</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function Check_Value() {
  if (!form2.o_name.value) { alert("주문자 이름이 잘못 되었습니다."); form2.o_name.focus(); return false; }
  if (!form2.o_tel1.value || !form2.o_tel2.value || !form2.o_tel3.value) { alert("핸드폰이 잘못 되었습니다."); form2.o_tel1.focus(); return false; }
  if (!form2.o_email.value) { alert("이메일이 잘못 되었습니다."); form2.o_email.focus(); return false; }
  if (!form2.o_zip.value) { alert("우편번호가 잘못 되었습니다."); form2.o_zip.focus(); return false; }
  if (!form2.o_juso.value) { alert("주소가 잘못 되었습니다."); form2.o_juso.focus(); return false; }
  if (!form2.r_name.value) { alert("받으실 분의 이름이 잘못 되었습니다."); form2.r_name.focus(); return false; }
  if (!form2.r_tel1.value || !form2.r_tel2.value || !form2.r_tel3.value) { alert("핸드폰이 잘못 되었습니다."); form2.r_tel1.focus(); return false; }
  if (!form2.r_email.value) { alert("이메일이 잘못 되었습니다."); form2.r_email.focus(); return false; }
  if (!form2.r_zip.value) { alert("우편번호가 잘못 되었습니다."); form2.r_zip.focus(); return false; }
  if (!form2.r_juso.value) { alert("주소가 잘못 되었습니다."); form2.r_juso.focus(); return false; }
  return true;
}
function FindZip(zip_kind) {
  window.open("zipcode.php?zip_kind="+zip_kind, "", "scrollbars=no,width=490,height=320");
}
function SameCopy(str) {
  if (str == "Y") {
    form2.r_name.value = form2.o_name.value;
    form2.r_zip.value = form2.o_zip.value;
    form2.r_juso.value = form2.o_juso.value;
    form2.r_tel1.value = form2.o_tel1.value;
    form2.r_tel2.value = form2.o_tel2.value;
    form2.r_tel3.value = form2.o_tel3.value;
    form2.r_email.value = form2.o_email.value;
  } else {
    form2.r_name.value = "";
    form2.r_zip.value = "";
    form2.r_juso.value = "";
    form2.r_tel1.value = "";
    form2.r_tel2.value = "";
    form2.r_tel3.value = "";
    form2.r_email.value = "";
  }
}
</script>

<?php
include "main_bottom.php";
?>