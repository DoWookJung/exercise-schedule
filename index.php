<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>운동일지</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" type="text/css" href="./mboard/style.css">
  <style>
  input[type='text'] {
    text-align: center;
  }
</style>
</head>
<body>
  <div class="container">
    <h1>
    <a href="./mboard/cal.php">운동 일지</a>
    </h1>
    <form action="save.php" method="post">
      <div class="form-group">
      <?php 
      if(isset($_GET['date'])) {
        $date = $_GET['date'];
      } else {
        $date = null; // date가 없으면 null로 초기화
      }
      ?> 
        <label for="date">날짜</label>
        <input type="date" id="date" name="date" value="<?php echo $date; ?>">
      </div>
      <div class="form-group">
        <label for="exercise_name">운동 종목</label>
        <input type="search" name="exercise_name" id="exercise_name" list="exercise_list"><br><br>
		<datalist id="exercise_list">
    <option value="-------하체--------">
			<option value="스쿼트">
      <option value="브이 스쿼트">
      <option value="리버스 브이 스쿼트">
      <option value="스미스머신 스쿼트">  
			<option value="데드리프트">
			<option value="레그 프레스">
			<option value="레그 컬">
      <option value="레그 익스텐션">
      <option value="덤벨 런지">
      <option value="힙 쓰러스트">
      <option value="-------가슴--------">
      <option value="벤치프레스">
      <option value="인클라인 벤치프레스">
      <option value="덤벨 벤치프레스">
      <option value="인클라인 덤벨프레스">
      <option value="스미스머신 벤치프레스">
      <option value="스미스머신 인클라인 벤치프레스">
      <option value="딥스">
      <option value="어시스트 딥스 머신">
      <option value="덤벨 플라이">
      <option value="케이블 크로스오버">
      <option value="체스트 프레스 머신">
      <option value="펙덱 플라이 머신">
      <option value="푸쉬업">
      <option value="-------등--------">
      <option value="풀업">
      <option value="어시스트 풀업 머신">
      <option value="바벨 로우">
      <option value="덤벨 로우">
      <option value="시티드 로우 머신">
      <option value="랫풀다운">
      <option value="루마니안 데드리프트">
      <option value="원암 덤벨 로우">
      <option value="인클라인 덤벨 로우">
      <option value="티바 로우">
      <option value="케이블 암 풀다운">
      <option value="-------어깨--------">
      <option value="오버헤드 프레스">
      <option value="덤벨 숄더 프레스">
      <option value="레터럴 레이즈">
      <option value="프론트 레이즈">
      <option value="슈러그">
      <option value="페이스 풀">
      <option value="케이블 리버스 플라이">
      <option value="업라이트 로우">
      <option value="벤트오버 덤벨 레터럴 레이즈">
      <option value="숄더 프레스 머신">
      <option value="스미스머신 오버헤드 프레스">
      <option value="-------팔--------">
      <option value="바벨 컬">
      <option value="덤벨 컬">
      <option value="덤벨 삼두 익스텐션">
      <option value="덤벨 킥백">
      <option value="덤벨 해머 컬">
      <option value="케이블 푸시 다운">
      <option value="바벨 삼두 익스텐션">
      <option value="프리쳐 컬">
      <option value="암 컬 머신">
      <option value="-------복근--------">
      <option value="싯업">
      <option value="레그 레이즈">
      <option value="플랭크">
      <option value="크런치">
      <option value="케이블 크런치">
      <option value="행잉 레그 레이즈">
		</datalist> 
      </div>
      <div class="form-group">
        <label for="weight">중량</label>
        <input type="search" id="weight" name="weight" min="0" step="0.1" required>
        <span class="unit">kg</span>
      </div>

      <div class="form-group">
        <label for="reps">횟수</label>
        <input type="number" id="reps" name="reps" min="0" required>
        <span class="unit">회</span>
      </div>
      <div class="form-group">
        <label for="sets">세트수</label>
        <input type="number" id="sets" name="sets" min="0" required>
        <span class="unit">세트</span>
      </div>
      <div class="form-group">
        <button type="submit" class="my-button">저장</button>
      </div>
    </form>
    <hr>
    <h2>저장한 운동 기록</h2>
    
    <?php
	  include "./include/db_connect.php";
    $sql = "select * from workout_records where date='$date'";	  
	  $result = mysqli_query($con, $sql);			// SQL 명령 실행
    // 데이터 가져오기 버튼을 눌렀을 때의 로직
    if (isset($_POST['get_data'])) {
    // 선택한 날짜를 가져옴
    $selectedDate = $_POST['selected_date'];

    // 선택한 날짜를 이용하여 데이터를 가져오는 SQL 쿼리 작성
    $sql = "SELECT * FROM workout_records WHERE date = '$selectedDate'";
    $result = mysqli_query($con, $sql);}
    $id = null;
    // check if any exercises were found
    if (mysqli_num_rows($result) > 0) {
      echo "<form action='cal_modify.php' method='post'>";
      echo "<input type='hidden' name='date' value='" . $date . "'>"; // date 값을 추가
      echo "<table>";
      echo "<tr><th>운동 종목</th><th>무게 (kg)</th><th>횟수</th><th>세트 수</th></th>";
      while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<input type='hidden' name='id[]' value='" . $row['id'] . "'>"; // id 값을 추가
        echo "<td><input type='text' name='exercise[]' value='" . $row['exercise'] . "'></td>";
        echo "<td><input type='text' name='weight[]' value='" . $row['weight'] . "'></td>";
        echo "<td><input type='text' name='reps[]' value='" . $row['reps'] . "'></td>";
        echo "<td><input type='text' name='sets[]' value='" . $row['sets'] . "'></td>";
        echo "<td><input type='submit' class=\"my-button\" name='modify' value='수정'></td>";
        echo "<td><button type='button' class=\"my-button\" onclick=\"location.href='cal_delete.php?id=" . $row['id'] . "&date=".$date. "'\">삭제</button></td>";
        $id = $row['id'];
        echo "</tr>";
      }
      echo "</table>";
      echo "</form>";
      
      echo "</table>";
      echo "</form>";
    } else {
      echo "<p>아직 추가한 운동이 없습니다.</p>";
    }
    
    echo "<button type='button' class=\"my-button\" onclick=\"location.href='cal_datecopy.php'\">데이터 가져오기</button>";
    // echo "<button type='button' class=\"my-button\" onclick=\"openCalendar()\">데이터 가져오기</button>";
    mysqli_close($con);?>
</body>
</html>

