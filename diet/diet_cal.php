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
        background-color: #f9f9f9;
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
        list-style: none;
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
        flex: 1;
        padding: 20px;
      }
    </style>
  </head>
  <body>
    <!-- 앱바 추가 -->
    <div class="appbar">
      <h1 class="appbar-title">캘린더</h1>
      <div class="appbar-menu">
        <ul>
          <li><a href="../main/index.php">메인</a></li>
          <li><a href="../mboard/cal.php">운동일지</a></li>
          <li><a href="../member/logout.php">로그아웃</a></li>
        </ul>
      </div>
    </div>
    <div id="calendar-container">
      <div id="calendar">
      <h1 id="dateDisplay"></h1>
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
        currentYear = today.getFullYear();
        currentMonth = today.getMonth() + 1;

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
              link.href = `../index.php?date=${encodeURIComponent(year + '-' + ('0' + month).slice(-2) + '-' + ('0' + date).slice(-2))}`;
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

      // 초기 달력 표시
      const today = new Date();
      currentYear = today.getFullYear();
      currentMonth = today.getMonth() + 1;
      updateCalendar(currentYear, currentMonth);
    </script>
  </body>
</html>
