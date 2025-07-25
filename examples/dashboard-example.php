<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>리팩토링된 대시보드 예제</title>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- 커스텀 차트 클래스들 -->
    <script src="../public/assets/js/components/chart/chartManager.js"></script>
    <script src="../public/assets/js/components/chart/doughnutChart.js"></script>

    <style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card h3 {
        margin: 0 0 20px 0;
        color: #333;
    }

    .chart-container {
        position: relative;
        height: 300px;
    }

    .doughnut-chart-legend {
        margin-top: 20px;
    }

    .legend__item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        cursor: pointer;
    }

    .legend__item:hover {
        background-color: #f5f5f5;
    }

    .legend__item-label {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .label__color {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .value__text {
        font-weight: bold;
        color: #333;
    }

    /* 커스텀 툴팁 스타일 */
    #chartjs-tooltip .tooltip-box {
        background: rgba(0, 0, 0, 0.8);
        color: #fff;
        padding: 0.4em 0.6em;
        border-radius: 4px;
        white-space: nowrap;
        font-size: 0.8em;
        transform: translateX(-50%);
    }

    .period-selector {
        margin-bottom: 20px;
    }

    .btn {
        padding: 8px 16px;
        margin: 0 4px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: white;
        cursor: pointer;
    }

    .btn.active {
        background: #4587FF;
        color: white;
        border-color: #4587FF;
    }
    </style>
</head>

<body>
    <div class="dashboard-grid">
        <!-- 환자 유입 경로 도넛 차트 -->
        <div class="card">
            <h3>환자 유입 경로</h3>
            <div class="period-selector">
                <button class="btn active" onclick="updateInflowChart('daily')">일간</button>
                <button class="btn" onclick="updateInflowChart('weekly')">주간</button>
                <button class="btn" onclick="updateInflowChart('monthly')">월간</button>
            </div>
            <div class="chart-container">
                <canvas id="inflowChart"></canvas>
            </div>
            <div id="inflowChartLegend" class="doughnut-chart-legend"></div>
        </div>

        <!-- 진료과별 환자 분포 도넛 차트 -->
        <div class="card">
            <h3>진료과별 환자 분포</h3>
            <div class="chart-container">
                <canvas id="departmentChart"></canvas>
            </div>
            <div id="departmentChartLegend" class="doughnut-chart-legend"></div>
        </div>

        <!-- 연령대별 환자 분포 도넛 차트 -->
        <div class="card">
            <h3>연령대별 환자 분포</h3>
            <div class="chart-container">
                <canvas id="ageChart"></canvas>
            </div>
            <div id="ageChartLegend" class="doughnut-chart-legend"></div>
        </div>
    </div>

    <script type="module">
    import ChartManager from '/assets/js/components/chart/chartManager.js';
    import DoughnutChart from '/assets/js/components/chart/doughnutChart.js';


    // 샘플 데이터 (실제로는 PHP에서 API 데이터를 가져옴)
    const sampleData = {
        inflow: {
            "온라인 예약": 45,
            "전화 예약": 30,
            "직접 방문": 15,
            "추천": 10
        },
        department: {
            "내과": 35,
            "외과": 25,
            "소아과": 20,
            "정형외과": 12,
            "기타": 8
        },
        age: {
            "20대": 18,
            "30대": 28,
            "40대": 25,
            "50대": 20,
            "60대 이상": 9
        }
    };

    // 차트 인스턴스들을 저장할 객체
    const dashboardCharts = {};

    // 페이지 로드 시 차트 초기화
    document.addEventListener('DOMContentLoaded', function() {
        initializeCharts();
    });

    /**
     * 모든 차트 초기화
     */
    function initializeCharts() {
        // 환자 유입 경로 도넛 차트
        dashboardCharts.inflow = new DoughnutChart('inflowChart', '#inflowChartLegend');
        dashboardCharts.inflow.create(sampleData.inflow, '환자 유입 경로');

        // 진료과별 환자 분포 도넛 차트
        dashboardCharts.department = new DoughnutChart('departmentChart', '#departmentChartLegend');
        dashboardCharts.department.create(sampleData.department, '진료과별 분포');

        // 연령대별 환자 분포 도넛 차트  
        dashboardCharts.age = new DoughnutChart('ageChart', '#ageChartLegend');
        dashboardCharts.age.create(sampleData.age, '연령대별 분포');
    }

    /**
     * 환자 유입 경로 차트 업데이트 (기간별)
     */
    function updateInflowChart(period) {
        // 버튼 활성화 상태 변경
        document.querySelectorAll('.period-selector .btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');

        // 실제로는 API 호출해서 데이터 가져옴
        const newData = generateRandomData();

        // 차트 업데이트
        dashboardCharts.inflow.update(newData);

        console.log(`${period} 데이터로 차트 업데이트 완료`);
    }

    /**
     * 랜덤 데이터 생성 (API 응답 시뮬레이션)
     */
    function generateRandomData() {
        return {
            "온라인 예약": Math.floor(Math.random() * 50) + 20,
            "전화 예약": Math.floor(Math.random() * 40) + 15,
            "직접 방문": Math.floor(Math.random() * 30) + 10,
            "추천": Math.floor(Math.random() * 20) + 5
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

    // 페이지 언로드 시 차트 정리
    window.addEventListener('beforeunload', destroyAllCharts);
    </script>
</body>

</html>