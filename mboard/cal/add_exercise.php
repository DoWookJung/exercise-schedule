<?php
// 데이터베이스 연결
include "../../include/db_connect.php";

  $exercise_name = $_POST['exercise-name'];
  $exercise_sets = $_POST['exercise-sets'];
  $exercise_reps = $_POST['exercise-reps'];
  $exercise_weight = $_POST['exercise-weight'];

  // 데이터베이스에 새로운 운동일지 추가
  $sql = "INSERT INTO exercise_logs (exercise_name, sets, reps, weight) VALUES ('$exercise_name', '$exercise_sets', $exercise_reps, $exercise_weight)";
  mysqli_query($con, $sql);  // $sql에 저장된 명령 실행
  mysqli_close($con);       // DB 연결 끊기
  // 목록 페이지로 이동
	// echo "<script>
	//    location.href = 'index.php?type=list&table=$table';
	//    </script>";
?>
