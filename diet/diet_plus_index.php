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
    $meal = $_GET["meal"];
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
        <input type="meal" id="meal" name="meal" value="<?php echo $meal; ?>">
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

    </body>
</html>
