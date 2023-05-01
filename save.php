<?php
include "./include/db_connect.php";

// POST 데이터 가져오기
$date = $_POST["date"];
$weight = $_POST["weight"];
$exercise = $_POST["exercise"];
$reps = $_POST["reps"];
$sets = $_POST["sets"];

// SQL 쿼리 작성
$sql = "INSERT INTO workout_records (date, weight, exercise, reps, sets) VALUES ('$date', '$weight', '$exercise', '$reps', '$sets')";

// 쿼리 실행
if (mysqli_query($con, $sql)) {
    echo "Record added successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

// 데이터베이스 접속 종료
mysqli_close($con);
?>
