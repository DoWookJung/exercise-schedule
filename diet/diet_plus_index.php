<?php 
    session_start();
    if (isset($_SESSION["userid"]))
        $userid = $_SESSION["userid"];
    else {     
        $userid = "";
    }

    if(isset($_GET['date'])) {
        $date = $_GET['date'];
    } else {
        $date = null; // date가 없으면 null로 초기화
    }
    
    $meal = isset($_GET['meal']) ? urldecode($_GET['meal']) : null;

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>식단일지</title>
    <link rel="stylesheet" type="text/css" href="../mboard/style.css">
    <script src="diet_script.js"></script>
  </head>
    <body>
    <form action="diet_save.php" method="post">
        <label for="date">날짜</label>
        <input type="date" id="date" name="date" value="<?php echo $date; ?>">
        <br>
        <label for="meal">식사</label>
        <input type="meal" id="meal" name="meal" list="meal_list" value="<?php echo $meal; ?>">
            <datalist id=meal_list>
                <option value="아침">
                <option value="점심">
                <option value="저녁">
                <option value="간식">
                </option>
            </datalist>
        <div class="form-group">
            <label for="food_name">음식 이름</label>
            <input type="search" name="food_name" id="food_name" list="food_list"onchange="fillFoodDetails()"><br>
            <datalist id="food_list">
                <option value="----------------밥------------">
                <option value="햇반">
                <option value="밥">
                <option value="--------------계란------------">
                <option value="계란 후라이">
                <option value="삶은 계란">
                <option value="맥반석 구운계란">
                <option value="삶은 계란흰자">
                <option value="계란 볶음밥">
                <option value="스크램블 에그(계란 두개)">
                <option value="--------------과일------------">
                <option value="사과">
                <option value="바나나">
                <option value="냉동 블루베리(커클랜드)">
                <option value="--------------간식------------">
                <option value="구운 고구마">
                <option value="찐 고구마">
                <option value="하루견과">
                <option value="저지방 우유">
                <option value="더 단백 드링크 초코">
                <option value="임팩트 웨이 프로틴">
                <option value="-------------닭 가슴살---------">
                <option value="닭 가슴살(100g)">
                <option value="닭 가슴살(150g)">
                <option value="닭 가슴살(200g)">
            </datalist> 
        </div>
        <label for="size">용량</label>
        <input type="text" name="size" id="size" onchange="updateCalorie()" />
        <br>
        <label for="calorie">칼로리</label>
        <input type="text" name="calorie" id="calorie" />
        
        <button type="submit" class="my-button">저장</button>
    </form>
    <hr>
    <h2>저장한 식단 기록</h2>
    <?php
    include "../include/db_connect.php";
    if (isset($_SESSION["username"])) 
        $username = $_SESSION["username"];
    else 
        $username = "";  
    // 테이블 구조에 맞게 쿼리를 사용자 정의합니다.
    $sql = "SELECT * FROM diet_log WHERE name = '$username'";
    if ($date) {
    $sql .= " AND date = '$date'";
    }
    $sql .= " ORDER BY CASE meal 
            WHEN '아침' THEN 1 
            WHEN '점심' THEN 2 
            WHEN '저녁' THEN 3 
            WHEN '간식' THEN 4 
            END"; 


    $result = mysqli_query($con, $sql);


    if ($result->num_rows > 0) {
    echo "<form action='diet_modify.php' method='post'>";
    echo "<table>";
    echo "<input type='hidden' name='date' value='" . $date . "'>"; // date 값을 추가
    echo "<tr><th>식사</th><th>음식 이름</th><th>용량</th><th>칼로리</th></th>";
    $totalCalories = 0;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<input type='hidden' name='id[]' value='" . $row['id'] . "'>"; // id 값을 추가
        echo "<td><input type='text' name='meal[]' value='" . htmlspecialchars($row['meal']) . "'></td>";
        echo "<td><input type='text' name='food_name[]' value='" . $row['food_name'] . "'></td>";
        echo "<td><input type='text' name='amount[]' value='" . $row['amount'] . "'></td>";
        echo "<td><input type='text' name='calories[]' value='" . $row['calories'] . "'></td>";
        echo "<td><input type='submit' class=\"my-button\" name='modify' value='수정'></td>";
        echo "<td><button type='button' class=\"my-button\" onclick=\"location.href='diet_delete.php?id=" . $row['id'] . "&date=".$date. "'\">삭제</button></td>";
        // echo "<td><button type='button' class=\"my-button\" onclick=\"location.href='cal_graph.php?exercise=" . urlencode(urldecode($row['exercise'])) . "&date=" . urlencode(urldecode($date)) . "'\">볼륨</button></td>";
        $totalCalories += $row['calories']; 
        echo "</tr>";
    }
    echo "<tr><th colspan='3' style='text-align: right;'>총 칼로리:</th><th>$totalCalories</th></tr>";
    echo "</table>";
    echo "</form>";
    } else {
    echo "<p>저장된 항목이 없습니다.</p>";
    }

    mysqli_close($con);
    ?>
    </body>
</html>
