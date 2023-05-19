<?php
    session_start();

    if (isset($_SESSION["userid"]))
        $userid = $_SESSION["userid"];
    else {
        $userid = "";
    }

    if (isset($_SESSION["username"]))
        $username = $_SESSION["username"];
    else
        $username = "";

	if (!$userid) {
		echo "
				<script>
				alert('로그인 후 이용해 주세요!');
				history.go(-1)
				</script>
		";
    exit;
  }
		include "../include/db_connect.php";
    $sql = "select * from workout_records";
    $result = mysqli_query($con,$sql);
    // 운동 기록 데이터를 저장할 연관 배열을 초기화합니다.
    $exerciseLogData = array();
    if ($result) {
      // 운동 기록 데이터를 반복하여 가져옵니다.
      while ($row = mysqli_fetch_assoc($result)) {
          $date = $row['date']; // 날짜 필드를 가져옵니다.
          $exerciseLogData[$date] = array(
              "exercise" => $row['exercise'],
              "sets" => $row['sets'],
          );
      }
        mysqli_close($con);
        // 데이터를 JavaScript로 전달하기 위해 JSON 형식으로 인코딩합니다.
        $exerciseLogJSON = json_encode($exerciseLogData);
    }
    else {
      // 쿼리 실행 오류 처리
      echo "운동 기록 데이터를 가져오는 동안 오류가 발생했습니다.";
      mysqli_close($con);
      exit();
    }
	
  ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>달력</title>
    <link rel="stylesheet" type="text/css" href="../mboard/style.css">
    <style>
         /* 앱바 스타일 */
      .appbar {
        background-color: #6cdaee; /*동호-상단 색상 변경*/
        height: 60px;
        display: flex;
        align-items: center;
        padding: 0 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .appbar-title {
        font-size: 24px;
        margin-right: 20px;
        
      }

      .appbar-menu {
        margin-left: auto;
      }

      .appbar-menu ul {
        list-style: $_COOKIE;
        padding: 0;
        margin: 0;
        display: flex;
      }
      .appbar-menu li {
        margin-left: 20px;
      }
      /* 캘린더 스타일 */
      #calendar-container {
        display: flex;
        flex-direction: row;
      }
      #calendar {
        flex: 5;
        padding: 20px;
      }
    </style>
  </head>
  <body>
    <!-- 앱바 추가 -->
    <div class="appbar">
      <h1 class="appbar-title">식단 캘린더</h1>
      <div class="appbar-menu">
        <ul>
          <li><a href="../main/index.php">메인</a></li>
          <li><a href="../mboard/cal/cal.php">운동일지</a></li>
          <li><a href="../member/logout.php">로그아웃</a></li>
        </ul>
      </div>
    </div>
    <div id="calendar-container">
      <div id="calendar">
      <div id="dateNav">
      <button id="prevMonth">&lt; </button> <!--이전달, 다음달 대신 <,>으로 변경-->
      <h1 id="dateDisplay"></h1>
      <button id="nextMonth">&gt; </button>
      </div>
      <table>
        <thead>
          <tr>
            <th>일</th>
            <th>월</th>
            <th>화</th>
            <th>수</th>
            <th>목</th>
            <th>금</th>
            <th>토</th>
          </tr>
        </thead>
        <tbody>
          <!-- 여기에 동적으로 날짜 데이터를 추가할 예정입니다. -->
        </tbody>
      </table>
    </div>
    <script>
      const calendarBody = document.querySelector('#calendar tbody');
      let currentYear;
      let currentMonth;

      function updateCalendar(year, month) {
        const today = new Date();
        currentYear = year; 
        currentMonth = month; 
        // 운동 기록 데이터를 JavaScript 변수에 할당합니다.
        const exerciseLogData = <?php echo json_encode($exerciseLogData); ?>;

        const firstDay = new Date(`${year}-${month}-01`);
        const lastDay = new Date(year, month, 0);

        const dateDisplay = document.querySelector('#dateDisplay');
        dateDisplay.textContent = `${year}년 ${month}월`;

        calendarBody.innerHTML = '';

        let date = 1;
        for (let i = 0; i < 6; i++) {
          const row = document.createElement('tr');
          for (let j = 0; j < 7; j++) {
            const cell = document.createElement('td');
            if (i === 0 && j < firstDay.getDay()) {
              // 이번 달 시작 이전의 빈 칸
            } else if (date > lastDay.getDate()) {
              // 이번 달 종료 이후의 빈 칸
            } else {
              const link = document.createElement('a');
              link.textContent = date;
              link.href = `./diet_main.php?date=${encodeURIComponent(year + '-' + ('0' + month).slice(-2) + '-' + ('0' + date).slice(-2))}`;

              // 링크 요소에 드래그 앤 드롭 이벤트 리스너 추가
              link.addEventListener('dragstart', handleDragStart);
              link.addEventListener('dragover', handleDragOver);
              link.addEventListener('drop', handleDrop);
              link.draggable = true;

              // 현재 날짜에 대한 운동 기록 데이터가 있는지 확인합니다.
              if (exerciseLogData[`${year}-${month}-${date}`]) {
               // 운동 기록 데이터의 복사본을 생성하여 데이터 속성으로 추가합니다.
                const logData = exerciseLogData[`${year}-${month}-${date}`];
                link.dataset.exerciseLog = JSON.stringify(logData);
              }

              cell.appendChild(link);
              if (year === currentYear && month === currentMonth && date === today.getDate()) {
                // 오늘 날짜 표시
                cell.classList.add('today');
              }
              date++;
            }
            row.appendChild(cell);
          }
          calendarBody.appendChild(row);
        }
      }
    // 이전 달로 이동
    document.querySelector('#prevMonth').addEventListener('click', () => {
      currentMonth--;
      if (currentMonth < 1) {
        currentYear--;
        currentMonth = 12;
      }
      updateCalendar(currentYear, currentMonth);
    });

    // 다음 달로 이동
    document.querySelector('#nextMonth').addEventListener('click', () => {
    currentMonth++;
    if (currentMonth > 12) {
      currentYear++;
      currentMonth = 1;
    }
    updateCalendar(currentYear, currentMonth);
  });
  // 드래그 앤 드롭 이벤트 핸들러
  function handleDragStart(event) {
    const date = new Date(currentYear, currentMonth - 1, parseInt(event.target.textContent) + 1);
    const formattedDate = date.toISOString().slice(0, 10);
    event.dataTransfer.setData('text/plain', formattedDate);
    event.dataTransfer.setData('application/json', event.target.dataset.exerciseLog);
  }

    function handleDragOver(event) {
      event.preventDefault();
    }
    function handleDrop(event) {
      event.preventDefault();
      const sourceDate = event.dataTransfer.getData('text/plain');
      
      // 대상 링크의 href 속성에서 전체 날짜를 가져옵니다.
      const targetLink = event.target;
      const targetDate = decodeURIComponent(targetLink.href.split('?date=')[1]);

      // sourceDate에서 targetDate로 운동 기록 복사
      copyExerciseRecords(sourceDate, targetDate);
    }
    function copyExerciseRecords(sourceDate, targetDate) {
      // 운동 기록 복사를 위한 PHP 스크립트로 AJAX 요청 보내기
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'copy_exercise_records.php');
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhr.onload = function() {
        if (xhr.status === 200) {
          // 응답 처리
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
            // 운동 기록 복사 성공 처리
            // 캘린더 표시 업데이트 또는 필요한 작업 수행
          } else {
            // 오류 처리
            console.error(response.message);
          }
        } else {
          // 오류 처리
          console.error('AJAX 요청 중 오류가 발생했습니다.');
        }
      };

      xhr.onerror = function() {
        // 오류 처리
        console.error('AJAX 요청 중 오류가 발생했습니다.');
      };

      xhr.send(`sourceDate=${encodeURIComponent(sourceDate)}&targetDate=${encodeURIComponent(targetDate)}`);
    }

      // 초기 달력 표시
      const today = new Date();
      currentYear = today.getFullYear();
      currentMonth = today.getMonth() + 1;
      updateCalendar(currentYear, currentMonth);
    </script>
  </body>
</html>
