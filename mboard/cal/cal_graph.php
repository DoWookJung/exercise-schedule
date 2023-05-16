<?php
session_start();
if (isset($_SESSION["username"]))
    $username = $_SESSION["username"];
else
    $username = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>볼륨</title>
    
    <!-- 다운로드 받은 echarts.js 파일 로드-->
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>
    <?php
    $exercise = $_GET["exercise"];
    $exercise = urldecode($exercise); // 인코딩된 문자열을 디코딩하여 공백으로 변환
    $exerciseData = array(); // 운동 데이터 배열 초기화
    echo "<h1>$exercise</h1>";
    include "../../include/db_connect.php";
    $sql = "SELECT `date`, `exercise`, `reps`, `sets`, `weight` FROM `workout_records` WHERE `exercise`='$exercise' && name='$username'";
    $result = mysqli_query($con, $sql);     // SQL 명령 실행

    while ($row = mysqli_fetch_assoc($result)) {
        $date = $row['date'];
        $exercise = $row['exercise'];
        $reps = $row['reps'];
        $sets = $row['sets'];
        $weight = $row['weight'];

        $volume = $weight * $reps * $sets; // 운동 데이터의 볼륨 계산
        
        // 날짜별로 볼륨을 합산하여 기존 데이터에 추가
        if (isset($exerciseData[$date])) {
            $exerciseData[$date] += $volume;
        } else {
            $exerciseData[$date] = $volume;
        }
    }

    mysqli_close($con);           // DB 접속 해제
    ?>
    <script type="text/javascript">
        let xAxisData = []; // x축 데이터 배열 초기화
        let seriesData = []; // 값 데이터 배열 초기화

        window.onload = function () { // 페이지 로드 시 실행
            document.getElementById("drawLine").addEventListener('click', drawChart); // Line Chart 버튼 클릭 시 이벤트 정의 : drawChart 매서드 실행
            document.getElementById("drawBar").addEventListener('click', drawChart); // Bar Chart 버튼 클릭 시 이벤트 정의 : drawChart 매서드 실행

            prepareChartData(); // 차트 데이터 준비
            drawChart(); // 차트 그리기
        }

        function prepareChartData() {
            <?php
             ksort($exerciseData);

            foreach ($exerciseData as $date => $volume) {
                echo "xAxisData.push('$date');"; // 날짜 데이터를 xAxisData 배열에 추가
                echo "seriesData.push({name: '$date', value: $volume});"; // 운동 볼륨 데이터를 seriesData 배열에 추가
            }
            ?>
        }


        function drawChart () { 

            var myChart = echarts.init(document.getElementById('chart')); // echarts init 메소드로 id=chart인 DIV에 차트 초기화

            option = { // 차트를 그리는데 활용 할 다양한 옵션 정의
                        xAxis: {
                            type: 'category',
                            data: xAxisData // 위에서 정의한 X축 데이터
                        },
                        yAxis: {
                            type: 'value'
                        },
                        series: [
                            {
                            data: seriesData, // 위에서 정의한 값 데이터
                            type: this.value // 버튼의 value 데이터 ('line' or 'bar')
                            }
                        ]
                            };

            myChart.setOption(option); // 차트 디스플레이
            }
        </script>
    </head>
    <body>
    <button id="drawLine" value="line">Line Chart</button>
    <button id="drawBar" value="bar">Bar Chart</button>

    <!-- 차트를 그려줄 영역 -->
    <div id="chart" style="width: 100%; height:500px;"> 
    </body>
</html>
