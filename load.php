<?php
// 데이터베이스 접속 정보 설정
include "./include/db_connect.php";

// GET 데이터 가져오기
$date = $_GET["date"];

// SQL 쿼리 작성
$sql = "SELECT * FROM workout_records WHERE date = '$date'";

// 쿼리 실행
$result = mysqli_query($con, $sql);

// 결과 출력
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["weight"] . "</td>";
        echo "<td>" . $row["exercise"] . "</td>";
        echo "<td>" . $row["reps"] . "</td>";
        echo "<td>" . $row["sets"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}

// 데이터베이스 접속 종료
mysqli_close($con);
?>
