<?php 
      if(isset($_GET['date'])) {
        $date = $_GET['date'];
      } else {
        $date = null; // date가 없으면 null로 초기화
      }
      ?> 

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>식단일지</title>
  <link rel="stylesheet" href="../mboard/style.css">
</head>
<body>
    <h1>
        <a href="./diet_cal.php">식단 일지</a>
    </h1>
    <label for="date">날짜</label>
        <input type="date" id="date" name="date" value="<?php echo $date; ?>">
        <a href="diet_plus_index.php?meal=아침&date=<?php echo $date; ?>">아침</a>
        <a href="diet_plus_index.php?meal=점심&date=<?php echo $date; ?>">점심</a>
        <a href="diet_plus_index.php?meal=저녁&date=<?php echo $date; ?>">저녁</a>
        <a href="diet_plus_index.php?meal=간식&date=<?php echo $date; ?>">간식</a>
</body>
</html>