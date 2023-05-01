const today = new Date();
const dateElem = document.getElementById('date');
const weightElem = document.getElementById('weight');
const exerciseElem = document.getElementById('exercise');
const repsElem = document.getElementById('reps');
const setsElem = document.getElementById('sets');
const tbodyElem = document.querySelector('tbody');

// 현재 날짜로 초기화
dateElem.valueAsDate = today;

// 저장 버튼 클릭 시 데이터 저장
document.getElementById('save-btn').addEventListener('click', () => {
  // 입력된 값 가져오기
  const date = dateElem.value;
  const weight = weightElem.value;
  const exercise = exerciseElem.value;
  const reps = repsElem.value;
  const sets = setsElem.value;

  // 값이 모두 입력되어 있는지 확인
  if (date && weight && exercise && reps && sets) {
    // 서버에 데이터 전송
    fetch('save.php', {
      method: 'POST',
      body: new FormData(document.getElementById('form'))
    })
      .then(response => response.text())
      .then(data => {
        // 저장 성공 시 새로운 행 추가
        const newRow = tbodyElem.insertRow();
        newRow.innerHTML = `
          <td>${date}</td>
          <td>${weight}</td>
          <td>${exercise}</td>
          <td>${reps}</td>
          <td>${sets}</td>
        `;
        // 입력 폼 초기화
        dateElem.valueAsDate = today;
        weightElem.value = '';
        exerciseElem.value = '';
        repsElem.value = '';
        setsElem.value = '';
      })
      .catch(error => console.error(error));
  } else {
    alert('모든 항목을 입력해주세요.');
  }
});

// 이전 날짜 클릭 시 저장된 데이터 불러오기
document.querySelectorAll('tbody tr').forEach(row => {
  row.addEventListener('click', () => {
    const date = row.cells[0].textContent;
    fetch(`load.php?date=${date}`)
      .then(response => response.json())
      .then(data => {
        dateElem.value = data.date;
        weightElem.value = data.weight;
        exerciseElem.value = data.exercise;
        repsElem.value = data.reps;
        setsElem.value = data.sets;
      })
      .catch(error => console.error(error));
  });
});
