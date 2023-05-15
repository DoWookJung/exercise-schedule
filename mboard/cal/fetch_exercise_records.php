<?php
include "../../include/db_connect.php";


// 연결 상태 확인
if ($con->connect_error) {
    die("연결 실패: " . $con->connect_error);
  }
  
  // GET 매개변수에서 요청된 날짜를 가져옴
$date = $_GET['date'];

// 요청된 날짜에 대한 운동 기록을 가져오기 위한 쿼리 작성 및 실행
$query = "SELECT exercise FROM workout_records WHERE workout_date = '$date'";
$result = $con->query($query);

// 운동 기록을 저장할 배열 생성
$exerciseRecords = array();

// 결과를 반복하며 배열에 저장
while ($row = $result->fetch_assoc()) {
    $exerciseRecords[] = array(
        'exercise' => $row['exercise'],
        // 데이터베이스 테이블의 다른 필드도 추가
    );
}

// 데이터베이스 연결 종료
$con->close();

// 운동 기록을 JSON 형식으로 반환
header('Content-Type: application/json');
echo json_encode($exerciseRecords);
?>
