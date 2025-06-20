<?php
// cart_edit.php: 쿠키 기반 장바구니 관리 (모든 정보 쿠키에 저장)

// GET/POST 모두에서 값 받기
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : (isset($_GET['product_id']) ? $_GET['product_id'] : (isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : null)));
$name = isset($_POST['name']) ? $_POST['name'] : (isset($_GET['name']) ? $_GET['name'] : null);
$price = isset($_POST['price']) ? $_POST['price'] : (isset($_GET['price']) ? $_GET['price'] : null);
$image = isset($_POST['image']) ? $_POST['image'] : (isset($_GET['image']) ? $_GET['image'] : null);
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : (isset($_GET['quantity']) ? intval($_GET['quantity']) : (isset($_POST['num']) ? intval($_POST['num']) : (isset($_GET['num']) ? intval($_GET['num']) : null)));
$kind = isset($_POST['kind']) ? $_POST['kind'] : (isset($_GET['kind']) ? $_GET['kind'] : null);
$opts1 = isset($_POST['opts1']) ? $_POST['opts1'] : (isset($_GET['opts1']) ? $_GET['opts1'] : null);
$opts2 = isset($_POST['opts2']) ? $_POST['opts2'] : (isset($_GET['opts2']) ? $_GET['opts2'] : null);
$opts1_name = isset($_POST['opts1_name']) ? $_POST['opts1_name'] : (isset($_GET['opts1_name']) ? $_GET['opts1_name'] : null);
$opts2_name = isset($_POST['opts2_name']) ? $_POST['opts2_name'] : (isset($_GET['opts2_name']) ? $_GET['opts2_name'] : null);
// deleteall 처리
if ($kind === 'deleteall') {
    setcookie('cart', '', time() - 3600, '/');
    header('Location: cart.php');
    exit;
}

// 기존 장바구니 쿠키 읽기
$cart = array();
if (isset($_COOKIE['cart'])) {
    $cart = json_decode($_COOKIE['cart'], true);
    if (!is_array($cart)) $cart = array();
}

// 상품 추가/수정/삭제
if ($product_id !== null && $quantity !== null) {
    if ($quantity > 0 && $name !== null && $price !== null && $image !== null && $name !== '' && $price !== '' && $image !== '') {
        $cart[$product_id] = array(
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'quantity' => $quantity,
            'opts1' => $opts1,
            'opts2' => $opts2,
            'opts1_name' => $opts1_name,
            'opts2_name' => $opts2_name
        );
    } else {
        // 수량이 0이면 삭제
        unset($cart[$product_id]);
    }
    // 쿠키에 저장 (1주일 유지)
    setcookie('cart', json_encode($cart), time() + 60*60*24*7, '/');
    header('Location: cart.php');
    exit;
} else {
    echo json_encode(array('result' => 'error', 'message' => '상품 정보가 올바르지 않습니다.', 'debug' => [
        'product_id' => $product_id,
        'name' => $name,
        'price' => $price,
        'image' => $image,
        'quantity' => $quantity
    ]));
    exit;
}
?> 