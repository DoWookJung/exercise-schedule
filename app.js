const today = new Date();
const year = today.getFullYear();
const month = today.getMonth() + 1;

const calendarBody = document.querySelector('#calendar tbody');

// 해당 월의 첫 날 구하기
const firstDay = new Date(`${year}-${month}-01`);
// 해당 월의 마지막 날 구하기
const lastDay = new Date(year, month, 0);

let date = 1;
for (let i = 0; i < 6; i++) {
  const row = document.createElement('tr');
  for (let j = 0; j < 7; j++) {
    const cell = document.createElement('td');
    if (i === 0 && j < firstDay.getDay()) {
      // 이번 달 시작 이전의 빈 칸
    } else if (date > lastDay.getDate()) {
      // 이번 달 끝 이후의 빈 칸
    } else {
      const link = document.createElement('a');
      link.textContent = date;
      link.href = `../index.php?`;
      cell.appendChild(link);
      if (year === today.getFullYear() && month === today.getMonth() + 1 && date === today.getDate()) {
        // 오늘 날짜 표시
        cell.classList.add('today');
      } 
      date++;
    }
    row.appendChild(cell);
  }
  calendarBody.appendChild(row);
}
