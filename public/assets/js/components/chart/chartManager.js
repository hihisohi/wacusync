/**
 * Chart.js 기반 차트 관리 클래스
 * 차트 생성, 업데이트, 관리를 위한 공통 기능 제공
 */
export default class ChartManager {
  constructor() {
    this.charts = {}; // 생성된 차트들을 저장하는 전역 저장소
    this.defaultColors = {
      doughnut: ["#926DFF", "#7FE47E", "#FF718B", "#FFC544", "#4587FF"],
      bar: ["#4587FF", "#7FE47E"],
      line: {
        positive: "#05BA7B",
        negative: "#FB3636",
        default: "#4587FF",
      },
    };
  }

  /**
   * 기본 차트 옵션 생성
   * @param {string} type - 차트 타입 (doughnut, bar, line)
   * @param {Object} customOptions - 커스텀 옵션
   * @returns {Object} 차트 옵션 객체
   */
  getDefaultOptions(type, customOptions = {}) {
    const baseOptions = {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          enabled: false,
        },
      },
    };

    switch (type) {
      case "doughnut":
        return {
          ...baseOptions,
          cutout: "65%",
          borderRadius: 10,
          borderWidth: 0,
          onHover: (evt, items) => {
            evt.native.target.style.cursor = items.length ? "pointer" : "";
          },
          ...customOptions,
        };

      case "line":
        return {
          ...baseOptions,
          scales: {
            x: {
              display: true,
              grid: {
                display: false,
              },
            },
            y: {
              beginAtZero: true,
              grid: {
                color: "#E5E5EF",
              },
            },
          },
          elements: {
            line: {
              tension: 0.4,
              borderWidth: 2,
            },
            point: {
              radius: 4,
              hoverRadius: 6,
            },
          },
          ...customOptions,
        };

      case "bar":
        return {
          ...baseOptions,
          scales: {
            y: {
              beginAtZero: true,
              color: "#615E83",
              grid: {
                color: "#E5E5EF",
              },
            },
          },
          plugins: {
            ...baseOptions.plugins,
            legend: {
              display: true,
              position: "top",
            },
          },
          ...customOptions,
        };

      default:
        return baseOptions;
    }
  }

  /**
   * 차트 데이터 형식 변환
   * @param {Object} rawData - API에서 받은 원시 데이터
   * @param {string} type - 차트 타입
   * @param {string} label - 데이터셋 라벨
   * @returns {Object} Chart.js 형식의 데이터
   */
  formatChartData(rawData, type, label = "") {
    if (type === "doughnut") {
      return {
        labels: Object.keys(rawData),
        datasets: [
          {
            label: label,
            data: Object.values(rawData),
            backgroundColor: this.defaultColors.doughnut,
            borderWidth: 0,
          },
        ],
      };
    }

    if (type === "line" || type === "bar") {
      const isMultiDataset = Array.isArray(rawData);

      if (isMultiDataset) {
        // 여러 데이터셋 (재방문률 차트 등)
        return {
          labels: Object.keys(rawData[0].graph),
          datasets: rawData.map((item, index) => ({
            label: item.label,
            data: Object.values(item.graph),
            backgroundColor:
              this.defaultColors.bar[index] || this.defaultColors.line.default,
            borderColor:
              this.defaultColors.bar[index] || this.defaultColors.line.default,
            borderWidth: type === "line" ? 2 : 0,
            borderRadius: type === "bar" ? 8 : 0,
          })),
        };
      } else {
        // 단일 데이터셋
        return {
          labels: Object.keys(rawData.graph || rawData),
          datasets: [
            {
              label: label,
              data: Object.values(rawData.graph || rawData),
              backgroundColor: this.defaultColors.line.default,
              borderColor: this.defaultColors.line.default,
              borderWidth: type === "line" ? 2 : 0,
              fill: type === "line" ? false : true,
            },
          ],
        };
      }
    }

    return { labels: [], datasets: [] };
  }

  /**
   * 차트 생성
   * @param {string} canvasId - 캔버스 엘리먼트 ID
   * @param {string} type - 차트 타입
   * @param {Object} data - 차트 데이터
   * @param {Object} options - 차트 옵션
   * @param {Array} plugins - 차트 플러그인
   * @returns {Chart} 생성된 차트 인스턴스
   */
  createChart(canvasId, type, data, options = {}, plugins = []) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) {
      console.error(`Canvas with id "${canvasId}" not found`);
      return null;
    }

    const chartOptions = this.getDefaultOptions(type, options);

    const config = {
      type: type,
      data: data,
      options: chartOptions,
      plugins: plugins,
    };

    const chart = new Chart(canvas, config);
    this.charts[canvasId] = chart;

    return chart;
  }

  /**
   * 차트 데이터 업데이트
   * @param {string} chartId - 차트 ID (캔버스 ID와 동일)
   * @param {Object} newData - 새로운 데이터
   * @param {Object} additionalUpdates - 추가 업데이트 사항 (색상 등)
   */
  updateChart(chartId, newData, additionalUpdates = {}) {
    const chart = this.charts[chartId];
    if (!chart) {
      console.error(`Chart with id "${chartId}" not found`);
      return;
    }

    // 데이터 업데이트
    if (newData.labels) {
      chart.data.labels = newData.labels;
    }

    if (newData.datasets) {
      chart.data.datasets = newData.datasets;
    } else if (newData.data) {
      // 단순 데이터 배열인 경우
      chart.data.datasets[0].data = newData.data;
    }

    // 추가 업데이트 적용
    if (additionalUpdates.backgroundColor) {
      chart.data.datasets[0].backgroundColor =
        additionalUpdates.backgroundColor;
    }
    if (additionalUpdates.borderColor) {
      chart.data.datasets[0].borderColor = additionalUpdates.borderColor;
    }

    chart.update();
  }

  /**
   * 차트 제거
   * @param {string} chartId - 제거할 차트 ID
   */
  destroyChart(chartId) {
    const chart = this.charts[chartId];
    if (chart) {
      chart.destroy();
      delete this.charts[chartId];
    }
  }

  /**
   * 모든 차트 제거
   */
  destroyAllCharts() {
    Object.keys(this.charts).forEach((chartId) => {
      this.destroyChart(chartId);
    });
  }

  /**
   * 특정 차트 가져오기
   * @param {string} chartId - 차트 ID
   * @returns {Chart|null} 차트 인스턴스
   */
  getChart(chartId) {
    return this.charts[chartId] || null;
  }

  /**
   * 모든 차트 목록 가져오기
   * @returns {Object} 모든 차트 인스턴스들
   */
  getAllCharts() {
    return this.charts;
  }
}

// 전역 차트 매니저 인스턴스
window.chartManager = new ChartManager();
