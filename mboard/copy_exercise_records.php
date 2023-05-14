<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// header('Content-Type: application/json');
include "../include/db_connect.php";

// AJAX 요청으로부터 소스 날짜와 대상 날짜를 가져옵니다.
$sourceDate = $_POST['sourceDate'];
$targetDate = $_POST['targetDate'];


// 데이터베이스 연결을 확인합니다.
if ($con->connect_error) {
    // 연결 실패 시
    $response = [
        'success' => false,
        'message' => '데이터베이스 연결에 실패했습니다.'
    ];
    echo json_encode($response);
    exit;
}

// 소스 날짜로부터 운동 기록을 조회합니다.
$sql = "SELECT * FROM workout_records WHERE date = '$sourceDate'";
$result = mysqli_query($con, $sql); // SQL 명령어 실행

if ($result->num_rows > 0) {
    // 소스 날짜에 운동 기록이 있는 경우
    while ($row = $result->fetch_assoc()) {
        $date = $targetDate;
        $weight = $row['weight'];
        $exercise = $row['exercise'];
        $reps = $row['reps'];
        $sets = $row['sets'];
        $name = $row['name'];

        // 대상 날짜에 운동 기록을 삽입합니다.
        $sql = "INSERT INTO workout_records (date, weight, exercise, reps, sets, name)
                VALUES ('$date', '$weight', '$exercise', '$reps', '$sets', '$name')";

        if ($con->query($sql) !== true) {
            // 운동 기록 복사 실패
            $response = [
                'success' => false,
                'message' => '운동 기록 복사에 실패했습니다.'
            ];
            echo json_encode($response);
            exit;
        }
    }

    // 운동 기록이 성공적으로 복사되었습니다.
    $response = [
        'success' => true,
        'message' => '운동 기록이 성공적으로 복사되었습니다.'
    ];
    echo json_encode($response);
} else {
    // 소스 날짜에 운동 기록이 없는 경우
    $response = [
        'success' => false,
        'message' => '해당 소스 날짜에 운동 기록이 없습니다.'
    ];
    echo json_encode($response);
}

// 데이터베이스 연결을 닫습니다.
$con->close();
?>
