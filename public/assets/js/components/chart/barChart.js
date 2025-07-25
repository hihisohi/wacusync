import BaseChart from "./baseChart.js";

/**
 * BarChart 클래스
 * BaseChart를 상속받아 막대형 차트의 고유 기능을 구현합니다.
 */
export default class BarChart extends BaseChart {
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
   * 막대형 차트 렌더링
   */
  renderChart() {
    // 막대 차트에 특화된 기본 옵션
    const barDefaultOptions = {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    };

    // 부모의 render 메소드 호출
    super.render("bar", barDefaultOptions);
  }
}

/**
 * 간편한 막대형 차트 생성 헬퍼 함수
 * @param {string} canvasId - 캔버스 ID
 * @param {Object} data - 차트 데이터 (Chart.js 형식)
 * @param {Object} options - 차트 옵션
 * @returns {BarChart} 막대형 차트 인스턴스
 */
export function createBarChart(canvasId, data, options = {}) {
  return new BarChart(canvasId, data, options);
}
