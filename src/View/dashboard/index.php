<?php
    function daysSince(string $dateString): int
    {
        // 포맷에 맞춰 날짜 생성
        $date = DateTime::createFromFormat('Y.m.d', $dateString);
        if (! $date) {
            throw new Exception("잘못된 날짜 포맷: {$dateString}");
        }

        // 오늘 날짜(시분초 제거)
        $today = new DateTime('today');

        // 두 날짜 차이를 구하고, days 프로퍼티로 일수 리턴
        $diff = $today->diff($date);
        return $diff->days+1;
    }

    // API response : 유저정보 (더미)
    $userInfo = json_decode(file_get_contents(__DIR__ . "/../../../data/dummy/users.json"), true)[array_rand(json_decode(file_get_contents(__DIR__ . "/../../../data/dummy/users.json"), true))];

    // 오늘 기준 경과일
    $elapsed = daysSince($userInfo["register_date"]);

    // API response : summary card (더미)
    // $dashboardSummary = json_decode(file_get_contents(__DIR__ . "/../../../data/dummy/dashboardSummary.json"), true);
    $dashboardSummary = [
        "todayPatient" => [
            "value" => random_int(0, 100),
            "rate" => random_int(-20, 20),
            "graph" => [
                "2025-07-01" => random_int(0, 100),
                "2025-07-02" => random_int(0, 100),
                "2025-07-03" => random_int(0, 100),
                "2025-07-04" => random_int(0, 100),
                "2025-07-05" => random_int(0, 100),
                "2025-07-06" => random_int(0, 100),
                "2025-07-07" => random_int(0, 100),
                "2025-07-08" => random_int(0, 100),
                "2025-07-09" => random_int(0, 100),
                "2025-07-10" => random_int(0, 100),
            ]
        ],
        "websiteVisitor" => [
            "value" => random_int(0, 5000),
            "rate" => random_int(-100, 100),
            "graph" => [
                "2025-07-01" => random_int(0, 5000),
                "2025-07-02" => random_int(0, 5000),
                "2025-07-03" => random_int(0, 5000),
                "2025-07-04" => random_int(0, 5000),
                "2025-07-05" => random_int(0, 5000),
                "2025-07-06" => random_int(0, 5000),
                "2025-07-07" => random_int(0, 5000),
                "2025-07-08" => random_int(0, 5000),
                "2025-07-09" => random_int(0, 5000),
                "2025-07-10" => random_int(0, 5000),
            ]
        ],
        "newPatient" => [
            "value" => random_int(0, 60),
            "rate" => random_int(-100, 100),
            "graph" => [
                "2025-07-01" => random_int(0, 100),
                "2025-07-02" => random_int(0, 100),
                "2025-07-03" => random_int(0, 100),
                "2025-07-04" => random_int(0, 100),
                "2025-07-05" => random_int(0, 100),
                "2025-07-06" => random_int(0, 100),
                "2025-07-07" => random_int(0, 100),
                "2025-07-08" => random_int(0, 100),
                "2025-07-09" => random_int(0, 100),
                "2025-07-10" => random_int(0, 100),
            ]
        ],
        "noShowRate" => [
            "value" => round(random_int(0, 1000) / 10, 1),
            "rate" => random_int(-100, 100),
            "graph" => [
                "2025-07-01" => random_int(0, 100),
                "2025-07-02" => random_int(0, 100),
                "2025-07-03" => random_int(0, 100),
                "2025-07-04" => random_int(0, 100),
                "2025-07-05" => random_int(0, 100),
                "2025-07-06" => random_int(0, 100),
                "2025-07-07" => random_int(0, 100),
                "2025-07-08" => random_int(0, 100),
                "2025-07-09" => random_int(0, 100),
                "2025-07-10" => random_int(0, 100),
            ]
        ],
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
                    반갑습니다, <span class="username"><?php echo $userInfo["name"]; ?></span>님
                </div>
                <p class="dashboard__header-subtitle">방문해주셔서 감사합니다.</p>
            </div>
            <div class="dashboard__date-box" data-fade="up">
                <div class="flex-container">
                    <div class="flex-left">
                        <div class="dashboard__date-label">와커스와 함께한지</div>
                        <div class="dashboard__date-elapse roulette-box">
                            <div class="elapse-days roulette-value"><?php echo $elapsed; ?></div>
                            <div class="elapse-days-unit roulette-unit">일</div>
                        </div>
                        <div class="dashboard__date-start">
                            <span class="start-date"><?php echo $userInfo["register_date"]; ?> </span> ~
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
                                    <span
                                        class="card__title-value roulette-value"><?php echo $dashboardSummary["todayPatient"]["value"]; ?></span>
                                    <span class="card__title-value-unit roulette-unit">명</span>
                                </div>
                                <div class="card__title-rate"
                                    data-rate="<?php echo $dashboardSummary["todayPatient"]["rate"] > 0 ? "increase" : "decrease"; ?>">
                                    <div class="card__title-rate-value-outer">
                                        <span
                                            class="card__title-rate-value"><?php echo $dashboardSummary["todayPatient"]["rate"]; ?>
                                        </span>
                                        <span class="card__title-rate-value-unit">%</span>
                                    </div>
                                    <span
                                        class="icon icon--<?php echo $dashboardSummary["todayPatient"]["rate"] > 0 ? "increase" : "decrease"; ?>"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card__chart">
                            <canvas id="todayPatientChart"></canvas>

                            <script>
                            const todayPatientChartCanvas = document.getElementById('todayPatientChart');

                            const todayPatientChartData = {
                                labels: <?php echo json_encode(array_keys($dashboardSummary["todayPatient"]["graph"])); ?>,
                                datasets: [{
                                    label: '예약 환자 수',
                                    backgroundColor: '<?php echo $dashboardSummary["todayPatient"]["rate"] > 0 ? "#05BA7B" : "#FB3636"; ?>',
                                    borderColor: '<?php echo $dashboardSummary["todayPatient"]["rate"] > 0 ? "#05BA7B" : "#FB3636"; ?>',
                                    fill: false,
                                    data: <?php echo json_encode(array_values($dashboardSummary["todayPatient"]["graph"])); ?>,
                                    pointStyle: false,
                                }, ]
                            };

                            const totalDuration = 600;
                            const delayBetweenPoints = totalDuration / todayPatientChartData.datasets[0].data.length;
                            const previousY = (ctx) => ctx.index === 0 ? ctx.chart.scales.y.getPixelForValue(100) : ctx
                                .chart.getDatasetMeta(ctx.datasetIndex).data[ctx.index - 1].getProps(['y'], true).y;

                            const todayPatientChartConfig = {
                                type: 'line',
                                data: todayPatientChartData,
                                options: {
                                    animation: {
                                        x: {
                                            type: 'number',
                                            easing: 'linear',
                                            duration: delayBetweenPoints,
                                            from: NaN, // the point is initially skipped
                                            delay(ctx) {
                                                if (ctx.type !== 'data' || ctx.xStarted) {
                                                    return 0;
                                                }
                                                ctx.xStarted = true;
                                                return ctx.index * delayBetweenPoints;
                                            }
                                        },
                                        y: {
                                            type: 'number',
                                            easing: 'linear',
                                            duration: delayBetweenPoints,
                                            from: previousY,
                                            delay(ctx) {
                                                if (ctx.type !== 'data' || ctx.yStarted) {
                                                    return 0;
                                                }
                                                ctx.yStarted = true;
                                                return ctx.index * delayBetweenPoints;
                                            }
                                        }
                                    },
                                    interaction: {
                                        intersect: false
                                    },
                                    borderJoinStyle: 'round',
                                    plugins: {
                                        title: {
                                            text: '오늘 예약 환자',
                                            display: false
                                        },
                                        legend: {
                                            display: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            display: false,
                                            type: 'time',
                                            time: {
                                                // Luxon format string
                                                // tooltipFormat: 'DD T'
                                            },
                                            title: {
                                                display: false,
                                                text: '날짜'
                                            }
                                        },
                                        y: {
                                            display: false,
                                            title: {
                                                display: false,
                                                text: '환자 수'
                                            }
                                        }
                                    },
                                },
                            };

                            const todayPatientChart = new Chart(todayPatientChartCanvas, todayPatientChartConfig);

                            // 전역 차트 저장소가 없으면 생성
                            if (!window.dashboardCharts) {
                                window.dashboardCharts = {};
                            }
                            window.dashboardCharts.todayPatient = todayPatientChart;
                            </script>
                        </div>
                    </div>

                    <div class="card card--summary" data-card-type="websiteVisitor" data-fade="right"
                        data-fade-delay="0.15">
                        <div class="card__title">
                            <div class="card__title-text">홈페이지 방문자</div>
                            <div class="card__title-value-box">
                                <div class="card__title-value-box-inner">
                                    <span
                                        class="card__title-value"><?php echo $dashboardSummary["websiteVisitor"]["value"]; ?></span>
                                    <span class="card__title-value-unit">명</span>
                                </div>
                                <div class="card__title-rate"
                                    data-rate="<?php echo $dashboardSummary["websiteVisitor"]["rate"] > 0 ? "increase" : "decrease"; ?>">
                                    <div class="card__title-rate-value-outer">
                                        <span
                                            class="card__title-rate-value"><?php echo $dashboardSummary["websiteVisitor"]["rate"]; ?>
                                        </span>
                                        <span class="card__title-rate-value-unit">%</span>
                                    </div>
                                    <span
                                        class="icon icon--<?php echo $dashboardSummary["websiteVisitor"]["rate"] > 0 ? "increase" : "decrease"; ?>"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card__chart">
                            <canvas id="websiteVisitorChart"></canvas>

                            <!-- <script>
                            const websiteVisitorChartCanvas = document.getElementById('websiteVisitorChart');

                            const websiteVisitorChartData = {
                                labels: <?php echo json_encode(array_keys($dashboardSummary["websiteVisitor"]["graph"])); ?>,
                                datasets: [{
                                    label: '예약 환자 수',
                                    backgroundColor: '<?php echo $dashboardSummary["websiteVisitor"]["rate"] > 0 ? "#05BA7B" : "#FB3636"; ?>',
                                    borderColor: '<?php echo $dashboardSummary["websiteVisitor"]["rate"] > 0 ? "#05BA7B" : "#FB3636"; ?>',
                                    fill: false,
                                    data: <?php echo json_encode(array_values($dashboardSummary["websiteVisitor"]["graph"])); ?>,
                                    pointStyle: false,
                                }, ]
                            };

                            const websiteVisitorChartConfig = {
                                type: 'line',
                                data: websiteVisitorChartData,
                                options: {
                                    borderJoinStyle: 'round',
                                    plugins: {
                                        title: {
                                            text: '오늘 예약 환자',
                                            display: false
                                        },
                                        legend: {
                                            display: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            display: false,
                                            type: 'time',
                                            time: {
                                                // Luxon format string
                                                tooltipFormat: 'DD T'
                                            },
                                            title: {
                                                display: false,
                                                text: '날짜'
                                            }
                                        },
                                        y: {
                                            display: false,
                                            title: {
                                                display: false,
                                                text: '환자 수'
                                            }
                                        }
                                    },
                                },
                            };

                            const websiteVisitorChart = new Chart(websiteVisitorChartCanvas, websiteVisitorChartConfig);

                            // 전역 차트 저장소가 없으면 생성
                            if (!window.dashboardCharts) {
                                window.dashboardCharts = {};
                            }
                            window.dashboardCharts.websiteVisitor = websiteVisitorChart;
                            </script> -->
                        </div>
                    </div>

                    <div class="card card--summary" data-card-type="newPatient" data-fade="right" data-fade-delay="0.3">
                        <div class="card__title">
                            <div class="card__title-text">신규 환자</div>
                            <div class="card__title-value-box">
                                <div class="card__title-value-box-inner">
                                    <span
                                        class="card__title-value"><?php echo $dashboardSummary["newPatient"]["value"]; ?></span>
                                    <span class="card__title-value-unit">명</span>
                                </div>
                                <div class="card__title-rate"
                                    data-rate="<?php echo $dashboardSummary["newPatient"]["rate"] > 0 ? "increase" : "decrease"; ?>">
                                    <div class="card__title-rate-value-outer">
                                        <span
                                            class="card__title-rate-value"><?php echo $dashboardSummary["newPatient"]["rate"]; ?>
                                        </span>
                                        <span class="card__title-rate-value-unit">%</span>
                                    </div>
                                    <span
                                        class="icon icon--<?php echo $dashboardSummary["newPatient"]["rate"] > 0 ? "increase" : "decrease"; ?>"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card__chart">
                            <canvas id="newPatientChart"></canvas>

                            <script>
                            const newPatientChartCanvas = document.getElementById('newPatientChart');

                            const newPatientChartData = {
                                labels: <?php echo json_encode(array_keys($dashboardSummary["newPatient"]["graph"])); ?>,
                                datasets: [{
                                    label: '예약 환자 수',
                                    backgroundColor: '<?php echo $dashboardSummary["newPatient"]["rate"] > 0 ? "#05BA7B" : "#FB3636"; ?>',
                                    borderColor: '<?php echo $dashboardSummary["newPatient"]["rate"] > 0 ? "#05BA7B" : "#FB3636"; ?>',
                                    fill: false,
                                    data: <?php echo json_encode(array_values($dashboardSummary["newPatient"]["graph"])); ?>,
                                    pointStyle: false,
                                }, ]
                            };

                            const newPatientChartConfig = {
                                type: 'line',
                                data: newPatientChartData,
                                options: {
                                    borderJoinStyle: 'round',
                                    plugins: {
                                        title: {
                                            text: '오늘 예약 환자',
                                            display: false
                                        },
                                        legend: {
                                            display: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            display: false,
                                            type: 'time',
                                            time: {
                                                // Luxon format string
                                                tooltipFormat: 'DD T'
                                            },
                                            title: {
                                                display: false,
                                                text: '날짜'
                                            }
                                        },
                                        y: {
                                            display: false,
                                            title: {
                                                display: false,
                                                text: '환자 수'
                                            }
                                        }
                                    },
                                },
                            };

                            const newPatientChart = new Chart(newPatientChartCanvas, newPatientChartConfig);

                            // 전역 차트 저장소가 없으면 생성
                            if (!window.dashboardCharts) {
                                window.dashboardCharts = {};
                            }
                            window.dashboardCharts.newPatient = newPatientChart;
                            </script>
                        </div>
                    </div>

                    <div class="card card--summary" data-card-type="noShowRate" data-fade="right"
                        data-fade-delay="0.45">
                        <div class="card__title">
                            <div class="card__title-text">미방문 비율</div>
                            <div class="card__title-value-box">
                                <div class="card__title-value-box-inner">
                                    <span
                                        class="card__title-value"><?php echo $dashboardSummary["noShowRate"]["value"]; ?></span>
                                    <span class="card__title-value-unit">%</span>
                                </div>
                                <div class="card__title-rate"
                                    data-rate="<?php echo $dashboardSummary["noShowRate"]["rate"] > 0 ? "increase" : "decrease"; ?>">
                                    <div class="card__title-rate-value-outer">
                                        <span
                                            class="card__title-rate-value"><?php echo $dashboardSummary["noShowRate"]["rate"]; ?>
                                        </span>
                                        <span class="card__title-rate-value-unit">%</span>
                                    </div>
                                    <span
                                        class="icon icon--<?php echo $dashboardSummary["noShowRate"]["rate"] > 0 ? "increase" : "decrease"; ?>"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card__chart">
                            <canvas id="noShowRateChart"></canvas>

                            <script>
                            const noShowRateChartCanvas = document.getElementById('noShowRateChart');

                            const noShowRateChartData = {
                                labels: <?php echo json_encode(array_keys($dashboardSummary["noShowRate"]["graph"])); ?>,
                                datasets: [{
                                    label: '예약 환자 수',
                                    backgroundColor: '<?php echo $dashboardSummary["noShowRate"]["rate"] > 0 ? "#05BA7B" : "#FB3636"; ?>',
                                    borderColor: '<?php echo $dashboardSummary["noShowRate"]["rate"] > 0 ? "#05BA7B" : "#FB3636"; ?>',
                                    fill: false,
                                    data: <?php echo json_encode(array_values($dashboardSummary["noShowRate"]["graph"])); ?>,
                                    pointStyle: false,
                                }, ]
                            };

                            const noShowRateChartConfig = {
                                type: 'line',
                                data: noShowRateChartData,
                                options: {
                                    borderJoinStyle: 'round',
                                    plugins: {
                                        title: {
                                            text: '오늘 예약 환자',
                                            display: false
                                        },
                                        legend: {
                                            display: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            display: false,
                                            type: 'time',
                                            time: {
                                                // Luxon format string
                                                tooltipFormat: 'DD T'
                                            },
                                            title: {
                                                display: false,
                                                text: '날짜'
                                            }
                                        },
                                        y: {
                                            display: false,
                                            title: {
                                                display: false,
                                                text: '환자 수'
                                            }
                                        }
                                    },
                                },
                            };

                            const noShowRateChart = new Chart(noShowRateChartCanvas, noShowRateChartConfig);

                            // 전역 차트 저장소가 없으면 생성
                            if (!window.dashboardCharts) {
                                window.dashboardCharts = {};
                            }
                            window.dashboardCharts.noShowRate = noShowRateChart;
                            </script>
                        </div>
                    </div>
                </div>

                <!-- 환자 유입 경로 -->
                <div class="l-grid__item">
                    <div class="l-title-box m-b-10">
                        <div class="l-title sm">세부차트를 확인해보세요</div>
                    </div>
                    <div class="card card--inflow" data-fade="right">
                        <div class="card__title m-b-20">
                            <div class="card__title-text">환자 유입 경로</div>
                        </div>
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
                        <div class="card__chart doughnut-chart">
                            <div class="chart-container">
                                <canvas id="inflowChart"></canvas>
                            </div>
                            <div id="inflowChartLegend" class="doughnut-chart-legend"></div>
                            <!-- 
                            <script>
                            const inflowChartCanvas = document.getElementById('inflowChart');

                            const inflowChartDataResponse =
                                <?php echo json_encode(json_decode(file_get_contents(__DIR__ . "/../../../data/dummy/dashboardInflow.json"), true)); ?>;
                            const inflowChartData = {
                                labels: Object.keys(inflowChartDataResponse),
                                datasets: [{
                                    label: '예약 환자 유입 경로',
                                    data: Object.values(inflowChartDataResponse),
                                }]
                            };

                            const doughnutChartColors = ['#926DFF', '#7FE47E', '#FF718B', '#FFC544', '#4587FF'];

                            const inflowChartConfig = {
                                type: 'doughnut',
                                data: inflowChartData,
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
                                plugins: [customTooltip(), renderInflowChartLegend('#inflowChartLegend')]
                            };

                            const inflowChart = new Chart(inflowChartCanvas, inflowChartConfig);

                            // 전역 차트 저장소가 없으면 생성
                            if (!window.dashboardCharts) {
                                window.dashboardCharts = {};
                            }
                            window.dashboardCharts.inflow = inflowChart;



                            function renderInflowChartLegend(containerSelector) {
                                return {
                                    id: 'inflowChartLegend',
                                    afterUpdate(inflowChart) {
                                        const container = document.querySelector(containerSelector);
                                        container.innerHTML = ''; // 초기화

                                        inflowChart.data.labels.forEach((label, i) => {
                                            const color = doughnutChartColors[i];
                                            const value = inflowChart.data.datasets[0].data[i];

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
                                                inflowChart.toggleDataVisibility(i);
                                                inflowChart.update();
                                            };
                                            container.appendChild(item);
                                        });
                                    }
                                };
                            }

                            function customTooltip() {
                                return {
                                    id: 'customTooltip',
                                    afterDraw(inflowChart) {
                                        const tooltipEl = getOrCreateTooltip(inflowChart);
                                        const tooltipModel = inflowChart.tooltip;

                                        // 보이지 않을 땐 숨기기
                                        if (tooltipModel.opacity === 0) {
                                            tooltipEl.style.opacity = 0;
                                            return;
                                        }

                                        // 텍스트 세팅
                                        const dataIndex = tooltipModel.dataPoints[0].dataIndex;
                                        const value = inflowChart.data.datasets[0].data[dataIndex];
                                        tooltipEl.innerHTML = `<div class="tooltip-box">${value}건</div>`;

                                        // 위치 계산
                                        const {
                                            canvas
                                        } = inflowChart;
                                        const position = canvas.getBoundingClientRect();
                                        const caret = tooltipModel.caretY || 0;

                                        tooltipEl.style.opacity = 1;
                                        tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel
                                            .caretX + 'px';
                                        tooltipEl.style.top = position.top + window.pageYOffset + caret - tooltipEl
                                            .offsetHeight - 10 + 'px';
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
                            </script> -->
                        </div>
                    </div>
                </div>

                <!-- 재방문률 -->
                <div class="l-grid__item">
                    <div class="card card--revisiting-rate" data-fade="right">
                        <div class="card__title m-b-20">
                            <div class="card__title-text">재방문율</div>
                        </div>
                        <div class="card__chart">
                            <div class="chart-container">
                                <canvas id="revisitingRateChart"></canvas>
                            </div>

                            <!-- <script>
                            const revisitingRateChartCanvas = document.getElementById('revisitingRateChart');

                            const revisitingRateChartDataResponse =
                                <?php echo json_encode(json_decode(file_get_contents(__DIR__ . "/../../../data/dummy/dashboardRevisitingRate.json"), true)); ?>;

                            // 막대 차트용 색상 배열
                            const barChartColors = ['#4587FF', '#7FE47E'];

                            const revisitingRateChartData = {
                                labels: Object.keys(revisitingRateChartDataResponse[0].graph), // 월별 라벨
                                datasets: revisitingRateChartDataResponse.map((item, index) => ({
                                    label: item.label,
                                    data: Object.values(item.graph),
                                    backgroundColor: barChartColors[index],
                                    borderColor: barChartColors[index],
                                    borderWidth: 0,
                                    borderRadius: 8,
                                }))
                            };

                            const revisitingRateChartConfig = {
                                type: 'bar',
                                data: revisitingRateChartData,
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                        },
                                        title: {
                                            display: false,
                                            text: '재방문율'
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            color: '#615E83',
                                            grid: {
                                                color: '#E5E5EF',
                                            }
                                        }
                                    }
                                },
                            };

                            const revisitingRateChart = new Chart(revisitingRateChartCanvas, revisitingRateChartConfig);

                            // 전역 차트 저장소가 없으면 생성
                            if (!window.dashboardCharts) {
                                window.dashboardCharts = {};
                            }
                            window.dashboardCharts.revisitingRate = revisitingRateChart;
                            </script> -->
                        </div>
                    </div>
                </div>


                <!-- 미방문(No-show) 비율 추이 -->
                <div class="l-grid__item">
                    <div class="card card--noshow-rate" data-fade="right">
                        <div class="card__title m-b-20">
                            <div class="card__title-text">미방문(No-show) 비율 추이</div>
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
import ChartManager from '/assets/js/components/chart/chartManager.js';
import {
    ChartUtils
} from '/assets/js/components/chart/chartUtils.js';
import DoughnutChart from '/assets/js/components/chart/doughnutChart.js';
import BarChart from '/assets/js/components/chart/barChart.js';


// 차트 인스턴스들을 저장할 객체
const dashboardCharts = {};


// 페이지 로드 시 차트 초기화
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();

});

/**
 * 모든 차트 초기화
 */
async function initializeCharts() {

    const inflowData = await fetch('/data/dummy/dashboardInflow.json')
        .then(response => response.json())
        .then(data => {
            return data;
        }).catch(error => {
            console.error('Error fetching inflow data:', error);
            return {};
        });

    dashboardCharts.inflow = new DoughnutChart('inflowChart', inflowData, {}, '#inflowChartLegend');


    const revisitingRateData = await fetch('/data/dummy/dashboardRevisitingRate.json')
        .then(response => response.json())
        .then(data => {
            return data;
        }).catch(error => {
            console.error('Error fetching revisiting rate data:', error);
            return {};
        });

    console.log(revisitingRateData);



    dashboardCharts.revisitingRate = new BarChart('revisitingRateChart', datasss, {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            x: {
                stacked: true,
            },
            y: {
                stacked: true
            }
        }
    });

}

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



<!-- <script>
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

    const charts = window.dashboardCharts;

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
</script> -->

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