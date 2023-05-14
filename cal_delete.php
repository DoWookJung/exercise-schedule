<?php
    $id = $_GET["id"];
    $date= $_GET["date"];
    
    include "./include/db_connect.php";
    $sql = "delete from workout_records where id=$id"; // 레코드 삭제 명령
    mysqli_query($con, $sql);     // SQL 명령 실행


    mysqli_close($con);           // DB 접속 해제

    // 목록보기 이동
    echo "<script>
	         location.href = 'index.php?date=$date';      
	     </script>";
?>