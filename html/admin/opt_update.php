<?
include "../common.php";
$id = $_REQUEST["id"];
$name = $_REQUEST["name"];
$sql = "UPDATE opt SET name='$name' WHERE id=$id;";
$result = mysqli_query($db, $sql);
if (!$result) {
  exit("에러: $sql");
}
echo ("<script>location.href='opt.php'</script>");
?>