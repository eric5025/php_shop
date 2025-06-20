<? 
  include "../common.php"; 
  $id=$_REQUEST["id"];
  
  $query="delete from opt where id=".$id;
  $res=mysqli_query($db,$query);
  
  if (!$res){
    echo "에러: ".mysqli_error($db);
    exit();
  }
  
  echo ("<script>document.location.href='opt.php'</script>"); 
?>
