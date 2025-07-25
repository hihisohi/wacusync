import BaseChart from "./baseChart.js";

/**
 * LineChart 클래스
 * BaseChart를 상속받아 선형 차트의 고유 기능을 구현합니다.
 */
export default class LineChart extends BaseChart {
  /**
   * @param {string} canvasId - 차트를 그릴 canvas 요소의 ID
   * @param {object} data - 차트 데이터 (labels, datasets 포함)
   * @param {object} [options] - Chart.js에 전달할 추가 옵션
   */
  constructor(canvasId, data, options = {}) {
    // 부모 클래스 생성자 호출
    super(canvasId, data, options);

    if (!this.isCanvasValid()) return;

    // 차트 렌더링
    this.renderChart();
  }

  /**
   * 선형 차트 렌더링
   */
  renderChart() {
    // 라인 차트에 특화된 기본 옵션
    const lineChartDefaultOptions = {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
      interaction: {
        intersect: false,
        mode: "index",
      },
      plugins: {
        tooltip: {
          position: "nearest",
        },
      },
    };

    // 부모의 render 메소드 호출
    super.render("line", lineChartDefaultOptions);
  }
}

/**
 * 간편한 선형 차트 생성 헬퍼 함수
 * @param {string} canvasId - 캔버스 ID
 * @param {Object} data - 차트 데이터 (Chart.js 형식)
 * @param {Object} options - 차트 옵션
 * @returns {LineChart} 선형 차트 인스턴스
 */
export function createLineChart(canvasId, data, options = {}) {
  return new LineChart(canvasId, data, options);
}
