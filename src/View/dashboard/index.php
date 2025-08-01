<?php
// 해당 뷰에서 필요한 컴포넌트의 CSS/JS 파일을 배열로 등록
$cssFiles = [
    '/assets/css/components/chart/doughnutChart.css',
];
  
?>

<div class="dashboard l-container">
    <div class="dashboard__header">
        <div class="dashboard__header-bg">
            <div class="dashboard__header-bg-inner"></div>
        </div>
        <div class="l-inner">
            <div>
                <div class="dashboard__header-title m-b-10">
                    반갑습니다, <span class="username"></span>님
                </div>
                <p class="dashboard__header-subtitle">방문해주셔서 감사합니다.</p>
            </div>
            <div class="dashboard__date-box" data-fade="up">
                <div class="flex-container">
                    <div class="flex-left">
                        <div class="dashboard__date-label">와커스와 함께한지</div>
                        <div class="dashboard__date-elapse roulette-box">
                            <div class="elapse-days roulette-value"></div>
                            <div class="elapse-days-unit roulette-unit">일</div>
                        </div>
                        <div class="dashboard__date-start">
                            <span class="start-date"></span> ~
                        </div>
                    </div>
                    <div class="flex-right">
                        <a href="/mypage" class="btn dashboard__link">
                            <div class="icon icon--go-link">
                                <span class="blind">마이페이지로 이동</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="notification-bell">
            <a href="/notification" class="btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="36" viewBox="0 0 32 36" fill="none">
                <path d="M7.71362 24C7.15566 24 6.64133 23.7225 6.35456 23.267C6.00232 22.6998 6.11454 21.9728 6.6164 21.5294L8.03468 20.2805V15.2368C8.0378 11.3816 11.3638 8 15.1511 8C18.9383 8 22.2643 11.3816 22.2643 15.2368V20.2805L23.6826 21.5294C24.1876 21.9728 24.2967 22.7029 23.9444 23.267C23.6608 23.7195 23.1433 24 22.5854 24H7.71362Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M19.1468 24C19.1468 26.211 17.3567 28 15.1483 28C12.94 28 11.1499 26.2079 11.1499 24H19.1499H19.1468Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="26.5" cy="7.5" r="1.5" fill="white"/>
            </svg>
            </a>
        </div>
    </div>

    <div class="l-inner">
        <div class="dashboard__content">
            <div class="l-grid g-20 dashboard-grid">

                <!-- 요약 차트 -->
                <div class="l-grid__item g-10 dashboard-grid__item m-b-20" data-fade-trigger>
                    <div class="l-title-box m-b-10">
                        <div class="l-title">대시보드</div>
                    </div>

                    <div class="card card--summary" data-card-type="todayPatient" data-fade="right">
                        <div class="card__title">
                            <div class="card__title-text">오늘 예약 환자</div>
                            <div class="card__title-value-box">
                                <div class="card__title-value-box-inner roulette-box">
                                    <span class="card__title-value roulette-value"></span>
                                    <span class="card__title-value-unit roulette-unit">명</span>
                                </div>
                                <div class="card__title-rate" data-rate="">
                                    <div class="card__title-rate-value-outer">
                                        <span class="card__title-rate-value">
                                        </span>
                                        <span class="card__title-rate-value-unit">%</span>
                                    </div>
                                    <span class="icon"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card__chart">
                            <canvas id="todayPatientSummaryChart"></canvas>
                        </div>
                    </div>

                    <div class="card card--summary" data-card-type="websiteVisitor" data-fade="right"
                        data-fade-delay="0.15">
                        <div class="card__title">
                            <div class="card__title-text">홈페이지 방문자</div>
                            <div class="card__title-value-box">
                                <div class="card__title-value-box-inner">
                                    <span class="card__title-value"></span>
                                    <span class="card__title-value-unit">명</span>
                                </div>
                                <div class="card__title-rate" data-rate="">
                                    <div class="card__title-rate-value-outer">
                                        <span class="card__title-rate-value">
                                        </span>
                                        <span class="card__title-rate-value-unit">%</span>
                                    </div>
                                    <span class="icon"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card__chart">
                            <canvas id="websiteVisitorSummaryChart"></canvas>
                        </div>
                    </div>

                    <div class="card card--summary" data-card-type="newPatient" data-fade="right" data-fade-delay="0.3">
                        <div class="card__title">
                            <div class="card__title-text">신규 환자</div>
                            <div class="card__title-value-box">
                                <div class="card__title-value-box-inner">
                                    <span class="card__title-value"></span>
                                    <span class="card__title-value-unit">명</span>
                                </div>
                                <div class="card__title-rate" data-rate="">
                                    <div class="card__title-rate-value-outer">
                                        <span class="card__title-rate-value">
                                        </span>
                                        <span class="card__title-rate-value-unit">%</span>
                                    </div>
                                    <span class="icon"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card__chart">
                            <canvas id="newPatientSummaryChart"></canvas>
                        </div>
                    </div>

                    <div class="card card--summary" data-card-type="noShowRate" data-fade="right"
                        data-fade-delay="0.45">
                        <div class="card__title">
                            <div class="card__title-text">미방문 비율</div>
                            <div class="card__title-value-box">
                                <div class="card__title-value-box-inner">
                                    <span class="card__title-value"></span>
                                    <span class="card__title-value-unit">%</span>
                                </div>
                                <div class="card__title-rate" data-rate="">
                                    <div class="card__title-rate-value-outer">
                                        <span class="card__title-rate-value">
                                        </span>
                                        <span class="card__title-rate-value-unit">%</span>
                                    </div>
                                    <span class="icon"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card__chart">
                            <canvas id="noShowRateSummaryChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- 환자 유입 경로 -->
                <div class="l-grid__item">
                    <div class="l-title-box m-b-10">
                        <div class="l-title sm">세부차트를 확인해보세요</div>
                    </div>
                    <div class="card card--inflow" data-fade="right">
                        <div class="card__title m-b-4">
                            <div class="card__title-text">환자 유입 경로</div>
                            <div class="custom-select" id="dashboardInflowChartFilter">
                                <div class="custom-select__trigger">
                                    <div class="custom-select__selected" data-value="monthly">월간</div>
                                    <div class="custom-select__arrow">
                                        <span class="icon icon--arrow-down"></span>
                                    </div>
                                </div>
                                <div class="custom-select__options">
                                    <div class="custom-select__option" data-value="daily">일별</div>
                                    <div class="custom-select__option" data-value="weekly">주간</div>
                                    <div class="custom-select__option" data-value="monthly">월간</div>
                                </div>
                            </div>
                        </div>
                        <div class="card__period m-b-20">
                            <span class="card__period-start-value"></span>
                            <span class="card__period-text-divider">~</span>
                            <span class="card__period-end-value"></span>
                        </div>
                        <div class="card__chart doughnut-chart">
                            <div class="chart-container">
                                <canvas id="inflowChart"></canvas>
                            </div>
                            <div id="inflowChartLegend" class="doughnut-chart-legend"></div>
                        </div>
                    </div>
                </div>

                <!-- 재방문률 -->
                <div class="l-grid__item">
                    <div class="card card--revisiting-rate" data-fade="right">
                        <div class="card__title m-b-4">
                            <div class="card__title-text">재방문률</div>
                            <div class="custom-select" id="dashboardRevisitingRateChartFilter">
                                <div class="custom-select__trigger">
                                    <div class="custom-select__selected" data-value="monthly">월간</div>
                                    <div class="custom-select__arrow">
                                        <span class="icon icon--arrow-down"></span>
                                    </div>
                                </div>
                                <div class="custom-select__options">
                                    <div class="custom-select__option" data-value="daily">일별</div>
                                    <div class="custom-select__option" data-value="weekly">주간</div>
                                    <div class="custom-select__option" data-value="monthly">월간</div>
                                </div>
                            </div>
                        </div>
                        <div class="card__period m-b-20">
                            <span class="card__period-start-value"></span>
                            <span class="card__period-text-divider">~</span>
                            <span class="card__period-end-value"></span>
                        </div>
                        <div class="card__chart">
                            <div class="chart-container">
                                <canvas id="revisitingRateChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- 미방문(No-show) 비율 추이 -->
                <div class="l-grid__item">
                    <div class="card card--no-show-rate" data-fade="right">
                        <div class="card__title m-b-4">
                            <div class="card__title-text">미방문(No-show) 비율 추이</div>
                            <div class="custom-select" id="dashboardNoShowRateChartFilter">
                                <div class="custom-select__trigger">
                                    <div class="custom-select__selected" data-value="monthly">월간</div>
                                    <div class="custom-select__arrow">
                                        <span class="icon icon--arrow-down"></span>
                                    </div>
                                </div>
                                <div class="custom-select__options">
                                    <div class="custom-select__option" data-value="daily">일별</div>
                                    <div class="custom-select__option" data-value="weekly">주간</div>
                                    <div class="custom-select__option" data-value="monthly">월간</div>
                                </div>
                            </div>
                        </div>
                        <div class="card__period m-b-20">
                            <span class="card__period-start-value"></span>
                            <span class="card__period-text-divider">~</span>
                            <span class="card__period-end-value"></span>
                        </div>
                        <div class="card__chart">
                            <div class="chart-container">
                                <canvas id="noShowRateChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO & 콘텐츠 분석 -->
                <div class="l-grid__item">
                    <div class="card card--donwload" data-fade="right">
                        <div class="card__title m-b-20">
                            <div class="card__title-text">SEO & 콘텐츠 분석</div>
                        </div>
                        <div class="card__content">
                            <div class="card__content-item" data-report="backlink">
                                <div class="card__content-item-top">
                                    <div class="title">
                                        백링크 분석
                                    </div>
                                </div>
                                <div class="card__content-item-bottom">
                                    <div class="date">25.07.24</div>
                                    <button type="button" class="btn btn--download">
                                        <span class="icon icon--download"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="card__content-item" data-report="onpage">
                                <div class="card__content-item-top">
                                    <div class="title">
                                        온페이지 분석
                                    </div>
                                </div>
                                <div class="card__content-item-bottom">
                                    <div class="date">25.07.24</div>
                                    <button type="button" class="btn btn--download">
                                        <span class="icon icon--download"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="module">

/**
 * 랜덤 데이터 생성 (API 응답 시뮬레이션)
 */
function generateRandomData() {
    return {
        "직접방문": Math.floor(Math.random() * 50) + 20,
        "홈페이지": Math.floor(Math.random() * 40) + 15,
        "지인소개": Math.floor(Math.random() * 30) + 10,
        "온라인광고": Math.floor(Math.random() * 20) + 5,
        "기타": Math.floor(Math.random() * 10) + 5
    };
}


/**
 * 모든 차트 제거 (페이지 이동 시 메모리 정리)
 */
function destroyAllCharts() {
    Object.values(dashboardCharts).forEach(chart => {
        if (chart && typeof chart.destroy === 'function') {
            chart.destroy();
        }
    });
}

window.addEventListener('beforeunload', destroyAllCharts);

// 커스텀 셀렉트 변경 시 호출되는 콜백 함수
function onCustomSelectChange(selectElement) {
    if (!selectElement) return;


    const selected = selectElement.querySelector(".custom-select__selected");
    const selectedValue = selected.dataset.value;
    const selectedText = selected.textContent;


    // 셀렉트 요소를 구분하기 위한 방법들
    const selectId = selectElement.id;


    // 셀렉트 ID나 위치에 따라 다른 처리
    switch (selectId) {
        case 'dashboardSummaryCardFilter':
            // updateInflowChart(selectedValue);
            break;

        case 'dashboardInflowChartFilter':
            console.log(selectedValue, dashboardCharts);
            updateInflowChart(selectedValue);
            break;

        default:
            console.log('기본 데이터로 업데이트');
    }

}

document.querySelectorAll('#dashboardInflowChartFilter .custom-select__option').forEach(btn => {
    btn.addEventListener('click', function() {
        updateInflowChart(btn.dataset.value);
    });
});

function updateInflowChart(period) {
    // 버튼 활성화 상태 변경
    // document.querySelectorAll('#dashboardInflowChartFilter .custom-select__option').forEach(btn => {
    //     btn.classList.remove('active');
    // });
    // event.target.classList.add('active');

    // 실제로는 API 호출해서 데이터 가져옴
    const newData = generateRandomData();

    console.log(destroyAllCharts)

    // 차트 업데이트
    dashboardCharts.inflow.update(newData);

    console.log(`${period} 데이터로 차트 업데이트 완료`);
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