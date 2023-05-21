<?php
session_start();
include "../include/db_connect.php";

if (isset($_SESSION["username"])) 
    $username = $_SESSION["username"];
else 
    $username = "";  

$date = $_POST['date'];
$meal = $_POST['meal'];
$food_name = $_POST['food_name'];
$amount = $_POST['size'];
$calories = $_POST['calorie'];

// 테이블 구조에 맞게 쿼리를 사용자 정의합니다.
// SQL 쿼리 작성
$sql = "INSERT INTO diet_log (name, date, meal, food_name, amount, calories) 
        VALUES ('$username', '$date', '$meal', '$food_name', '$amount', '$calories')";

// 쿼리 실행
if (mysqli_query($con, $sql)) {
    // echo "Record added successfully";
    echo "<script>
	    location.href = 'diet_plus_index.php?date=$date&meal=$meal';
	   </script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

mysqli_close($con);

?>