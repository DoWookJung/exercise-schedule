<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>운동일지 추가</title>
  </head>
  <body>
    <h1>운동일지 추가</h1>
    <form method="post" action="add_exercise.php">

      <label for="exercise-name">운동이름</label>
      <input type="text" id="exercise-name" name="exercise-name"><br>

      <label for="exercise-sets">세트수</label>
      <input type="number" id="exercise-sets" name="exercise-sets"><br>

      <label for="exercise-reps">반복수</label>
      <input type="number" id="exercise-reps" name="exercise-reps"><br>

      <label for="exercise-weight">중량</label>
      <input type="number" id="exercise-weight" name="exercise-weight"><br>

      <input type="submit" value="운동일지 추가">
    </form>
  </body>
</html>
    