<!-- <?php
include "../../include/db_connect.php";


if (isset($_GET['date'])) {
    // 쿼리 문자열에서 날짜 매개변수를 가져옵니다.
    $date = $_GET['date'];
  
    // SQL 인젝션을 방지하기 위해 날짜 매개변수를 이스케이프합니다.
    $escapedDate = mysqli_real_escape_string($con, $date);
  
    // 지정된 날짜에 대한 운동 데이터를 가져오기 위한 SQL 쿼리를 준비합니다.
    $sql = "SELECT * FROM workout_records WHERE date = '$escapedDate'";
    $result = mysqli_query($con, $sql);
  
    // 쿼리 실행 여부를 확인합니다.
    if ($result) {
      // 운동 데이터를 저장할 배열을 생성합니다.
      $workoutData = array();
  
      // 쿼리 결과를 반복하며 운동 데이터를 가져옵니다.
      while ($row = mysqli_fetch_assoc($result)) {
        $exercise = $row['exercise'];
        $sets = $row['sets'];
  
        // 운동 데이터를 배열에 추가합니다.
        $workoutData[] = array(
          'exercise' => $exercise,
          'sets' => $sets
        );
      }
  
      // 운동 데이터를 JSON 형식으로 반환합니다.
      echo json_encode($workoutData);
    } else {
      // 쿼리 오류 처리
      echo '운동 데이터를 가져오는 동안 오류가 발생했습니다.';
    }
  
    // 데이터베이스 연결을 닫습니다.
    mysqli_close($con);
  } else {
    // 날짜 매개변수가 없는 경우 처리
    echo '잘못된 요청입니다. 날짜 매개변수가 없습니다.';
  }
  ?> -->