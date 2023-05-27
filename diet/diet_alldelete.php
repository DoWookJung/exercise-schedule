<?php
    $date= $_GET["date"];
    $meal = $_GET["meal"];
    
    include "../include/db_connect.php";
    $sql = "delete from diet_log where date='$date'"; // 레코드 삭제 명령
    mysqli_query($con, $sql);     // SQL 명령 실행


    mysqli_close($con);           // DB 접속 해제

    // 목록보기 이동
    echo "<script>
    location.href = 'diet_plus_index.php?date=$date&meal=$meal';   
	     </script>";
?>