<?php
    include "../common.php";

    $id = get_param("id");

    $sql = "DELETE FROM member WHERE id = $id";
    run_query($sql);

    echo("<script>location.href='member.php'</script>");
?>