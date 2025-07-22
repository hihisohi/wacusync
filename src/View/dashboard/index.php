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

    // API response : 유저정보 (임시)
    $userInfo = [
        "name" => "와커스",
        "register_date" => "2019.11.01",
    ];

    // 오늘 기준 경과일
    $elapsed = daysSince($userInfo["register_date"]);

    // API response : summary card (임시)
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


<!-- chart.js 스크립트 -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js">
</script>


<div class="dashboard">
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
            <div class="dashboard__date-box">
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
                        <a href="" class="btn dashboard__link">
                            <div class="icon icon--go-link">
                                <span class="blind">어디로 이동하나용</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="l-inner">
        <div class="dashboard__content">
            <div class="l-title-box m-b-30">
                <div class="l-title">대시보드</div>
                <div class="custom-select" id="dashboardSummaryCardFilter">
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
                        <div class="custom-select__option" data-value="yearly">연간</div>
                    </div>
                </div>
            </div>

            <div class="dashboard-grid">
                <div class="card card--summary" data-card-type="todayPatient">
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

                        const todayPatientChartConfig = {
                            type: 'line',
                            data: todayPatientChartData,
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

                        const todayPatientChart = new Chart(todayPatientChartCanvas, todayPatientChartConfig);

                        // 전역 차트 저장소가 없으면 생성
                        if (!window.dashboardCharts) {
                            window.dashboardCharts = {};
                        }
                        window.dashboardCharts.todayPatient = todayPatientChart;
                        </script>
                    </div>
                </div>

                <div class="card card--summary" data-card-type="websiteVisitor">
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

                        <script>
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
                        </script>
                    </div>
                </div>

                <div class="card card--summary" data-card-type="newPatient">
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

                <div class="card card--summary" data-card-type="noShowRate">
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

    // API response : 기간별 업데이트 데이터
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



function updateCardData(period) {

}
</script>