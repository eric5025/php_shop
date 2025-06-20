<?php
include 'common.php';  // 데이터베이스 연결 파일 포함

// 회원 및 비회원 구분하기
$member_id = isset($_COOKIE['cookie_id']) ? $_COOKIE['cookie_id'] : 0;

// 오늘 날짜 가져오기
$today = date("ymd");

// 오늘의 가장 큰 주문 번호 가져오기
$sql = "SELECT id FROM jumun1 WHERE jumunday = CURDATE() ORDER BY id DESC LIMIT 1";
$result = mysqli_query($db, $sql);
if (!$result) {
    die('Query Error: ' . mysqli_error($db));
}
$row = mysqli_fetch_assoc($result);

if ($row) {
    
    $last_order_id = $row['id'];
    $last_order_number = substr($last_order_id, -4); 
    $new_order_number = str_pad($last_order_number + 1, 4, '0', STR_PAD_LEFT);  // 4자리로 패딩
} else {
    $new_order_number = "0001";
}
$new_order_id = $today . $new_order_number;
$total_amount = 0;
$product_nums = 0;
$product_names = "";

$n_cart = isset($_COOKIE['n_cart']) ? intval($_COOKIE['n_cart']) : 0;
$cart = array();
if (isset($_COOKIE['cart'])) {
    $cart = json_decode($_COOKIE['cart'], true);
    if (!is_array($cart)) $cart = array();
}
error_log('n_cart: ' . $n_cart);
error_log('cart: ' . print_r($cart, true));
foreach ($cart as $pid => $item) {
    $product_id = $pid;
    $quantity = $item['quantity'];
    $opts_id1 = isset($item['opts1']) ? $item['opts1'] : 0;
    $opts_id2 = isset($item['opts2']) ? $item['opts2'] : 0;
    $sql_product = "SELECT id, name, price, discount, icon_sale FROM product WHERE id = $product_id";
    $result_product = mysqli_query($db, $sql_product);
    if (!$result_product) {
        die('Query Error1: ' . mysqli_error($db));
    }
    $row_product = mysqli_fetch_assoc($result_product);

    $product_name = $row_product['name'];
    $product_price = $row_product['price'];
    $product_discount = $row_product['discount'];
    $product_sale = $row_product['icon_sale'];
    if ($product_sale == 1) {
        $product_price = round($product_price * (100 - $product_discount) / 100, -3);
    }
    $product_total = $product_price * $quantity;
    $total_amount += $product_total;

    $product_nums++;
    if ($product_nums == 1) {
        $product_names = $product_name;
    }
    $sql_insert = "INSERT INTO jumuns (jumun_id, product_id, num, price, prices, discount, opts_id1, opts_id2) 
                   VALUES ('$new_order_id', '$product_id', '$quantity', '$product_price', '$product_total', '$product_discount', '$opts_id1', '$opts_id2')";
    if (!mysqli_query($db, $sql_insert)) {
        die('Query Error6: ' . mysqli_error($db));
    }
}
$baesongbi = 2500;
$max_baesongbi = 200000000;
// 배송비 계산
$shipping_cost = 0;
if ($total_amount < $max_baesongbi) {
    $total_amount += $baesongbi;
    $shipping_cost = $baesongbi;
}
if ($product_nums > 1) {
    $tmp = $product_nums -1;
    $product_names = $product_names . " 외 " . $tmp . "개";
}
$o_name = $_REQUEST['o_name'];
$o_tel = isset($_REQUEST['o_tel']) ? $_REQUEST['o_tel'] : (
    (isset($_REQUEST['o_tel1']) && isset($_REQUEST['o_tel2']) && isset($_REQUEST['o_tel3']))
        ? $_REQUEST['o_tel1'].'-'.$_REQUEST['o_tel2'].'-'.$_REQUEST['o_tel3'] : ''
);
$o_email = $_REQUEST['o_email'];
$o_zip = $_REQUEST['o_zip'];
$o_juso = $_REQUEST['o_juso'];
$r_name = $_REQUEST['r_name'];
$r_tel = isset($_REQUEST['r_tel']) ? $_REQUEST['r_tel'] : (
    (isset($_REQUEST['r_tel1']) && isset($_REQUEST['r_tel2']) && isset($_REQUEST['r_tel3']))
        ? $_REQUEST['r_tel1'].'-'.$_REQUEST['r_tel2'].'-'.$_REQUEST['r_tel3'] : ''
);
$r_email = $_REQUEST['r_email'];
$r_zip = $_REQUEST['r_zip'];
$r_juso = $_REQUEST['r_juso'];
$memo = $_REQUEST['memo'];
$pay_kind = isset($_REQUEST['pay_kind']) && $_REQUEST['pay_kind'] !== '' ? intval($_REQUEST['pay_kind']) : 0;
$card_okno = isset($_REQUEST['card_okno']) ? $_REQUEST['card_okno'] : '';
$card_halbu = isset($_REQUEST['card_halbu']) && $_REQUEST['card_halbu'] !== '' ? intval($_REQUEST['card_halbu']) : 0;
$card_kind = isset($_REQUEST['card_kind']) && $_REQUEST['card_kind'] !== '' ? intval($_REQUEST['card_kind']) : 0;
$bank_kind = isset($_REQUEST['bank_kind']) && $_REQUEST['bank_kind'] !== '' ? intval($_REQUEST['bank_kind']) : 0;
$bank_sender = isset($_REQUEST['bank_sender']) ? $_REQUEST['bank_sender'] : '';
$state = 1;  
$sql_order = "INSERT INTO jumun1 (id, member_id, jumunday, product_names, product_nums, o_name, o_tel, o_email, o_zip, o_juso, r_name, r_tel, r_email, r_zip, r_juso, memo, pay_kind, card_okno, card_halbu, card_kind, bank_kind, bank_sender, totalprice, state) 
              VALUES ('$new_order_id', '$member_id', NOW(), '$product_names', '$product_nums', '$o_name', '$o_tel', '$o_email', '$o_zip', '$o_juso', '$r_name', '$r_tel', '$r_email', '$r_zip', '$r_juso', '$memo', '$pay_kind', '$card_okno', '$card_halbu', '$card_kind', '$bank_kind', '$bank_sender', '$total_amount', '$state')";
if (!mysqli_query($db, $sql_order)) {
    die('Query Error4: ' . mysqli_error($db));
}
if ($shipping_cost > 0) {
    $sql_insert_shipping = "INSERT INTO jumuns (jumun_id, product_id, num, price, prices, discount, opts_id1, opts_id2) 
                            VALUES ('$new_order_id', 99999, 1, '$shipping_cost', '$shipping_cost', 0, 0, 0)";
}
header("Location: order_ok.php");
exit();
?>