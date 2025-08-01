import { dashboardAPI } from "../../api/dashboardApi.js";
import { userAPI } from "../../api/userApi.js";
import LineChart from "../../components/chart/lineChart.js";
import DoughnutChart from "../../components/chart/doughnutChart.js";
import BarChart from "../../components/chart/barChart.js";
import { createRouletteNumber, daysSince, formatDate } from "../../utils/utils.js";

document.addEventListener("DOMContentLoaded", function () {
  const dashboardCharts = {};

  initDashboardHeader();
  initDashboardSummary(dashboardCharts);
  initDashboardInflow(dashboardCharts);
  initDashboardRevisitingRate(dashboardCharts);
  initDashboardNoShowRate(dashboardCharts);
});

// 성능 최적화: 전역 애니메이션 관리
let summaryChartAnimationRunning = false;
let summaryChartStartTime = 0;
const summaryCharts = new Set(); // tick 깜빡임 애니메이션을 위해 summaryCard chart 저장

function animateSmoothBlink(timestamp) {
  if (!summaryChartStartTime) summaryChartStartTime = timestamp;

  // 1.4초 주기로 계산 (0.7초 페이드인 + 0.7초 페이드아웃)
  const elapsed = (timestamp - summaryChartStartTime) % 1400;

  let opacity;
  if (elapsed < 700) {
    // 첫 0.7초: 페이드 인 (0 → 1)
    opacity = elapsed / 700;
  } else {
    // 다음 0.7초: 페이드 아웃 (1 → 0)
    opacity = 1 - (elapsed - 700) / 700;
  }

  // 모든 활성화된 차트에 애니메이션 적용
  summaryCharts.forEach((chartKey) => {
    const chart = window.dashboardCharts?.[chartKey]?.getChart();

    if (chart && chart.data.datasets[0]) {
      chart.data.datasets[0].pointBorderColor = `rgba(255, 255, 255, ${opacity})`;
      chart.update("none");
    }
  });

  if (summaryChartAnimationRunning) {
    requestAnimationFrame(animateSmoothBlink);
  }
}

function startSummaryChartAnimation() {
  if (!summaryChartAnimationRunning && summaryCharts.size > 0) {
    summaryChartAnimationRunning = true;
    summaryChartStartTime = 0;
    requestAnimationFrame(animateSmoothBlink);
  }
}

function stopSummaryChartAnimation() {
  summaryChartAnimationRunning = false;
}

// 단일 이벤트 리스너로 모든 차트 관리
document.addEventListener("visibilitychange", () => {
  if (document.hidden) {
    stopSummaryChartAnimation();
  } else {
    startSummaryChartAnimation();
  }
});

async function initDashboardHeader() {
  const response = await userAPI.getUserInfo({
    token: localStorage.getItem("token"),
  });

  const { username, registeredAt } = response.data;

  const usernameEl = document.querySelector(".dashboard__header-title .username");

  const elapseDaysEl = document.querySelector(".dashboard__date-elapse .elapse-days");

  const startDateEl = document.querySelector(".dashboard__date-start .start-date");

  if (!usernameEl) {
    console.error("username 요소를 찾을 수 없습니다.");
    return;
  }

  if (!elapseDaysEl) {
    console.error("elapse-days 요소를 찾을 수 없습니다.");
    return;
  }

  if (!startDateEl) {
    console.error("start-date 요소를 찾을 수 없습니다.");
    return;
  }

  usernameEl.textContent = username;
  startDateEl.textContent = formatDate(registeredAt);
  createRouletteNumber(elapseDaysEl, daysSince(registeredAt));
}

async function initDashboardSummary(dashboardCharts) {
  const response = await dashboardAPI.getSummary();

  if (response.success) {
    const summaryData = response.data;

    const chartKeys = Object.keys(summaryData);

    chartKeys.forEach((chartKey) => {
      const titleValueEl = document.querySelector(`.card--summary[data-card-type="${chartKey}"] .card__title-value`);

      const titleRateEl = document.querySelector(`.card--summary[data-card-type="${chartKey}"] .card__title-rate`);

      const titleRateValueEl = titleRateEl.querySelector(".card__title-rate-value");

      const titleRateValueIconEl = titleRateEl.querySelector(".icon");

      titleValueEl.textContent = summaryData[chartKey].value;

      titleRateEl.dataset.rate = summaryData[chartKey].rate > 0 ? "increase" : "decrease";
      titleRateValueEl.textContent = summaryData[chartKey].rate;
      titleRateValueIconEl.classList.add(summaryData[chartKey].rate > 0 ? "icon--increase" : "icon--decrease");

      const totalDuration = 600;

      const delayBetweenPoints = totalDuration / Object.keys(summaryData[chartKey].graph).length;

      const previousY = (ctx) =>
        ctx.index === 0
          ? ctx.chart.scales.y.getPixelForValue(100)
          : ctx.chart.getDatasetMeta(ctx.datasetIndex).data[ctx.index - 1].getProps(["y"], true).y;

      const chartData = {
        labels: Object.keys(summaryData[chartKey].graph),
        datasets: [
          {
            label: chartKey,
            data: Object.values(summaryData[chartKey].graph),
            // Dataset 속성들을 여기에 정의
            backgroundColor: summaryData[chartKey].rate > 0 ? "#05BA7B" : "#FB3636",
            borderColor: summaryData[chartKey].rate > 0 ? "#05BA7B" : "#FB3636",
            fill: false,
            pointStyle: (ctx) => {
              const lastIndex = ctx.dataset.data.length - 1;
              return ctx.dataIndex === lastIndex ? "circle" : false;
            },
            pointRadius: (ctx) => (ctx.dataIndex === ctx.dataset.data.length - 1 ? 6 : 0),
            pointBorderColor: "#ffffff",
            pointBorderWidth: 1,
            pointHoverRadius: 6,
            borderJoinStyle: "round",
          },
        ],
      };

      // Chart Options (dataset 속성이 아닌 것들만)
      const chartOptions = {
        animation: {
          x: {
            type: "number",
            easing: "linear",
            duration: delayBetweenPoints,
            from: NaN,
            delay(ctx) {
              if (ctx.type !== "data" || ctx.xStarted) {
                return 0;
              }
              ctx.xStarted = true;
              return ctx.index * delayBetweenPoints;
            },
          },
          y: {
            type: "number",
            easing: "linear",
            duration: delayBetweenPoints,
            from: previousY,
            delay(ctx) {
              if (ctx.type !== "data" || ctx.yStarted) {
                return 0;
              }
              ctx.yStarted = true;
              return ctx.index * delayBetweenPoints;
            },
          },
        },
        interaction: {
          intersect: false,
        },
        plugins: {
          tooltip: {
            enabled: false,
          },
          legend: {
            display: false,
          },
        },
        scales: {
          x: {
            display: false,
            type: "time",
            time: {
              // Luxon format string
              // tooltipFormat: 'DD T'
            },
            title: {
              display: false,
              text: "날짜",
            },
          },
          y: {
            display: false,
            title: {
              display: false,
              text: "환자 수",
            },
          },
        },
      };

      dashboardCharts[chartKey] = new LineChart(`${chartKey}SummaryChart`, chartData, chartOptions);

      // 차트를 활성화된 차트 목록에 추가
      summaryCharts.add(chartKey);
    });
    console.log(dashboardCharts.todayPatient);

    // dashboardCharts를 전역으로 할당 (애니메이션에서 접근 가능하도록)
    window.dashboardCharts = dashboardCharts;

    // 모든 차트가 완전히 초기화될 때까지 약간의 지연 후 애니메이션 시작
    setTimeout(() => {
      startSummaryChartAnimation();
    }, 100);
  } else {
    console.error("summary 에러 컴포넌트 show");
    return;
  }
}

async function initDashboardInflow(dashboardCharts) {
  const response = await dashboardAPI.getInflow();

  if (response.success) {
    const inflowData = response.data;

    const inflowCardEl = document.querySelector(".card--inflow");

    if (!inflowCardEl) {
      console.error("inflowCardEl 요소를 찾을 수 없습니다.");
      return;
    }

    const inflowStartEl = inflowCardEl.querySelector(".card__period-start-value");
    const inflowEndEl = inflowCardEl.querySelector(".card__period-end-value");

    inflowStartEl.textContent = inflowData.startDate;
    inflowEndEl.textContent = inflowData.endDate;

    dashboardCharts.inflow = new DoughnutChart("inflowChart", inflowData.graph, {}, "#inflowChartLegend");
  } else {
    console.error("inflow 에러 컴포넌트 show");
    return;
  }
}

async function initDashboardRevisitingRate(dashboardCharts) {
  const response = await dashboardAPI.getRevisitingRate();

  if (response.success) {
    const revisitingRateData = response.data;

    const revisitingRateCardEl = document.querySelector(".card--revisiting-rate");

    if (!revisitingRateCardEl) {
      console.error("revisitingRateCardEl 요소를 찾을 수 없습니다.");
      return;
    }

    const revisitingRateStartEl = revisitingRateCardEl.querySelector(".card__period-start-value");
    const revisitingRateEndEl = revisitingRateCardEl.querySelector(".card__period-end-value");

    revisitingRateStartEl.textContent = revisitingRateData.startDate;
    revisitingRateEndEl.textContent = revisitingRateData.endDate;

    // 기존 JSON 구조를 Chart.js stack 차트 형식으로 변환
    const months = Object.keys(revisitingRateData.revisitCount.graph);
    const revisitData = Object.values(revisitingRateData.revisitCount.graph);
    const newVisitData = Object.values(revisitingRateData.newVisitCount.graph);

    const chartData = {
      labels: months,
      datasets: [
        {
          label: "재방문자",
          data: revisitData,
          backgroundColor: "#4587FF",
          borderColor: "#4587FF",
          borderWidth: 0,
          borderRadius: 8,
        },
        {
          label: "신규방문자",
          data: newVisitData,
          backgroundColor: "#7FE47E",
          borderColor: "#7FE47E",
          borderWidth: 0,
          borderRadius: 8,
        },
      ],
    };

    dashboardCharts.revisitingRate = new BarChart("revisitingRateChart", chartData, {
      responsive: true,
      plugins: {
        legend: {
          position: "top",
        },
        title: {
          display: false,
          text: "재방문율",
        },
      },
      scales: {
        x: {
          stacked: true,
          color: "#615E83",
          grid: {
            color: "#E5E5EF",
          },
        },
        y: {
          stacked: true,
          beginAtZero: true,
          color: "#615E83",
          grid: {
            color: "#E5E5EF",
          },
        },
      },
    });
  } else {
    console.error("revisitingRate 에러 컴포넌트 show");
    return;
  }
}

async function initDashboardNoShowRate(dashboardCharts) {
  const response = await dashboardAPI.getNoShowRate();

  if (response.success) {
    const noShowRateData = response.data;

    const noShowRateCardEl = document.querySelector(".card--no-show-rate");

    if (!noShowRateCardEl) {
      console.error("noShowRateCardEl 요소를 찾을 수 없습니다.");
      return;
    }

    const noShowRateStartEl = noShowRateCardEl.querySelector(".card__period-start-value");
    const noShowRateEndEl = noShowRateCardEl.querySelector(".card__period-end-value");

    noShowRateStartEl.textContent = noShowRateData.startDate;
    noShowRateEndEl.textContent = noShowRateData.endDate;

    const chartData = {
      labels: Object.keys(noShowRateData.graph),
      datasets: [
        {
          label: "미방문(No-show) 비율 추이",
          data: Object.values(noShowRateData.graph),
          // Dataset 속성들을 여기에 정의
          backgroundColor: "#FF718B",
          borderColor: "#FF718B",
          fill: false,
          pointStyle: (ctx) => {
            const lastIndex = ctx.dataset.data.length - 1;
            return ctx.dataIndex === lastIndex ? "circle" : false;
          },
          pointRadius: (ctx) => (ctx.dataIndex === ctx.dataset.data.length - 1 ? 6 : 0),
          pointBorderColor: "#ffffff",
          pointBorderWidth: 1,
          pointHoverRadius: 6,
          borderJoinStyle: "round",
        },
      ],
    };

    dashboardCharts.noShowRate = new LineChart("noShowRateChart", chartData);
  } else {
    console.error("noShowRate 에러 컴포넌트 show");
    return;
  }
}
