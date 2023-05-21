<?php
session_start();
include "../include/db_connect.php";

if (isset($_SESSION["username"])) 
    $username = $_SESSION["username"];
else 
    $username = "";  

$date = isset($_POST['date']) ? $_POST['date'] : null; // 해당하는 양식 입력 필드 이름에 따라 수정하십시오.

// 테이블 구조에 맞게 쿼리를 사용자 정의합니다.
$sql = "SELECT * FROM diet_log WHERE name = '$username'";
if ($date) {
    $sql .= " AND date = '$date'";
}
$sql .= " ORDER BY CASE meal 
            WHEN '아침' THEN 1 
            WHEN '점심' THEN 2 
            WHEN '저녁' THEN 3 
            WHEN '간식' THEN 4 
            END"; 


$result = mysqli_query($con, $sql);


if ($result->num_rows > 0) {
    echo "<form action='diet_modify.php' method='post'>";
    echo "<table>";
    echo "<input type='hidden' name='date' value='" . $date . "'>"; // date 값을 추가
    echo "<tr><th>식사</th><th>음식 이름</th><th>용량</th><th>칼로리</th></th>";
    $totalCalories = 0;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<input type='text' name='date' value='" . $date . "'>"; // date 값을 추가
        echo "<input type='hidden' name='id[]' value='" . $row['id'] . "'>"; // id 값을 추가
        echo "<td><input type='text' name='meal[]' value='" . htmlspecialchars($row['meal']) . "'></td>";
        echo "<td><input type='text' name='food_name[]' value='" . $row['food_name'] . "'></td>";
        echo "<td><input type='text' name='amount[]' value='" . $row['amount'] . "'></td>";
        echo "<td><input type='text' name='calories[]' value='" . $row['calories'] . "'></td>";
        echo "<td><input type='submit' class=\"my-button\" name='modify' value='수정'></td>";
        echo "<td><button type='button' class=\"my-button\" onclick=\"location.href='diet_delete.php?id=" . $row['id'] . "&date=".$date. "'\">삭제</button></td>";
        // echo "<td><button type='button' class=\"my-button\" onclick=\"location.href='cal_graph.php?exercise=" . urlencode(urldecode($row['exercise'])) . "&date=" . urlencode(urldecode($date)) . "'\">볼륨</button></td>";
        $totalCalories += $row['calories']; 
        echo "</tr>";
    }
    echo "<tr><th colspan='3' style='text-align: right;'>총 칼로리:</th><th>$totalCalories</th></tr>";
    echo "</table>";
    echo "</form>";
} else {
    echo "<p>저장된 항목이 없습니다.</p>";
}

mysqli_close($con);
?>