<?
	include "common.php";
	 
	$id=$_REQUEST["id"];
	 
	$sql="delete from sj where id=$id";
   $result=mysqli_query($db,$sql);
    if (!$result) exit("에러:$sql<br>" .mysqli_error($db));

    echo("<script>location.href='sj_list.php'</script>");
?>