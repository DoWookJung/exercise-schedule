    var sizeInput;
    function fillFoodDetails() {
        var foodName = document.getElementById("food_name").value;
        sizeInput = document.getElementById("size");
        var calorieInput = document.getElementById("calorie");

        // 여기서 Ajax 요청을 보내고 응답을 받아와서 원하는 값으로 채워줍니다
        // 음식과 해당 크기 및 칼로리 정보를 정의합니다
        var foodDetails = {
            "햇반": { size: 210, calorie: 310 },
            "밥": { size: 250, calorie: 380 },
            "잡곡밥": { size: 100, calorie: 145 },
            "계란 후라이": { size: 50, calorie: 89 },
            "삶은 계란": { size: 60, calorie: 88 },
            "맥반석 구운계란": { size: 50, calorie: 78 },
            "삶은 계란흰자": { size: 100, calorie: 28 },
            "계란 볶음밥": { size: 100, calorie: 300 },
            "스크램블 에그(계란 두개)": { size: 100, calorie: 124 },
            "사과": { size: 225, calorie: 58 },
            "찐 고구마": { size: 100, calorie: 130 },
            "냉동 블루베리(커클랜드)": { size: 140, calorie: 80 },
            "바나나": { size: 100, calorie: 87 },
            "임팩트 웨이 프로틴": { size: 30, calorie: 24 },
            "저지방 우유": { size: 330, calorie: 132 },
            "더 단백 드링크 초코": { size: 250, calorie: 263 },
            "구운 고구마": { size: 100, calorie: 161 },
            "하루견과": { size: 20, calorie: 110 },
            "닭 가슴살(150g)": { size: 150, calorie: 150 },
            "닭 가슴살(200g)": { size: 200, calorie: 200 },
            "닭 가슴살(100g)": { size: 100, calorie: 100 }
        };

        // 선택한 음식의 정보를 가져와 사이즈 및 칼로리 값을 채워줍니다
        var selectedFood = foodDetails[foodName];
        if (selectedFood) {
            sizeInput.value = selectedFood.size;
            calorieInput.value = selectedFood.calorie;
        } else {
            sizeInput.value = "";
            calorieInput.value = "";
        }
        // updateCalorie 함수를 호출합니다.
        updateCalorie();
    }

        // 사이즈 변경 시 칼로리 값을 자동으로 업데이트하는 함수입니다
        function updateCalorie() {
            var sizeInput = document.getElementById("size");
            var calorieInput = document.getElementById("calorie");
        
            var size = parseFloat(sizeInput.value);
            var calorie = parseFloat(calorieInput.value);
        
            // 사이즈와 칼로리 비율을 계산합니다
            var ratio = calorie / size;
        
            // 새로운 사이즈에 대응하는 칼로리 값을 계산하고 업데이트합니다
            if (!isNaN(size) && !isNaN(ratio)) {
                calorieInput.value = (size * ratio).toFixed(0);
            }
        }
        document.addEventListener("DOMContentLoaded", function () {
            fillFoodDetails();
            sizeInput.addEventListener("change", function () {
                updateCalorie();
            });
        
            // Register an event listener for the food_name element.
            var foodNameInput = document.getElementById("food_name");
            foodNameInput.addEventListener("change", function () {
                fillFoodDetails();
            });
        });