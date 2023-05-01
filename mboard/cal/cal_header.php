<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>운동, 식단 관리</title>
<link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<header>
    <h3 class="logo">
        <a href="../../main/index.php">운동 캘린더</a>
    </h3>
    <ul class="top_menu">
<?php
    $logg = $year."-".$month."-".$date;
    echo "<li>$logg</li>";
?>
    </ul> <!-- top_menu -->
</header>