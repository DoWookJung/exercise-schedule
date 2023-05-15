<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- 다운로드 받은 echarts.js 파일 로드-->
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>  
    <script type="text/javascript">

        let xAxisData = ['철수','영희','민수','지수']; // x축 데이터 배열 생성
        let seriesData = [70,80,100,30]; // 값 데이터 배열 생성

        window.onload = function() { // 페이지 로드 시 실행

            document.getElementById("drawLine").addEventListener('click', drawChart); // Line Chart 버튼 클릭 시 이벤트 정의 : drawChart 매서드 실행
            document.getElementById("drawBar").addEventListener('click', drawChart); // Bar Chart 버튼 클릭 시 이벤트 정의 : drawChart 매서드 실행

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