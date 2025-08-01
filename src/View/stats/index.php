<?php
// 해당 뷰에서 필요한 컴포넌트의 CSS/JS 파일을 배열로 등록
$cssFiles = [
    '/assets/css/components/chart/doughnutChart.css',
];
  
?>

<div class="stats l-container">
    <div class="l-title-box">
        <div class="l-inner">
            <div class="l-title">통계 분석</div>
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

    <div class="l-inner p-t-0">
        <div class="stats__content">
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

</div>

<script>
// 커스텀 셀렉트 변경 시 호출되는 콜백 함수
function onCustomSelectChange(selectElement) {
    if (!selectElement) return;

    const selectedValue = selectElement.dataset.value;
    const selectedText = selectElement.querySelector('.custom-select__selected').textContent;

    // 셀렉트 요소를 구분하기 위한 방법들
    const selectId = selectElement.id;


    // 셀렉트 ID나 위치에 따라 다른 처리
    switch (selectId) {
        case 'dashboardSummaryCardFilter':
            updateSummaryCardData(selectedValue);

            break;
        default:
            console.log('기본 데이터로 업데이트');
    }

}

// 기간 설정에 따른 summary card 데이터 업데이트 함수
function updateSummaryCardData(period) {
    switch (period) {
        case 'daily':
            console.log('일별 데이터로 업데이트');
            // 일별 데이터 api 호출

            break;
        case 'weekly':
            console.log('주간 데이터로 업데이트');
            // 주간 데이터 api 호출

            break;
        case 'monthly':
            console.log('월간 데이터로 업데이트');
            // 월간 데이터 api 호출

            break;
        case 'yearly':
            console.log('연간 데이터로 업데이트');
            // 연간 데이터 api 호출

            break;
        default:
            console.log('기본 데이터로 업데이트');
    }

    // API response : 기간별 업데이트 데이터 (더미)
    const data = {
        todayPatient: {
            value: Math.floor(Math.random() * 101), // 0–100
            rate: Math.floor(Math.random() * 41) - 20, // -20–20
            graph: {
                "2025-07-01": Math.floor(Math.random() * 101),
                "2025-07-02": Math.floor(Math.random() * 101),
                "2025-07-03": Math.floor(Math.random() * 101),
                "2025-07-04": Math.floor(Math.random() * 101),
                "2025-07-05": Math.floor(Math.random() * 101),
                "2025-07-06": Math.floor(Math.random() * 101),
                "2025-07-07": Math.floor(Math.random() * 101),
                "2025-07-08": Math.floor(Math.random() * 101),
                "2025-07-09": Math.floor(Math.random() * 101),
                "2025-07-10": Math.floor(Math.random() * 101),
            }
        },
        websiteVisitor: {
            value: Math.floor(Math.random() * 5001), // 0–5000
            rate: Math.floor(Math.random() * 201) - 100, // -100–100
            graph: {
                "2025-07-01": Math.floor(Math.random() * 5001),
                "2025-07-02": Math.floor(Math.random() * 5001),
                "2025-07-03": Math.floor(Math.random() * 5001),
                "2025-07-04": Math.floor(Math.random() * 5001),
                "2025-07-05": Math.floor(Math.random() * 5001),
                "2025-07-06": Math.floor(Math.random() * 5001),
                "2025-07-07": Math.floor(Math.random() * 5001),
                "2025-07-08": Math.floor(Math.random() * 5001),
                "2025-07-09": Math.floor(Math.random() * 5001),
                "2025-07-10": Math.floor(Math.random() * 5001),
            }
        },
        newPatient: {
            value: Math.floor(Math.random() * 61), // 0–60
            rate: Math.floor(Math.random() * 201) - 100, // -100–100
            graph: {
                "2025-07-01": Math.floor(Math.random() * 101),
                "2025-07-02": Math.floor(Math.random() * 101),
                "2025-07-03": Math.floor(Math.random() * 101),
                "2025-07-04": Math.floor(Math.random() * 101),
                "2025-07-05": Math.floor(Math.random() * 101),
                "2025-07-06": Math.floor(Math.random() * 101),
                "2025-07-07": Math.floor(Math.random() * 101),
                "2025-07-08": Math.floor(Math.random() * 101),
                "2025-07-09": Math.floor(Math.random() * 101),
                "2025-07-10": Math.floor(Math.random() * 101),
            }
        },
        noShowRate: {
            value: Math.round((Math.random() * 1000) / 10 * 10) / 10, // 0.0–100.0
            rate: Math.floor(Math.random() * 201) - 100, // -100–100
            graph: {
                "2025-07-01": Math.floor(Math.random() * 101),
                "2025-07-02": Math.floor(Math.random() * 101),
                "2025-07-03": Math.floor(Math.random() * 101),
                "2025-07-04": Math.floor(Math.random() * 101),
                "2025-07-05": Math.floor(Math.random() * 101),
                "2025-07-06": Math.floor(Math.random() * 101),
                "2025-07-07": Math.floor(Math.random() * 101),
                "2025-07-08": Math.floor(Math.random() * 101),
                "2025-07-09": Math.floor(Math.random() * 101),
                "2025-07-10": Math.floor(Math.random() * 101),
            }
        }
    };

    updateCard('todayPatient', data.todayPatient);
    updateCard('websiteVisitor', data.websiteVisitor);
    updateCard('newPatient', data.newPatient);
    updateCard('noShowRate', data.noShowRate);

    const charts = window.statsCharts;

    if (charts.todayPatient) updateChart(charts.todayPatient, data.todayPatient);
    if (charts.websiteVisitor) updateChart(charts.websiteVisitor, data.websiteVisitor);
    if (charts.newPatient) updateChart(charts.newPatient, data.newPatient);
    if (charts.noShowRate) updateChart(charts.noShowRate, data.noShowRate);
}

function updateCard(cardType, cardData) {
    // 카드 요소들 찾기
    const card = document.querySelector(`[data-card-type="${cardType}"]`);

    // 값 업데이트
    const valueElement = card.querySelector('.card__title-value');
    if (valueElement) {
        valueElement.textContent = cardData.value
    }

    // 증감률 업데이트
    const rateElement = card.querySelector('.card__title-rate');
    const rateValueElement = card.querySelector('.card__title-rate-value');
    const rateIconElement = card.querySelector('.icon');

    if (rateElement && rateValueElement && rateIconElement) {
        const isIncrease = cardData.rate > 0;
        const rateType = isIncrease ? 'increase' : 'decrease';

        // 증감률 값 업데이트
        rateValueElement.textContent = `${cardData.rate}`;

        // 증감률 스타일 업데이트
        rateElement.setAttribute('data-rate', rateType);

        // 아이콘 클래스 업데이트
        rateIconElement.className = `icon icon--${rateType}`;
    }
}

function updateChart(chart, data) {
    if (!chart) return;

    // 실제 구현 시 여기에 해당 기간의 새로운 데이터를 가져와서 차트 업데이트
    console.log(`Chart ${chart.canvas.id}를 ${data} 데이터로 업데이트`);

    // chart.data.datasets[0].data = newData;
    // chart.data.labels = newLabels;

    // 차트 다시 그리기
    chart.data.datasets[0].data = [
        Math.floor(Math.random() * 100),
        Math.floor(Math.random() * 100),
        Math.floor(Math.random() * 100),
        Math.floor(Math.random() * 100),
        Math.floor(Math.random() * 100),
        Math.floor(Math.random() * 100),
        Math.floor(Math.random() * 100),
        Math.floor(Math.random() * 100),
        Math.floor(Math.random() * 100),
        Math.floor(Math.random() * 100),
    ];
    chart.data.datasets[0].backgroundColor = data.rate > 0 ? "#05BA7B" : "#FB3636";
    chart.data.datasets[0].borderColor = data.rate > 0 ? "#05BA7B" : "#FB3636";

    chart.update();
}
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