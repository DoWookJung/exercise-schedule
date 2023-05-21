<?php
    // POST로 전달된 데이터 저장
    $id = $_POST['id'];
    $date = $_POST['date'];
    $meal = $_POST['meal'];
    $food_name = $_POST['food_name'];
    $amount = $_POST['amount'];
    $calories = $_POST['calories'];

    include "../include/db_connect.php";
      // 레코드 변경
      for($i = 0; $i < count($id); $i++) {
        $original_meal = $meal[$i];
        $sql = "update diet_log set meal='" . $meal[$i] . "', food_name='" . $food_name[$i] . 
        "', amount='" . $amount[$i] . "', calories='" . $calories[$i] . "' where id=" . $id[$i];
        mysqli_query($con, $sql);     // SQL 명령 실행
    }


    mysqli_close($con);           // DB 접속 해제

    // 목록보기 이동
    echo "<script>
	         location.href = 'diet_plus_index.php?date=$date&meal=$original_meal';      
	     </script>";
?>