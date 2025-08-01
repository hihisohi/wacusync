<?php
// 해당 뷰에서 필요한 컴포넌트의 CSS/JS 파일을 배열로 등록
$cssFiles = [
    '/assets/css/components/chart/doughnutChart.css',
];
  
?>

<div class="page page-stats">
    <div class="page__header">
        <div class="container">
            <div class="page__title">
                <div class="page__title-text">통계 분석</div>
            </div>

            <div class="notification-bell">
                <a href="/notification" class="btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="36" viewBox="0 0 32 36" fill="none">
                    <path d="M7.71362 24C7.15566 24 6.64133 23.7225 6.35456 23.267C6.00232 22.6998 6.11454 21.9728 6.6164 21.5294L8.03468 20.2805V15.2368C8.0378 11.3816 11.3638 8 15.1511 8C18.9383 8 22.2643 11.3816 22.2643 15.2368V20.2805L23.6826 21.5294C24.1876 21.9728 24.2967 22.7029 23.9444 23.267C23.6608 23.7195 23.1433 24 22.5854 24H7.71362Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M19.1468 24C19.1468 26.211 17.3567 28 15.1483 28C12.94 28 11.1499 26.2079 11.1499 24H19.1499H19.1468Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="26.5" cy="7.5" r="1.5" fill="#4587FF"/>
                </svg>
                </a>
            </div>
        </div>
    </div>

    <div class="page__content">
        <div class="container">
            <div class="l-grid g-20 stats-grid">

                <!-- 인구통계학적 분석 -->
                <div class="l-grid__item">
                    <div class="card card--demographics">
                        <div class="card__title m-b-20">
                            <div class="card__title-text">인구통계학적 분석</div>
                        </div>
                        
                        <!-- 연령대 별 -->
                        <div class="card__chart doughnut-chart m-b-30">
                            <div class="chart-container">
                                <canvas id="ageChart"></canvas>
                            </div>
                            <div id="ageChartLegend" class="doughnut-chart-legend"></div>
                        </div>

                        <!-- 성별 별 -->
                        <div class="card__chart doughnut-chart">
                            <div class="chart-container">
                                <canvas id="genderChart"></canvas>
                            </div>
                            <div id="genderChartLegend" class="doughnut-chart-legend"></div>
                        </div>
                    </div>
                </div>

                <!-- 진료과별 매출 분석 -->
                <div class="l-grid__item">
                    <div class="card card--sales">
                        <div class="card__title m-b-20">
                            <div class="card__title-text">진료과별 매출 분석</div>
                        </div>
                        <div class="card__chart">
                            <div class="chart-container">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 홈페이지 유입 키워드 분석 -->
                <div class="l-grid__item">
                    <div class="card card--keyword">
                        <div class="card__title m-b-20">
                            <div class="card__title-text">홈페이지 유입 키워드 분석</div>
                        </div>
                        <div class="card__chart doughnut-chart m-b-20">
                            <div class="chart-container">
                                <canvas id="keywordChart"></canvas>
                            </div>
                            <div id="keywordChartLegend" class="doughnut-chart-legend"></div>
                        </div>
                        <div class="card__table" id="keywordTable">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="date-picker-box">
        <div class="date-picker-inner">
            <div class="date-picker__label">
                <span class="blind">조희기간 선택</span>
                <span class="icon icon--calendar"></span>
            </div>
            <input id="statsFlatpickr" class="date-picker__input" type="text" placeholder="YY.MM.DD" />
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr("#statsFlatpickr", {
            mode: "range",
            dateFormat: "Y-m-d",
            locale: { 
            
                weekdays: {
                    shorthand: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
                    longhand: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
                },
                months: {
                    shorthand: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
                    longhand: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
                },
                rangeSeparator: "~", // 여기를 원하는 한글 구분자로 변경!
            },
            defaultDate: ["2025-07-02", "2025-08-01"],
            altInput: true,
            altFormat: "y.m.d",
            onOpen: (selectedDates, dateStr, instance) => {
                const cal = instance.calendarContainer;
                cal.classList.add("centered");
            },

              // 달력 닫힐 때
            onClose: (selectedDates, dateStr, instance) => {
                const cal = instance.calendarContainer;
                cal.classList.remove("centered");
            }
      });
    });
</script>

<style>
#chartjs-tooltip .tooltip-box {
    background: rgba(0, 0, 0, 0.8);
    color: #fff;
    padding: 0.4em 0.6em;
    border-radius: 4px;
    white-space: nowrap;
    font-size: 0.8em;
    transform: translateX(-50%);
}
</style>