<?php
$newfilename="new.txt";
if($_FILES["filename"]["error"]==0)
{
    $fname=$_FILES["filename"]["name"];
    $fsize=$_FILES["filename"]["size"];
    if(file_exists("product/$newfilename")) exit("파일이름 중복");
    if(!move_uploaded_file($_FILES["filename"]["tmp_name"],"product/$newfilename"))
            exit("파일업로드 실패");
        echo("파일이름 : $newfilename<br> 파일크기 : $fsize");
}
?>