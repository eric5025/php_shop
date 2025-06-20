<?
    include "common.php";               // DB 연결

   $name=$_REQUEST["name"];    // 혹은  $name=$_POST["name"]; 이름 정보 수신
   $tel1 = $_REQUEST["tel1"];         // 전화번호의 첫 번째 부분 수신
   $tel2 = $_REQUEST["tel2"];         // 전화번호의 두 번째 부분 수신
   $tel3 = $_REQUEST["tel3"];         // 전화번호의 세 번째 부분 수신
   $tel= sprintf("%-3s%-4s%-4s", $tel1, $tel2, $tel3); // 전화번호 조합
   $sm=$_REQUEST["sm"];          // 음력/양력 정보 수신
   $birthday1 = $_REQUEST["birthday1"]; // 생일의 연도 부분 수신
   $birthday2 = $_REQUEST["birthday2"]; // 생일의 월 부분 수신
   $birthday3 = $_REQUEST["birthday3"]; // 생일의 일 부분 수신
   $birthday = sprintf("%04d-%02d-%02d", $birthday1, $birthday2, $birthday3); // 생일 조합
   $juso=$_REQUEST["juso"];     // 주소 정보 수신

    // juso 테이블에 새로운 주소록 항목을 삽입하는 SQL 쿼리 작성
    $sql="INSERT INTO juso (name, tel, sm, birthday, juso)
          VALUES ('$name', '$tel', $sm, '$birthday', '$juso')";

    // SQL 쿼리 실행
    $result=mysqli_query($db, $sql);

    // 쿼리 실행 결과 확인 및 에러 처리
    if (!$result) exit("에러: $sql");

    // 주소록 리스트 페이지로 리다이렉션
    echo("<script>location.href='juso_list.php'</script>");
?>