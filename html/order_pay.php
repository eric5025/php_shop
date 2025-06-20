<?php
if (!isset($_REQUEST['o_name']) || !isset($_REQUEST['r_name'])) {
    echo '<div style="padding:40px;text-align:center;color:red;font-size:20px;">잘못된 접근입니다.<br>주문서에서 정보를 입력하고 다시 시도해 주세요.</div>';
    include "main_bottom.php";
    exit;
}
?>
<? 
include "maintop.php" ;
// $n_cart = isset($_COOKIE['n_cart']) ? intval($_COOKIE['n_cart']) : 0;
// $cart = isset($_COOKIE['cart']) ? $_COOKIE['cart'] : [];
// if (isset($_COOKIE['cookie_id'])) {
//     $cookie_id = $_COOKIE['cookie_id'];
//     $sql = "SELECT * FROM member WHERE id='$cookie_id'";
//     $result = mysqli_query($db, $sql);
//     if ($row = mysqli_fetch_assoc($result)) {
//         $o_name = $row['name'];
//         $o_tel = $row['tel'];
//         $o_email = $row['email'];
//         $o_zip = $row['zip'];
//         $o_juso = $row['juso'];
//     }
// }

$baesongbi = 2500;
$max_baesongbi = 50000;
$shipping_cost = 0;
$cart = [];
if (isset($_COOKIE['cart'])) {
    $cart = json_decode($_COOKIE['cart'], true);
    if (!is_array($cart)) $cart = [];
}

?>
<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<script>
	function Check_Value() 
	{
		var form = document.forms['form2'];
		if (form.pay_kind[0].checked)
		{
			if (form.card_kind.value==0) {
				alert("카드종류를 선택하세요.");	form.card_kind.focus();	return false;
			}
			if (!form.card_no1.value) {
				alert("카드번호를 입력하세요.");	form.card_no1.focus();	return false;
			}
			if (!form.card_no2.value) {
				alert("카드번호를 입력하세요.");	form.card_no2.focus();	return false;
			}
			if (!form.card_no3.value) {
				alert("카드번호를 입력하세요.");	form.card_no3.focus();	return false;
			}
			if (!form.card_no4.value) {
				alert("카드번호를 입력하세요.");	form.card_no4.focus();	return false;
			}
			if (!form.card_month.value) {
				alert("카드기간 월을 입력하세요.");	form.card_month.focus();	return false;
			}
			if (!form.card_year.value) {
				alert("카드기간 년도를 입력하세요.");	form.card_year.focus();	return false;
			}
			if (!form.card_pw.value) {
				alert("카드 비밀번호 뒷의 2자리를 입력하세요.");	form.card_pw.focus();	return false;
			}
		}
		else
		{
			if (form.bank_kind.value==0) {
				alert("입금할 은행을 선택하세요.");	form.bank_kind.focus();	return false;
			}
			if (!form.bank_sender.value) {
				alert("입금자 이름을 입력하세요.");	form.bank_sender.focus();	return false;
			}
		}
		form.card_kind.disabled = false;
		form.card_no1.disabled = false;
		form.card_no2.disabled = false;
		form.card_no3.disabled = false;
		form.card_no4.disabled = false;
		form.card_year.disabled = false;
		form.card_month.disabled = false;
		form.card_pw.disabled = false;
		form.card_halbu.disabled = false;
		form.bank_kind.disabled = false;
		form.bank_sender.disabled = false;
		return true;
	}

	function PaySel(n) 
	{
		var form = document.forms['form2'];
		var cardArea = document.getElementById('card_area');
		var bankArea = document.getElementById('bank_area');
		if (n == 0) {
			cardArea.style.display = '';
			bankArea.style.display = 'none';
			form.card_kind.disabled = false;
			form.card_no1.disabled = false;
			form.card_no2.disabled = false;
			form.card_no3.disabled = false;
			form.card_no4.disabled = false;
			form.card_year.disabled = false;
			form.card_month.disabled = false;
			form.card_halbu.disabled = false;
			form.card_pw.disabled = false;
			form.bank_kind.disabled = true;
			form.bank_sender.disabled = true;
		}
		else {
			cardArea.style.display = 'none';
			bankArea.style.display = '';
			form.card_kind.disabled = true;
			form.card_no1.disabled = true;
			form.card_no2.disabled = true;
			form.card_no3.disabled = true;
			form.card_no4.disabled = true;
			form.card_year.disabled = true;
			form.card_month.disabled = true;
			form.card_halbu.disabled = true;
			form.card_pw.disabled = true;
			form.bank_kind.disabled = false;
			form.bank_sender.disabled = false;
		}
	}
</script>

<!-- 슈퍼카 결제 카드 레이아웃 -->
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card p-4" style="background:#232323; border-radius:2rem; box-shadow:0 4px 24px #000a;">
        <h2 class="mb-4 text-center" style="color:#FFD600; font-weight:900; letter-spacing:-1px;">결제 정보</h2>
        <hr class="mb-4" style="border-top:2px solid #FFD600; opacity:0.2;">
        <div class="table-responsive mb-4">
          <table class="table table-dark table-hover align-middle mb-0" style="border-radius:1rem; overflow:hidden;">
            <thead>
              <tr style="background:#181818; color:#FFD600;">
                <th style="width:10%;">이미지</th>
                <th style="width:35%;">상품정보</th>
                <th style="width:10%;">판매가</th>
                <th style="width:20%;">수량</th>
                <th style="width:10%;">금액</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $total_price = 0;
                foreach ($cart as $pid => $item) {
                    $item_price = $item['price'];
                    $item_total = $item_price * $item['quantity'];
                    $total_price += $item_total;
              ?>
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
                  <td style="color:#FFD600; font-weight:700;"> <?= number_format($item_price) ?>원</td>
                  <td style="color:#FFD600; font-weight:700;"> <?= $item['quantity'] ?> </td>
                  <td style="color:#FFD600; font-weight:700;"> <?= number_format($item_total) ?>원</td>
                </tr>
              <?php } ?>
              <tr style="background:#181818; color:#FFD600; font-size:16px;">
                <td align="center"><i class="fa-solid fa-coins fa-lg"></i></td>
                <td colspan="4" class="text-end pe-4">
                  <span style="color:#FFD600; font-weight:700;">총 합계금액</span> : 상품구매금액( <?=number_format($total_price)?>원 )
                  <?php if ($shipping_cost > 0): ?>
                    + 배송비( <?=number_format($shipping_cost)?>원 )
                  <?php endif; ?>
                  = <span style="font-size:18px; color:#FFD600; font-weight:900;"> <?=number_format($total_price + $shipping_cost)?>원</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- 결제 정보 폼 -->
        <form name="form2" method="post" action="order_insert.php" onsubmit="return Check_Value();">
          <?php
          $o_tel = $_REQUEST['o_tel1'] . '-' . $_REQUEST['o_tel2'] . '-' . $_REQUEST['o_tel3'];
          $r_tel = $_REQUEST['r_tel1'] . '-' . $_REQUEST['r_tel2'] . '-' . $_REQUEST['r_tel3'];
          ?>
          <input type="hidden" name="o_name" value="<?=$_REQUEST['o_name']?>">
          <input type="hidden" name="o_tel" value="<?=$o_tel?>">
          <input type="hidden" name="o_email" value="<?=$_REQUEST['o_email']?>">
          <input type="hidden" name="o_zip" value="<?=$_REQUEST['o_zip']?>">
          <input type="hidden" name="o_juso" value="<?=$_REQUEST['o_juso']?>">
          <input type="hidden" name="r_name" value="<?=$_REQUEST['r_name']?>">
          <input type="hidden" name="r_tel" value="<?=$r_tel?>">
          <input type="hidden" name="r_email" value="<?=$_REQUEST['r_email']?>">
          <input type="hidden" name="r_zip" value="<?=$_REQUEST['r_zip']?>">
          <input type="hidden" name="r_juso" value="<?=$_REQUEST['r_juso']?>">
          <div class="row g-4 mb-4">
            <div class="col-md-6">
              <div class="p-3 rounded" style="background:#181818;">
                <h5 class="mb-3" style="color:#FFD600; font-weight:700;">결제수단 선택</h5>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="radio" name="pay_kind" id="pay_card" value="0" checked onclick="PaySel(0)">
                  <label class="form-check-label" for="pay_card"><i class="fa-solid fa-credit-card"></i> 신용카드 결제</label>
                </div>
                <div class="form-check mb-3">
                  <input class="form-check-input" type="radio" name="pay_kind" id="pay_bank" value="1" onclick="PaySel(1)">
                  <label class="form-check-label" for="pay_bank"><i class="fa-solid fa-building-columns"></i> 무통장 입금</label>
                </div>
                <div id="card_area">
                  <div class="mb-2">
                    <label class="form-label">카드종류</label>
                    <select name="card_kind" class="form-select">
                      <option value="0">카드종류 선택</option>
                      <option value="1">VISA</option>
                      <option value="2">MASTER</option>
                      <option value="3">AMEX</option>
                    </select>
                  </div>
                  <div class="mb-2">
                    <label class="form-label">카드번호</label>
                    <div class="d-flex gap-2">
                      <input type="text" name="card_no1" maxlength="4" class="form-control" style="max-width:70px;">
                      <input type="text" name="card_no2" maxlength="4" class="form-control" style="max-width:70px;">
                      <input type="text" name="card_no3" maxlength="4" class="form-control" style="max-width:70px;">
                      <input type="text" name="card_no4" maxlength="4" class="form-control" style="max-width:70px;">
                    </div>
                  </div>
                  <div class="mb-2">
                    <label class="form-label">유효기간</label>
                    <div class="d-flex gap-2">
                      <input type="text" name="card_month" maxlength="2" class="form-control" style="max-width:60px;" placeholder="MM">
                      <input type="text" name="card_year" maxlength="2" class="form-control" style="max-width:60px;" placeholder="YY">
                    </div>
                  </div>
                  <div class="mb-2">
                    <label class="form-label">카드 비밀번호(뒷2자리)</label>
                    <input type="password" name="card_pw" maxlength="2" class="form-control" style="max-width:80px;">
                  </div>
                </div>
                <div id="bank_area" style="display:none;">
                  <div class="mb-2">
                    <label class="form-label">입금은행</label>
                    <select name="bank_kind" class="form-select">
                      <option value="0">은행 선택</option>
                      <option value="1">국민은행</option>
                      <option value="2">신한은행</option>
                      <option value="3">우리은행</option>
                      <option value="4">하나은행</option>
                    </select>
                  </div>
                  <div class="mb-2">
                    <label class="form-label">입금자명</label>
                    <input type="text" name="bank_sender" class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center">
              <button type="submit" class="btn btn-primary btn-lg px-5 mt-4 mt-md-0"><i class="fa-solid fa-check"></i> 결제하기</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<br><br><br>

<!-------------------------------------------------------------------------------------------->	
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	
<? 
include "main_bottom.php" 
?>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>