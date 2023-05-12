<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>달력</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
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
          <?php
          // Sample exercise data for demonstration
          $exerciseData = [
              '2023-05-10' => '런닝',
              '2023-05-12' => '요가',
              '2023-05-15' => '웨이트리프팅',
          ];

          function displayExercise($date) {
              global $exerciseData;

              if (isset($exerciseData[$date])) {
                  echo '<div class="exercise">' . htmlspecialchars($exerciseData[$date]) . '</div>';
              }
          }

          // Get the current year and month
          $currentYear = date('Y');
          $currentMonth = date('m');

          // Get the number of days in the current month
          $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

          // Display the calendar
          $date = new DateTime($currentYear . '-' . $currentMonth . '-01');

          // Adjust the starting day of the week if needed (e.g., Monday as the first day)
          $startDayOfWeek = $date->format('N');
          if ($startDayOfWeek > 1) {
              echo '<tr>';
              for ($i = 1; $i < $startDayOfWeek; $i++) {
                  echo '<td></td>';
              }
          }

          // Iterate through the days of the month
          for ($day = 1; $day <= $daysInMonth; $day++) {
              // Format the date in 'Y-m-d' format
              $formattedDate = $date->format('Y-m-d');

              echo '<td>';
              echo '<div class="day">' . $day . '</div>';
              displayExercise($formattedDate); // Display exercise data for the current date
              echo '</td>';

              // Move to the next day
              $date->modify('+1 day');

              // Start a new row if it's the end of the week
              if ($date->format('N') == 1) {
                  echo '</tr>';
              }
          }

          // Complete the last row if it's not already closed
          if ($date->format('N') != 1) {
              echo '</tr>';
          }
          ?>
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
                const dateDiv = document.createElement('div');
                dateDiv.textContent = date;
                cell.appendChild(dateDiv);

                const exerciseDiv = document.createElement('div');
                const formattedDate = `${year}-${('0' + month).slice(-2)}-${('0' + date).slice(-2)}`;
                displayExercise(formattedDate);
                exerciseDiv.innerHTML = document.querySelector('.exercise') ? document.querySelector('.exercise').innerHTML : '';
                cell.appendChild(exerciseDiv);

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
