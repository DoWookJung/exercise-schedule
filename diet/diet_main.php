<?php
if (isset($_GET['date'])) {
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
  <link rel="shortcut icon" type="health.png" sizes="16x16" href="health.png">
  <link rel="stylesheet" href="../mboard/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <style>
    a {
      text-decoration: none;
    }

    .meal-container {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .center-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
    
  </style>
</head>

<body>
  <h1>
    <a href="./diet_cal.php">
      <img src="../img/diet.png" alt="식단 일지" width="60" height="60">
    </a>
    <a href="./diet_cal.php">식단 일지</a>
  </h1>
  <div class="center-wrapper" style="display: flex; justify-content: center; align-items: center;">
    <label for="date">날짜</label>
    <input type="date" id="date" name="date" value="<?php echo $date; ?>">
  </div>

  <hr style="width: 30%; border:0px; height:1px; background: linear-gradient(to left, transparent, rgba(6,135,205,1), transparent);">

  <div class="meal-container">
    <th>
      <a href="diet_plus_index.php?meal=아침&date=<?php echo $date; ?>">
        <img src="../img/breakfast.png" alt="아침" width="60" height="60">
      </a>
    </th>
    <a href="diet_plus_index.php?meal=아침&date=<?php echo $date; ?>" style="font-size: 24px; margin-left : 20px">아침</a>
    <button onclick="window.location.href='diet_plus_index.php?meal=아침&date=<?php echo $date; ?>';" style="border-radius: 50%; margin-left: 10%; width: 45px; height: 45px; background-color: skyblue;">
    <a href="#"><i class="fas fa-plus" style="font-size: 28px;"></i></a>
    </button>
  </div>

  <hr style="width: 30%; border:0px; height:1px; background: linear-gradient(to left, transparent, rgba(6,135,205,1), transparent);">

  <div class="meal-container">
    <th>
      <a href="diet_plus_index.php?meal=점심&date=<?php echo $date; ?>">
        <img src="../img/lunch.png" alt="점심" width="60" height="60">
      </a>
    </th>
    <a href="diet_plus_index.php?meal=점심&date=<?php echo $date; ?>" style="font-size: 24px; margin-left : 20px">점심</a>
    <button onclick="window.location.href='diet_plus_index.php?meal=점심&date=<?php echo $date; ?>';" style="border-radius: 50%; margin-left: 10%; width: 45px; height: 45px; background-color: skyblue;">
    <a href="#"><i class="fas fa-plus" style="font-size: 28px;"></i></a>
    </button>
  </div>

  <hr style="width: 30%; border:0px; height:1px; background: linear-gradient(to left, transparent, rgba(6,135,205,1), transparent);">

  <div class="meal-container">
    <th>
      <a href="diet_plus_index.php?meal=저녁&date=<?php echo $date; ?>">
        <img src="../img/dinner.png" alt="저녁" width="60" height="60">
      </a>
    </th>
    <a href="diet_plus_index.php?meal=저녁&date=<?php echo $date; ?>" style="font-size: 24px; margin-left : 20px">저녁</a>
    <button onclick="window.location.href='diet_plus_index.php?meal=저녁&date=<?php echo $date; ?>';" style="border-radius: 50%; margin-left: 10%; width: 45px; height: 45px; background-color: skyblue;">
    <a href="#"><i class="fas fa-plus" style="font-size: 28px;"></i></a>
    </button>
  </div>

  <hr style="width: 30%; border:0px; height:1px; background: linear-gradient(to left, transparent, rgba(6,135,205,1), transparent);">

  <div class="meal-container">
    <th>
      <a href="diet_plus_index.php?meal=간식&date=<?php echo $date; ?>">
        <img src="../img/snack.png" alt="간식" width="60" height="60">
      </a>
    </th>
    <a href="diet_plus_index.php?meal=간식&date=<?php echo $date; ?>" style="font-size: 24px; margin-left : 20px">간식</a>
    <button onclick="window.location.href='diet_plus_index.php?meal=간식&date=<?php echo $date; ?>';" style="border-radius: 50%; margin-left: 10%; width: 45px; height: 45px; background-color: skyblue;">
    <a href="#"><i class="fas fa-plus" style="font-size: 28px;"></i></a>
    </button>
  </div>

  <hr style="width: 30%; border:0px; height:1px; background: linear-gradient(to left, transparent, rgba(6,135,205,1), transparent);">

</body>

</html>
