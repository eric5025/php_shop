<?
    include "../common.php";               // DB 연결

    // POST 요청으로 받은 회원 정보 변수에 할당(보안에 유리)
    $cookie_id = isset($_COOKIE["user_id"]) ? $_COOKIE["user_id"] : null;
    $pwd = get_param("pwd");
    $name = get_param("name");
    $tel1 = get_param("tel1");
    $tel2 = get_param("tel2");
    $tel3 = get_param("tel3");
    $tel = sprintf("%-3s%-4s%-4s", $tel1, $tel2, $tel3);
    $zip = get_param("zip");
    $juso = get_param("juso");
    $email = get_param("email");
    $birthday1 = get_param("birthday1");
    $birthday2 = get_param("birthday2");
    $birthday3 = get_param("birthday3");
    $birthday = sprintf("%04d-%02d-%02d", $birthday1, $birthday2, $birthday3);
    $gubun = get_param("gubun", "0");

    $sql = "UPDATE member 
            SET pwd='$pwd', name='$name', tel='$tel', zip='$zip', juso='$juso', email='$email', birthday='$birthday', gubun='$gubun'
            WHERE id=$cookie_id"; //쿠키 아이디

    run_query($sql);

    echo("<script>location.href='member.php'</script>");
?>