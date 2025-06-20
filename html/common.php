<?
    error_reporting(E_ALL  &  ~E_NOTICE  &  ~E_WARNING);
    ini_set("display_errors", 1);

    mysqli_report( MYSQLI_REPORT_OFF );

    $db= mysqli_connect("localhost", "shop15", "1234", "shop15");
    if (!$db) exit("DB연결에러");

    $a_menu=array("메뉴선택", "Lamborghini","ferrari","mclaren","porsche","benz","bmw");
	$n_menu=count($a_menu);

$a_status = array("상태선택", "판매중", "판매중지", "품절");
$n_status = count($a_status);

$baesongbi=2500;
$max_baesongbi=50000;

 $admin_id = "admin";
 $admin_pw = "1234";

    $page_line=5;
    $page_block=5;

 function mypagination($query, $args, &$count, &$pagebar)
 {
  global $db, $page_line, $page_block;

  $page=$_REQUEST["page"] ? $_REQUEST["page"] : 1;

  $url=basename($_SERVER['PHP_SELF']) . "?" . $args;

  $sql = strtolower( $query );
  $sql ="select count(*) " . substr($sql, strpos($sql,"from"));
  $result=mysqli_query($db, $sql);
  if (!$result) exit("에러: $sql");
  $row=mysqli_fetch_array($result);
  $count = $row[0];

  $first = ($page-1) * $page_line;

  $sql = str_replace(";", "", $query);
  $sql .= " limit $first, $page_line";
  $result=mysqli_query($db, $sql);
  if (!$result) exit("에러: $sql");

  $pages = ceil($count/$page_line);
  $blocks = ceil($pages/$page_block);
  $block = ceil($page/$page_block);
  $page_s = $page_block * ($block-1);
  $page_e = $page_block * $block;
  if ($blocks <= $block) $page_e = $pages;

  $pagebar ="<nav>
   <ul class='pagination pagination-sm justify-content-center py-1'>";

  if ($block > 1)
   $pagebar .="<li class='page-item'>
     <a class='page-link' href='$url&page=$page_s'>◀</a>
    </li>";

  for($i=$page_s+1; $i<=$page_e; $i++)
  {
   if ($page == $i)
    $pagebar .="<li class='page-item active'>
      <span class='page-link mycolor1'>$i</span>
     </li>";
   else
    $pagebar .="<li class='page-item'>
      <a class='page-link' href='$url&page=$i'>$i</a>
     </li>";
  }

  if ($block < $blocks)
   $pagebar .="<li class='page-item'>
     <a class='page-link' href='$url&page=" . $page_e+1 . "'>▶</a>
    </li>";

  $pagebar .="</ul>
   </nav>";

  return $result;
 }

$a_state = array("상태선택", "주문신청", "주문확인", "입금확인", "배달중", "주문완료", "주문취소");
$a_card_kind = array(1 => '국민카드', 2 => '신한카드', 3 => '우리카드', 4 => '하나카드');
$a_bank_kind = array(1 => '국민은행', 2 => '신한은행');

function get_param($name, $default = null) {
    return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
}

function run_query($sql) {
    global $db;
    $result = mysqli_query($db, $sql);
    if (!$result) {
        exit("에러: " . mysqli_error($db));
    }
    return $result;
}

?>