<?php
    // POST로 전달된 데이터 저장
    $id = $_POST['id'];
    $date = $_POST['date'];
    $exercise = $_POST['exercise'];
    $weight = $_POST['weight'];
    $reps = $_POST['reps'];
    $sets = $_POST['sets'];

    include "../../include/db_connect.php";
      // 레코드 변경
      for($i = 0; $i < count($id); $i++) {
        $sql = "update workout_records set exercise='" . $exercise[$i] . "', weight='" . $weight[$i] . 
        "', reps='" . $reps[$i] . "', sets='" . $sets[$i] . "' where id=" . $id[$i];
        mysqli_query($con, $sql);     // SQL 명령 실행
    }


    mysqli_close($con);           // DB 접속 해제

    // 목록보기 이동
    echo "<script>
	         location.href = 'index.php?date=$date';      
	     </script>";
?>