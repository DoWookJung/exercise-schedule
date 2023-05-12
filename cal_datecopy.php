<!DOCTYPE html>
<html>
<head>
    <title>Date Selection</title>
    <style>
        .calendar {
            width: 300px;
            height: 300px;
            border: 1px solid #ccc;
            text-align: center;
        }
        .calendar table {
            width: 100%;
            height: 100%;
        }
        .calendar td {
            padding: 10px;
        }
        .calendar td:hover {
            background-color: #e0e0e0;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="calendar">
        <table>
            <caption>Select a Date</caption>
            <tr>
                <th colspan="7">
                    <button onclick="closeCalendar()">Close</button>
                </th>
            </tr>
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>
            <?php
                // 오늘 날짜 계산
                $today = date("Y-m-d");
                // 선택된 날짜 초기화
                $selectedDate = "";

                // 이전 달과 다음 달 링크를 통해 이동할 경우 전달된 날짜 값이 있는지 확인
                if (isset($_GET['date'])) {
                    $selectedDate = $_GET['date'];
                }

                // 선택한 날짜를 표시하기 위해 연, 월, 일을 분리
                $year = date("Y");
                $month = date("m");
                $day = date("d");

                // 선택된 날짜가 있을 경우 연, 월, 일로 분리
                if (!empty($selectedDate)) {
                    $year = date("Y", strtotime($selectedDate));
                    $month = date("m", strtotime($selectedDate));
                    $day = date("d", strtotime($selectedDate));
                }

                // 이전 달과 다음 달 링크를 통해 이동할 경우 연, 월을 분리
                if (isset($_GET['year']) && isset($_GET['month'])) {
                    $year = $_GET['year'];
                    $month = $_GET['month'];
                }

                // 이전 달과 다음 달 링크에서 사용할 연, 월 계산
                $prevMonth = date("m", strtotime("-1 month", mktime(0, 0, 0, $month, 1, $year)));
                $prevYear = date("Y", strtotime("-1 month", mktime(0, 0, 0, $month, 1, $year)));
                $nextMonth = date("m", strtotime("+1 month", mktime(0, 0, 0, $month, 1, $year)));
                $nextYear = date("Y", strtotime("+1 month", mktime(0, 0, 0, $month, 1, $year)));

                // 선택한 날짜로 달력 표시
                for ($i = 1; $i <= 31; $i++) {
                    // 현재 연도와 월에 해당하는 날짜인지 확인
                    if (checkdate($month, $i, $year)) {
                        $currentDate = sprintf("%04d-%02d-%02d", $year, $month, $i);
                        
                        // 선택한 날짜인 경우 스타일 적용
                        $selected = "";
                        if ($currentDate === $selectedDate) {
                            $selected = "style='background-color: #e0e0e0;'";
                        }

                        // 선택한 날짜를 부모 창으로 전달하는 JavaScript 코드 추가
                        echo "<td $selected onclick='selectDate(\"$currentDate\")'>$i</td>";
                    } else {
                        // 해당 날짜가 없는 경우 빈 셀 표시
                        echo "<td></td>";
                    }

                    // 한 주가 끝나면 다음 줄로 넘어감
                    if ($i % 7 === 0) {
                        echo "</tr><tr>";
                    }
                }
                ?>

                <script>
                    // 선택한 날짜를 부모 창으로 전달하는 함수
                    function selectDate(date) {
                        window.opener.postMessage(date, "*");
                        window.close();
                    }

                    // 부모 창에서 달력을 닫는 함수
                    function closeCalendar() {
                        window.close();
                    }
                </script>
        </table>
    </div>
</body>
</html>

