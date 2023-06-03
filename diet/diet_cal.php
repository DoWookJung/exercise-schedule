<?php
    session_start();
    if (!empty($_SESSION["userid"])) {
      $userid = $_SESSION["userid"];
  } else {
      $userid = "";
  }
  
  if (!empty($_SESSION["username"])) {
      $username = $_SESSION["username"];
  } else {
      $username = "";
  }
	if (!$userid) {
		echo "
				<script>
				alert('로그인 후 이용해 주세요!');
				history.go(-1)
				</script>
		";
    exit;
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
        background-color: #6cdaee; /*상단 색상 변경*/
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
      .other-month {
            color: lightgray;
      }
      thead th:nth-child(1) {
        color: red;
      }

      thead th:nth-child(7) {
        color: blue;
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
            <th><strong>일</strong></th>
            <th><strong>월</strong></th>
            <th><strong>화</strong></th>
            <th><strong>수</strong></th>
            <th><strong>목</strong></th>
            <th><strong>금</strong></th>
            <th><strong>토</strong></th>
          </tr>
        </thead>
        <tbody>
          <!-- 여기에 동적으로 날짜 데이터를 추가할 예정입니다. -->
        </tbody>
      </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      <?php
            $dietLogData = array();
            include "../include/db_connect.php";
            // 데이터베이스에서 운동 기록 데이터 가져오기
            $query = "SELECT * FROM diet_log WHERE name = '$username'";
            $result = mysqli_query($con, $query);
            
            if ($result) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $date = $row['date'];
                    $calories = $row['calories'];
                
                    // 이미 해당 날짜의 데이터가 있는지 확인
                    if (isset($dietLogData[$date])) {
                        // 이미 데이터가 있는 경우, 기존 데이터에 추가
                        $dietLogData[$date]['calories'] += $calories;
                    } else {
                        // 새로운 날짜의 데이터인 경우, 배열로 초기화
                        $dietLogData[$date] = array(
                            'calories' => $calories
                        );
                    }
                }
                
              } else {
                echo "운동 기록 데이터를 가져오는 중 오류가 발생했습니다: " . mysqli_error($con);
            }
            
            mysqli_close($con);
      ?>
      const calendarBody = document.querySelector('#calendar tbody');
      let currentYear;
      let currentMonth;
      
      function updateCalendar(year, month) {
        const currentDate  = new Date();
        currentYear = year;
        currentMonth = month;

        // 이전 달 계산
        let prevMonthYear = currentYear;
        let prevMonth = currentMonth - 1;
        if (prevMonth < 1) {
        prevMonth = 12;
        prevMonthYear--;
        }
        
        // 다음 달 계산
        let nextMonthYear = currentYear;
        let nextMonth = currentMonth + 1;
        if (nextMonth > 12) {
            nextMonth = 1;
            nextMonthYear++;
        }
        // 식단 기록 데이터를 JavaScript 변수에 할당합니다.
        const dietLogData = <?php echo json_encode($dietLogData); ?>;
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
                const prevMonth = currentMonth === 1 ? 12 : currentMonth - 1;
                const prevMonthLastDay = new Date(currentYear, prevMonth, 0).getDate();
                const prevMonthDate = new Date(currentYear, prevMonth - 1, prevMonthLastDay - firstDay.getDay() + j + 1);
                cell.textContent = prevMonthDate.getDate();
                cell.classList.add('other-month');

                const link = document.createElement('a');
                link.href = `./diet_main.php?date=${encodeURIComponent(prevMonthDate.getFullYear() + '-' + ('0' + (prevMonthDate.getMonth() + 1)).slice(-2) + '-' + ('0' + prevMonthDate.getDate()).slice(-2))}`;

                // 링크 요소에 드래그 앤 드롭 이벤트 리스너 추가
                link.addEventListener('dragstart', handleDragStart);
                link.addEventListener('dragover', handleDragOver);
                link.addEventListener('drop', handleDrop);
                link.draggable = true;

                cell.appendChild(link);
            } else if (date > lastDay.getDate()) {
              // 다음 달 남는 빈 칸
              const nextMonth = (currentMonth + 1) % 12; //  nextMonth 변수가 항상 1에서 12 사이의 값을 유지
              const nextMonthDate = new Date(currentYear, nextMonth - 1, date - lastDay.getDate());
              const nextMonthDay = nextMonthDate.getDate();
              cell.textContent = nextMonthDay;
              cell.classList.add('other-month');

              const link = document.createElement('a');
              link.href = `./diet_main.php?date=${encodeURIComponent(nextMonthDate.getFullYear() + '-' + ('0' + (nextMonthDate.getMonth() + 1)).slice(-2) + '-' + ('0' + nextMonthDate.getDate()).slice(-2))}`;

              link.addEventListener('dragstart', handleDragStart);
              link.addEventListener('dragover', handleDragOver);
              link.addEventListener('drop', handleDrop);
              link.draggable = true;

              cell.appendChild(link);
              date++;
            } else {
              // 이번 달의 날짜
              const link = document.createElement('a');
              link.textContent = date;
              link.href = `./diet_main.php?date=${encodeURIComponent(year + '-' + ('0' + month).slice(-2) + '-' + ('0' + date).slice(-2))}`;

              // 링크 요소에 드래그 앤 드롭 이벤트 리스너 추가
              link.addEventListener('dragstart', handleDragStart);
              link.addEventListener('dragover', handleDragOver);
              link.addEventListener('drop', handleDrop);
              link.draggable = true;
              cell.appendChild(link);

              // 이번 달에만 오늘 날짜 표시
              if (
                year === currentYear &&
                month === currentMonth &&
                date === today.getDate() &&
                currentMonth === new Date().getMonth() + 1
              ) {
                cell.classList.add('today');
              }
              date++;
            }
            row.appendChild(cell);
          }
          calendarBody.appendChild(row);
          
        }
        // dietLogData를 순회하며 식단 데이터를 캘린더에 추가합니다.
        for (const [date, logData] of Object.entries(dietLogData)) {
            const [logYear, logMonth, logDate] = date.split('-');
            if ((logYear == year && logMonth == month) ||
                    (logYear == prevMonthYear && logMonth == prevMonth) ||
                    (logYear == nextMonthYear && logMonth == nextMonth)
                ) {
                const link = document.querySelector(`a[href$="${logYear}-${logMonth}-${logDate}"]`);
                if (link) {
                    const dietInfo = document.createElement('div');
                    dietInfo.classList.add('diet-info');
                    dietInfo.textContent = logData.calories + 'kcal';
                    if ((logYear == prevMonthYear && logMonth == prevMonth) || (logYear == nextMonthYear && logMonth == nextMonth)) {
                        dietInfo.classList.add('other-month');
                    }
                    link.appendChild(dietInfo);
                }
              }
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

  function addEventListenersToLinks() {
  const links = document.querySelectorAll('#calendar a');

  links.forEach(link => {
    link.addEventListener('dragstart', handleDragStart);
    link.addEventListener('dragover', handleDragOver);
    link.addEventListener('drop', handleDrop);
    link.draggable = true;
  });
}
  // 드래그 앤 드롭 이벤트 핸들러
  function handleDragStart(event) {
  const targetDate = decodeURIComponent(event.target.href.split('?date=')[1]);
  const [year, month, day] = targetDate.split('-');

  const formattedDate = `${year}-${month}-${day}`;

  event.dataTransfer.setData('text/plain', formattedDate);
  event.dataTransfer.setData('application/json', event.target.dataset.dietLog);
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
      console.log(sourceDate);  //확인
      // sourceDate에서 targetDate로 식단 기록 복사
      var data = {
                sourceDate: sourceDate,
                targetDate: targetDate
            };
            
            // AJAX 요청 보내기
            $.ajax({
                url: 'copy_diet_records.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                cache: false,
                success: function(response) {
                if (response.success) {
                    // 복사 성공 시, 캘린더 업데이트
                    // updateCalendar(currentYear, currentMonth); // 캘린더 업데이트 함수 호출
                    location.reload();
                } else {
                    // 복사 실패 시, 에러 처리
                    console.log(response.message);
                }
                },
                error: function(xhr, status, error) {
                // 에러 처리
                console.log(error);
                }
            });
        }
        function update(year, month) {
    var data = {
        year: year,
        month: month
    };
    
    // AJAX 요청 보내기
    $.ajax({
        url: 'get_calendar_data.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        cache: false,
        success: function(response) {
            if (response.success) {
                // 서버에서 가져온 데이터로 캘린더 업데이트
                renderCalendar(response.data);
            } else {
                // 오류 처리
                console.log(response.message);
            }
        },
        error: function(xhr, status, error) {
            // 오류 처리
            console.log(error);
        }
    });
}

      // 초기 달력 표시
      const today = new Date();
      currentYear = today.getFullYear();
      currentMonth = today.getMonth() + 1;
      updateCalendar(currentYear, currentMonth);
    </script>
  </body>
</html>
