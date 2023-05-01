<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>운동일지</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>운동일지</h1>
    <form action="save.php" method="post">
      <div class="form-group">
        <label for="date">날짜</label>
        <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
      </div>
      <div class="form-group">
        <label for="weight">중량</label>
        <input type="number" id="weight" name="weight" min="0" step="0.1" required>
        <span class="unit">kg</span>
      </div>
      <div class="form-group">
        <label for="exercise">운동 종목</label>
        <input type="text" id="exercise" name="exercise" required>
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
        <button type="submit">저장</button>
      </div>
    </form>
    <hr>
    <h2>지난 운동 기록 보기</h2>
    <div class="calendar-container">
      <div class="calendar-header">
        <button id="prev-month">&lt;</button>
        <h3 id="calendar-title"></h3>
        <button id="next-month">&gt;</button>
      </div>
      <table id="calendar">
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
        <tbody></tbody>
      </table>
    </div>
    <div id="log-list">
      <ul></ul>
    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>
