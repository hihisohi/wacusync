<?php

?>


<!-- chart.js 스크립트 -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js">
</script>

<div class="stats l-container">
    <div class="l-inner">
        <div class="l-title-box m-b-30">
            <div class="l-title">통계 분석</div>
        </div>


        <div class="stats__content">
            <div class="l-grid g-20 stats-grid">

                <!-- 인구통계학적 분석 -->
                <div class="l-grid__item">
                    <div class="card card--age">
                        <div class="card__title m-b-20">
                            <div class="card__title-text">인구통계학적 분석</div>
                        </div>
                        <!-- 연령대 별 -->
                        <div class="card__chart doughnut-chart m-b-30">
                            <div class="chart-container">
                                <canvas id="ageChart"></canvas>
                            </div>
                            <div id="ageChartLegend" class="doughnut-chart-legend"></div>

                            <script>
                            const ageChartCanvas = document.getElementById('ageChart');

                            const ageChartDataResponse =
                                <?php echo json_encode(json_decode(file_get_contents(__DIR__ . "/../../../data/dummy/statsDemographics.json"), true)); ?>;

                            const ageChartData = {
                                labels: Object.keys(ageChartDataResponse.age),
                                datasets: [{
                                    label: '인구통계학적 분석',
                                    data: Object.values(ageChartDataResponse.age),
                                }]
                            };

                            const doughnutChartColors = ['#FFC544', '#7FE47E', '#FF718B', '#4587FF'];

                            const ageChartConfig = {
                                type: 'doughnut',
                                data: ageChartData,
                                options: {
                                    cutout: '65%',
                                    responsive: true,
                                    backgroundColor: doughnutChartColors,
                                    borderRadius: 10,
                                    borderWidth: 0,
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        tooltip: {
                                            enabled: false
                                        }
                                    },
                                    onHover: (evt, items) => {
                                        evt.native.target.style.cursor = items.length ? 'pointer' : '';
                                    }
                                },
                                plugins: [customTooltip(), renderageChartLegend('#ageChartLegend')]
                            };

                            const ageChart = new Chart(ageChartCanvas, ageChartConfig);

                            // 전역 차트 저장소가 없으면 생성
                            if (!window.statsCharts) {
                                window.statsCharts = {};
                            }
                            window.statsCharts.age = ageChart;


                            function renderageChartLegend(containerSelector) {
                                return {
                                    id: 'ageChartLegend',
                                    afterUpdate(ageChart) {
                                        const container = document.querySelector(containerSelector);
                                        container.innerHTML = ''; // 초기화

                                        ageChart.data.labels.forEach((label, i) => {
                                            const color = doughnutChartColors[i];
                                            const value = ageChart.data.datasets[0].data[i];

                                            // ● + 텍스트 + 값 구조
                                            const item = document.createElement('div');
                                            item.className = 'legend__item';
                                            item.innerHTML = `
                                            <div class="legend__item-label">
                                                <span class="label__color" style="background:${color}"></span>
                                                <span class="label__text">${label}</span>
                                            </div>
                                            <div class="legend__item-value">
                                                <span class="value__text">${value}</span>
                                            </div>
                                            `;
                                            // 클릭 시 해당 데이터셋 토글 기능 (선택 사항)
                                            item.onclick = () => {
                                                ageChart.toggleDataVisibility(i);
                                                ageChart.update();
                                            };
                                            container.appendChild(item);
                                        });
                                    }
                                };
                            }

                            function customTooltip() {
                                return {
                                    id: 'customTooltip',
                                    afterDraw(ageChart) {
                                        const tooltipEl = getOrCreateTooltip(ageChart);
                                        const tooltipModel = ageChart.tooltip;

                                        // 보이지 않을 땐 숨기기
                                        if (tooltipModel.opacity === 0) {
                                            tooltipEl.style.opacity = 0;
                                            return;
                                        }

                                        // 텍스트 세팅
                                        const dataIndex = tooltipModel.dataPoints[0].dataIndex;
                                        const value = ageChart.data.datasets[0].data[dataIndex];
                                        tooltipEl.innerHTML = `<div class="tooltip-box">${value}건</div>`;

                                        // 위치 계산
                                        const {
                                            canvas
                                        } = ageChart;
                                        const position = canvas.getBoundingClientRect();
                                        const caret = tooltipModel.caretY || 0;

                                        tooltipEl.style.opacity = 1;
                                        tooltipEl.style.left =
                                            position.left +
                                            window.pageXOffset +
                                            tooltipModel.caretX +
                                            "px";
                                        tooltipEl.style.top =
                                            position.top +
                                            window.pageYOffset +
                                            caret -
                                            tooltipEl.offsetHeight -
                                            10 +
                                            "px";
                                    }
                                };
                            }

                            function getOrCreateTooltip(chart) {
                                let el = document.getElementById('chartjs-tooltip');
                                if (!el) {
                                    el = document.createElement('div');
                                    el.id = 'chartjs-tooltip';
                                    el.style.position = 'absolute';
                                    el.style.pointerEvents = 'none';
                                    document.body.appendChild(el);
                                }
                                return el;
                            }
                            </script>
                        </div>

                        <!-- 성별 별 -->
                        <div class="card__chart doughnut-chart">
                            <div class="chart-container">
                                <canvas id="genderChart"></canvas>
                            </div>
                            <div id="genderChartLegend" class="doughnut-chart-legend"></div>

                            <script>
                            const genderChartCanvas = document.getElementById('genderChart');

                            const genderChartDataResponse =
                                <?php echo json_encode(json_decode(file_get_contents(__DIR__ . "/../../../data/dummy/statsDemographics.json"), true)); ?>;

                            const genderChartData = {
                                labels: Object.keys(genderChartDataResponse.gender),
                                datasets: [{
                                    label: '인구통계학적 분석',
                                    data: Object.values(genderChartDataResponse.gender),
                                }]
                            };

                            const doughnutChartColors2 = ['#4587FF', '#FF718B'];

                            const genderChartConfig = {
                                type: 'doughnut',
                                data: genderChartData,
                                options: {
                                    cutout: '65%',
                                    responsive: true,
                                    backgroundColor: doughnutChartColors2,
                                    borderRadius: 10,
                                    borderWidth: 0,
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        tooltip: {
                                            enabled: false
                                        }
                                    },
                                    onHover: (evt, items) => {
                                        evt.native.target.style.cursor = items.length ? 'pointer' : '';
                                    }
                                },
                                plugins: [customTooltip(), rendergenderChartLegend('#genderChartLegend')]
                            };

                            const genderChart = new Chart(genderChartCanvas, genderChartConfig);

                            // 전역 차트 저장소가 없으면 생성
                            if (!window.statsCharts) {
                                window.statsCharts = {};
                            }
                            window.statsCharts.age = genderChart;


                            function rendergenderChartLegend(containerSelector) {
                                return {
                                    id: 'genderChartLegend',
                                    afterUpdate(genderChart) {
                                        const container = document.querySelector(containerSelector);
                                        container.innerHTML = ''; // 초기화

                                        genderChart.data.labels.forEach((label, i) => {
                                            const color = doughnutChartColors2[i];
                                            const value = genderChart.data.datasets[0].data[i];

                                            // ● + 텍스트 + 값 구조
                                            const item = document.createElement('div');
                                            item.className = 'legend__item';
                                            item.innerHTML = `
                                            <div class="legend__item-label">
                                                <span class="label__color" style="background:${color}"></span>
                                                <span class="label__text">${label}</span>
                                            </div>
                                            <div class="legend__item-value">
                                                <span class="value__text">${value}</span>
                                            </div>
                                            `;
                                            // 클릭 시 해당 데이터셋 토글 기능 (선택 사항)
                                            item.onclick = () => {
                                                genderChart.toggleDataVisibility(i);
                                                genderChart.update();
                                            };
                                            container.appendChild(item);
                                        });
                                    }
                                };
                            }

                            function customTooltip() {
                                return {
                                    id: 'customTooltip',
                                    afterDraw(genderChart) {
                                        const tooltipEl = getOrCreateTooltip(genderChart);
                                        const tooltipModel = genderChart.tooltip;

                                        // 보이지 않을 땐 숨기기
                                        if (tooltipModel.opacity === 0) {
                                            tooltipEl.style.opacity = 0;
                                            return;
                                        }

                                        // 텍스트 세팅
                                        const dataIndex = tooltipModel.dataPoints[0].dataIndex;
                                        const value = genderChart.data.datasets[0].data[dataIndex];
                                        tooltipEl.innerHTML = `<div class="tooltip-box">${value}건</div>`;

                                        // 위치 계산
                                        const {
                                            canvas
                                        } = genderChart;
                                        const position = canvas.getBoundingClientRect();
                                        const caret = tooltipModel.caretY || 0;

                                        tooltipEl.style.opacity = 1;
                                        tooltipEl.style.left =
                                            position.left +
                                            window.pageXOffset +
                                            tooltipModel.caretX +
                                            "px";
                                        tooltipEl.style.top =
                                            position.top +
                                            window.pageYOffset +
                                            caret -
                                            tooltipEl.offsetHeight -
                                            10 +
                                            "px";
                                    }
                                };
                            }

                            function getOrCreateTooltip(chart) {
                                let el = document.getElementById('chartjs-tooltip');
                                if (!el) {
                                    el = document.createElement('div');
                                    el.id = 'chartjs-tooltip';
                                    el.style.position = 'absolute';
                                    el.style.pointerEvents = 'none';
                                    document.body.appendChild(el);
                                }
                                return el;
                            }
                            </script>
                        </div>
                    </div>
                </div>

                <!-- 진료과별 매출 분석 -->
                <div class="l-grid__item">
                    <div class="card card--inflow">
                        <div class="card__title m-b-20">
                            <div class="card__title-text">진료과별 매출 분석</div>
                        </div>
                        <div class="card__chart">
                            <div class="chart-container">
                                <canvas id="subjectChart"></canvas>
                            </div>

                            <script>
                            const subjectChartCanvas = document.getElementById('subjectChart');

                            const subjectChartDataResponse =
                                <?php echo json_encode(json_decode(file_get_contents(__DIR__ . "/../../../data/dummy/statsSubject.json"), true)); ?>;

                            const subjectChartData = {
                                labels: Object.keys(subjectChartDataResponse),
                                datasets: [{
                                    label: '매출 (단위: 건)',
                                    data: Object.values(subjectChartDataResponse),
                                    backgroundColor: '#4587FF',
                                    borderColor: '#4587FF',
                                    borderWidth: 0,
                                    borderRadius: 8,
                                }]
                            };

                            const subjectChartConfig = {
                                type: 'bar',
                                data: subjectChartData,
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        title: {
                                            display: false,
                                            text: '진료과별 매출 분석'
                                        },
                                        legend: {
                                            display: false
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    return context.parsed.y + '건';
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            beginAtZero: true,
                                            ticks: {
                                                color: '#615E83',
                                                font: {
                                                    size: 12
                                                }
                                            },
                                            grid: {
                                                display: false
                                            }
                                        },
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                color: '#615E83',
                                                font: {
                                                    size: 12
                                                },
                                                callback: function(value) {
                                                    return value + '건';
                                                }
                                            },
                                            grid: {
                                                color: '#E5E5EF',
                                            }
                                        }
                                    }
                                },
                            };

                            const subjectChart = new Chart(subjectChartCanvas, subjectChartConfig);

                            // 전역 차트 저장소가 없으면 생성
                            if (!window.statsCharts) {
                                window.statsCharts = {};
                            }
                            window.statsCharts.subject = subjectChart;
                            </script>
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