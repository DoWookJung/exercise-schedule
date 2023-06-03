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
        alert('로그인 후 사용해주세요!');
        history.go(-1);
        </script>
        ";
        exit;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>캘린더</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <style>
        .exercise-info {
              font-size: 10px; /* 원하는 글자 크기로 설정 */
          }
        /* App bar style */
        .appbar {
            background-color: #6cdaee; /*상단 색상 변경 */
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
<!-- Add App Bar -->
<div class="appbar">
    <h1 class="appbar-title">운동 캘린더</h1>
    <div class="appbar-menu">
        <ul>
            <li><a href="../../main/index.php">메인</a></li>
            <li><a href="../../diet/diet_cal.php">식단 다이어리</a></li>
            <li><a href="../../member/logout.php">로그아웃</a></li>
        </ul>
    </div>
</div>
<div id="calendar-container">
    <div id="calendar">
        <div id="dateNav">
            <button id="prevMonth"><</button> <!-- 이전 달 대신 <,>로 변경 -->
            <h1 id="dateDisplay"></h1>
            <button id="nextMonth">></button>
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
            <!-- 날짜 데이터를 동적으로 추가할 예정입니다. -->
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        <?php
            $exerciseLogData = array();
            include "../../include/db_connect.php";
            // 데이터베이스에서 운동 기록 데이터 가져오기
            $query = "SELECT * FROM workout_records WHERE name = '$username'";
            $result = mysqli_query($con, $query);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $date = $row['date'];
                    $exercise = $row['exercise'];
                    $sets = $row['sets'];

                    // 이미 해당 날짜의 데이터가 있는지 확인
                    if (isset($exerciseLogData[$date])) {
                    // 이미 데이터가 있는 경우, 기존 데이터에 추가
                    $exerciseLogData[$date]['exercise'][] = $exercise;
                    $exerciseLogData[$date]['sets'][] = $sets;
                } else {
                    // 새로운 날짜의 데이터인 경우, 배열로 초기화
                    $exerciseLogData[$date] = array(
                        'exercise' => array($exercise),
                        'sets' => array($sets)
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
                        prevMonth = currentMonth === 1 ? 12 : currentMonth - 1;
                        const prevMonthLastDay = new Date(currentYear, prevMonth, 0).getDate();
                        const prevMonthDate = new Date(currentYear, prevMonth - 1, prevMonthLastDay - firstDay.getDay() + j + 1);
                        
                        cell.textContent = prevMonthDate.getDate();
                        cell.classList.add('other-month');

                        const link = document.createElement('a');
                        link.href = `./index.php?date=${encodeURIComponent(prevMonthDate.getFullYear() + '-' + ('0' + (prevMonthDate.getMonth() + 1)).slice(-2) + '-' + ('0' + prevMonthDate.getDate()).slice(-2))}`;

                        // 링크 요소에 드래그 앤 드롭 이벤트 리스너 추가
                        link.addEventListener('dragstart', handleDragStart);
                        link.addEventListener('dragover', handleDragOver);
                        link.addEventListener('drop', handleDrop);
                        link.draggable = true;

                        cell.appendChild(link);
                        
                    } else if (date > lastDay.getDate()) {
                        // 다음 달 남는 빈 칸
                        nextMonth = (currentMonth + 1) % 12; // nextMonth 변수가 항상 1에서 12 사이의 값을 유지
                        const nextMonthDate = new Date(currentYear, nextMonth - 1, date - lastDay.getDate());
                        const nextMonthDay = nextMonthDate.getDate();
                        cell.textContent = nextMonthDay;
                        cell.classList.add('other-month');

                        const link = document.createElement('a');
                        link.href = `./index.php?date=${encodeURIComponent(nextMonthDate.getFullYear() + '-' + ('0' + (nextMonthDate.getMonth() + 1)).slice(-2) + '-' + ('0' + nextMonthDate.getDate()).slice(-2))}`;

                        link.addEventListener('dragstart', handleDragStart);
                        link.addEventListener('dragover', handleDragOver);
                        link.addEventListener('drop', handleDrop);
                        link.draggable = true;

                        cell.appendChild(link);

                        date++;
                    } else {
                        const link = document.createElement('a');
                        link.textContent = date;
                        link.href = `./index.php?date=${encodeURIComponent(year + '-' + ('0' + month).slice(-2) + '-' + ('0' + date).slice(-2))}`;

                        // 링크 요소에 드래그 앤 드롭 이벤트 리스너를 추가합니다.
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
            // exerciseLogData를 순회하며 운동과 세트 데이터를 캘린더에 추가합니다.
            for (const [date, logData] of Object.entries(exerciseLogData)) {
                const [logYear, logMonth, logDate] = date.split('-');
                if (
                    (logYear == year && logMonth == month) ||
                    (logYear == prevMonthYear && logMonth == prevMonth) ||
                    (logYear == nextMonthYear && logMonth == nextMonth)
                ) {
                const link = document.querySelector(`a[href$="${logYear}-${logMonth}-${logDate}"]`);
                if (link) {
                    for (let i = 0; i < logData.exercise.length; i++) {
                    const exerciseInfo = document.createElement('div');
                    exerciseInfo.classList.add('exercise-info');
                    exerciseInfo.textContent = logData.exercise[i] + ' (' + logData.sets[i] + ')';
                    if ((logYear == prevMonthYear && logMonth == prevMonth) || (logYear == nextMonthYear && logMonth == nextMonth)) {
                        exerciseInfo.classList.add('other-month');
                    }
                    link.appendChild(exerciseInfo);
                    }
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

        // 드래그 앤 드롭 이벤트 핸들러
        function handleDragStart(event) {
            // href 속성에서 대상 날짜를 가져옵니다.
            const targetDate = new URL(event.target.href).searchParams.get('date');
            const [year, month, day] = targetDate.split('-');

            // 날짜 형식을 변경합니다.
            const formattedDate = `${year}-${month}-${day}`;

            event.dataTransfer.setData('text/plain', formattedDate);
            event.dataTransfer.setData('application/json', event.target.dataset.exerciseLog);
        }

        function handleDragOver(event) {
            event.preventDefault();
        }

        function handleDrop(event) {
            event.preventDefault();
            const sourceDate = event.dataTransfer.getData('text/plain');
            
            // 대상 링크의 href 속성에서 전체 날짜 가져오기
            const targetLink = event.currentTarget;
            const targetDate = decodeURIComponent(targetLink.href.split('?date=')[1]);

            var data = {
                sourceDate: sourceDate,
                targetDate: targetDate
            };
            
            // AJAX 요청 보내기
            $.ajax({
                url: 'copy_exercise_records.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                cache: false,
                success: function(response) {
                if (response.success) {
                    // 복사 성공 시, 캘린더 업데이트
                    updateCalendar(currentYear, currentMonth); // 캘린더 업데이트 함수 호출
                    
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
        
        // 초기 달력 표시
        const today = new Date();
        currentYear = today.getFullYear();
        currentMonth = today.getMonth() + 1;
        updateCalendar(currentYear, currentMonth);
    </script>
</body>
</html>