import { statsAPI } from "../../api/statsApi.js";
import chartManager from "../../components/chart/chartManager.js";
import DoughnutChart from "../../components/chart/doughnutChart.js";
import BarChart from "../../components/chart/barChart.js";

document.addEventListener("DOMContentLoaded", function () {
  const statsCharts = {};

  initStatsDemographics(statsCharts);
  initStatsSales(statsCharts);
  initStatsKeyword(statsCharts);
});

async function initStatsDemographics(statsCharts) {
  const response = await statsAPI.getDemographics();

  if (response.success) {
    const demographicsData = response.data;

    statsCharts.age = new DoughnutChart("ageChart", demographicsData.age.graph, {}, "#ageChartLegend");
    statsCharts.gender = new DoughnutChart("genderChart", demographicsData.gender.graph, {}, "#genderChartLegend");
  } else {
    console.error("demographics 에러 컴포넌트 show");
    return;
  }
}

async function initStatsSales(statsCharts) {
  const response = await statsAPI.getSales();

  if (response.success) {
    const salesData = response.data;

    const formattedChartData = window.chartManager.formatChartData(salesData.graph, "bar");

    console.log(formattedChartData);

    statsCharts.sales = new BarChart("salesChart", formattedChartData, {
      indexAxis: "y",
      elements: {
        bar: {
          borderRadius: 4,
          borderWidth: 20,
        },
      },
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          enabled: false, // 툴팁 비활성화
        },
      },
      scales: {
        x: {
          beginAtZero: true,
          max: Math.max(...Object.values(salesData.graph)),
          ticks: {
            stepSize: Math.max(...Object.values(salesData.graph)) / 4,
          },
          grid: {
            tickBorderDash: [5, 5],
            tickBorderDashOffset: 5,
            color: "#E5E5EF",
            offset: true,
            lineWidth: 1.5,
          },
        },
        y: { grid: { display: false } }, // X축 그리드는 숨김 예시
      },
    });
  } else {
    console.error("sales 에러 컴포넌트 show");
    return;
  }
}

async function initStatsKeyword(statsCharts) {
  const response = await statsAPI.getKeyword();

  if (response.success) {
    const keywordData = response.data;

    statsCharts.keyword = new DoughnutChart("keywordChart", keywordData.platform.graph, {}, "#keywordChartLegend");

    const keywordTable = document.getElementById("keywordTable");

    const keywordTotalCount = Object.values(keywordData.keyword.graph).reduce((acc, curr) => acc + curr, 0);

    const keywordTableItems = Object.entries(keywordData.keyword.graph).map(([keyword, value]) => {
      return `
          <div class="card__table-item">
            <div class="card__table-item-title">${keyword}</div>
            <div class="card__table-item-value">${((value / keywordTotalCount) * 100).toFixed(2)}%</div>
          </div>
      `;
    });

    keywordTable.innerHTML = keywordTableItems.join("");
  } else {
    console.error("keyword 에러 컴포넌트 show");
    return;
  }
}
