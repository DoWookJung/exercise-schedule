<?php
session_start();
include "../../include/db_connect.php";

if (isset($_SESSION["username"])) 
$username = $_SESSION["username"];
else 
$username = "";  

// POST 데이터 가져오기
$date = $_POST["date"];
$weight = $_POST["weight"];
$exercise = $_POST["exercise_name"];
$reps = $_POST["reps"];
$sets = $_POST["sets"];

// SQL 쿼리 작성
$sql = "INSERT INTO workout_records (date, weight, exercise, reps, sets, name) 
        VALUES ('$date', '$weight', '$exercise', '$reps', '$sets', '$username')";

// 쿼리 실행
if (mysqli_query($con, $sql)) {
    // echo "Record added successfully";
    echo "<script>
	    location.href = 'index.php?date=$date';
	   </script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

// 데이터베이스 접속 종료
mysqli_close($con);
?>
