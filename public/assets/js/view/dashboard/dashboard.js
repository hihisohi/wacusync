import { userAPI } from "../../api/user.js";
import LineChart from "../../components/chart/lineChart.js";
import {
  createRouletteNumber,
  daysSince,
  formatDate,
} from "../../utils/utils.js";

document.addEventListener("DOMContentLoaded", function () {
  const dashboardCharts = {};

  initDashboardHeader();

  initDashboardSummary(dashboardCharts);
});

async function initDashboardHeader() {
  const response = await userAPI.getUserInfo({
    token: localStorage.getItem("token"),
  });

  const { username, registeredAt } = response.data;

  const usernameEl = document.querySelector(
    ".dashboard__header-title .username"
  );

  const elapseDaysEl = document.querySelector(
    ".dashboard__date-elapse .elapse-days"
  );

  const startDateEl = document.querySelector(
    ".dashboard__date-start .start-date"
  );

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
  const dashboardSummaryData = await fetch("/data/dummy/dashboard/summary.json")
    .then((response) => response.json())
    .then((data) => {
      return data;
    })
    .catch((error) => {
      console.error("Error fetching dashboard summary data:", error);
      return {};
    });

  Object.keys(dashboardSummaryData).forEach((chartKey) => {
    const titleValueEl = document.querySelector(
      `.card--summary[data-card-type="${chartKey}"] .card__title-value`
    );

    const titleRateEl = document.querySelector(
      `.card--summary[data-card-type="${chartKey}"] .card__title-rate`
    );

    const titleRateValueEl = titleRateEl.querySelector(
      ".card__title-rate-value"
    );

    const titleRateValueIconEl = titleRateEl.querySelector(".icon");

    titleValueEl.textContent = dashboardSummaryData[chartKey].value;

    titleRateEl.dataset.rate =
      dashboardSummaryData[chartKey].rate > 0 ? "increase" : "decrease";
    titleRateValueEl.textContent = dashboardSummaryData[chartKey].rate;
    titleRateValueIconEl.classList.add(
      dashboardSummaryData[chartKey].rate > 0
        ? "icon--increase"
        : "icon--decrease"
    );

    const totalDuration = 600;

    const delayBetweenPoints =
      totalDuration / Object.keys(dashboardSummaryData[chartKey].graph).length;

    const previousY = (ctx) =>
      ctx.index === 0
        ? ctx.chart.scales.y.getPixelForValue(100)
        : ctx.chart
            .getDatasetMeta(ctx.datasetIndex)
            .data[ctx.index - 1].getProps(["y"], true).y;

    const chartData = {
      labels: Object.keys(dashboardSummaryData[chartKey].graph),
      datasets: [
        {
          label: chartKey,
          data: Object.values(dashboardSummaryData[chartKey].graph),
          // Dataset 속성들을 여기에 정의
          backgroundColor:
            dashboardSummaryData[chartKey].rate > 0 ? "#05BA7B" : "#FB3636",
          borderColor:
            dashboardSummaryData[chartKey].rate > 0 ? "#05BA7B" : "#FB3636",
          fill: false,
          pointStyle: (ctx) => {
            const lastIndex = ctx.dataset.data.length - 1;
            return ctx.dataIndex === lastIndex ? "circle" : false;
          },
          pointRadius: (ctx) =>
            ctx.dataIndex === ctx.dataset.data.length - 1 ? 6 : 0,
          pointBorderColor: "#ffffff",
          pointBorderWidth: 1,
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
        title: {
          text: chartKey,
          display: false,
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

    dashboardCharts[chartKey] = new LineChart(
      `${chartKey}Chart`,
      chartData,
      chartOptions
    );
  });

  // 부드러운 깜빡임 효과 추가
  let startTime = 0;
  let animationRunning = false;

  function animateSmoothBlink(timestamp) {
    if (!startTime) startTime = timestamp;

    // 1.4초 주기로 계산 (0.7초 페이드인 + 0.7초 페이드아웃)
    const elapsed = (timestamp - startTime) % 1400;

    let opacity;
    if (elapsed < 700) {
      // 첫 0.7초: 페이드 인 (0 → 1)
      opacity = elapsed / 700;
    } else {
      // 다음 0.7초: 페이드 아웃 (1 → 0)
      opacity = 1 - (elapsed - 700) / 700;
    }

    // 포인트 테두리 투명도 적용
    const chart = dashboardCharts.summary.getChart();
    if (chart && chart.data.datasets[0]) {
      chart.data.datasets[0].pointBorderColor = `rgba(255, 255, 255, ${opacity})`;
      chart.update("none");
    }

    if (animationRunning) {
      requestAnimationFrame(animateSmoothBlink);
    }
  }

  // 페이지 가시성에 따른 최적화
  function startSmoothBlink() {
    if (!animationRunning) {
      animationRunning = true;
      startTime = 0;
      requestAnimationFrame(animateSmoothBlink);
    }
  }

  function stopSmoothBlink() {
    animationRunning = false;
  }

  document.addEventListener("visibilitychange", () => {
    if (document.hidden) {
      stopSmoothBlink();
    } else {
      startSmoothBlink();
    }
  });

  // 초기 시작
  startSmoothBlink();
}
