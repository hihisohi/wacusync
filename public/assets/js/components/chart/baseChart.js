import { ChartUtils } from "./chartUtils.js";

/**
 * BaseChart 클래스
 * 모든 차트 클래스의 부모 클래스로, 공통 로직을 담당합니다.
 */
export default class BaseChart {
  /**
   * @param {string} canvasId - 차트를 그릴 canvas 요소의 ID
   * @param {object} data - Chart.js에 전달할 데이터
   * @param {object} [options={}] - Chart.js에 전달할 추가 옵션
   */
  constructor(canvasId, data, options = {}) {
    this.canvasId = canvasId;
    this.ctx = document.getElementById(canvasId)?.getContext("2d");
    if (!this.ctx) {
      console.error(`[BaseChart] Error: Canvas with id "${canvasId}" not found.`);
      return;
    }

    this.chart = null;
    this.data = data;
    this.options = options;
    this.plugins = []; // 자식 클래스에서 플러그인을 추가할 수 있도록 배열로 관리

    // 기본 색상 팔레트 (자식 클래스에서 오버라이드 가능)
    this.colors = ChartUtils.colors;
  }

  /**
   * 차트를 렌더링합니다. (자식 클래스에서 구현 필요)
   * @param {string} type - 차트 타입 ('bar', 'line', 'doughnut')
   * @param {object} defaultOptions - 해당 차트 타입의 기본 옵션
   */
  render(type, defaultOptions = {}) {
    if (!this.ctx) return;

    const chartOptions = {
      ...ChartUtils.getGlobalOptions(), // 1. 전역 공통 옵션
      ...defaultOptions, // 2. 차트 타입별 기본 옵션
      ...this.options, // 3. 사용자 커스텀 옵션
    };

    // 이전 차트가 있다면 파괴 (안정성)
    if (this.chart) {
      this.chart.destroy();
    }

    this.chart = new Chart(this.ctx, {
      type: type,
      data: this.data,
      options: chartOptions,
      plugins: this.plugins, // 등록된 플러그인 사용
    });

    // 전역 차트 매니저에 등록
    this.registerToGlobalManager();
  }

  /**
   * 새로운 데이터로 차트를 업데이트합니다.
   * @param {object} newData
   */
  update(newData) {
    if (!this.chart) {
      console.error("Chart not initialized");
      return;
    }

    this.chart.data = newData;
    this.chart.update();
  }

  /**
   * 차트 인스턴스를 파괴하여 메모리 누수를 방지합니다.
   */
  destroy() {
    if (this.chart) {
      this.chart.destroy();
      this.chart = null;

      // 전역 차트 매니저에서 제거
      this.removeFromGlobalManager();
    }
  }

  /**
   * 차트 인스턴스 가져오기
   * @returns {Chart|null} 차트 인스턴스
   */
  getChart() {
    return this.chart;
  }

  /**
   * 색상 배열 설정
   * @param {Array} colors - 새로운 색상 배열
   */
  setColors(colors) {
    this.colors = colors;
    if (this.chart && this.chart.data.datasets[0]) {
      this.chart.data.datasets[0].backgroundColor = colors;
      this.chart.update();
    }
  }

  /**
   * 특정 데이터 포인트 토글
   * @param {number} index - 토글할 데이터 인덱스
   */
  toggleDataVisibility(index) {
    if (this.chart) {
      this.chart.toggleDataVisibility(index);
      this.chart.update();
    }
  }

  /**
   * 전역 차트 매니저에 등록
   * @private
   */
  registerToGlobalManager() {
    if (window.chartManager) {
      window.chartManager.charts[this.canvasId] = this.chart;
    }
  }

  /**
   * 전역 차트 매니저에서 제거
   * @private
   */
  removeFromGlobalManager() {
    if (window.chartManager && window.chartManager.charts[this.canvasId]) {
      delete window.chartManager.charts[this.canvasId];
    }
  }

  /**
   * 캔버스 유효성 검사
   * @returns {boolean} 캔버스가 유효한지 여부
   */
  isCanvasValid() {
    return !!this.ctx;
  }

  /**
   * 데이터 형식 변환 (key-value 객체를 Chart.js 형식으로)
   * @param {object} data - key-value 형태의 데이터
   * @param {string} label - 데이터셋 라벨
   * @returns {object} Chart.js 형식의 데이터
   */
  convertKeyValueData(data, label = "") {
    return {
      labels: Object.keys(data),
      datasets: [
        {
          label: label,
          data: Object.values(data),
          backgroundColor: this.colors,
          borderWidth: 0,
        },
      ],
    };
  }
}
