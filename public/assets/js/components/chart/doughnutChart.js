import BaseChart from "./baseChart.js";

/**
 * DoughnutChart 클래스
 * BaseChart를 상속받아 도넛 차트의 고유 기능을 구현합니다.
 */
export default class DoughnutChart extends BaseChart {
  constructor(canvasId, data, options = {}, legendContainerId = null) {
    // 부모 클래스 생성자 호출
    super(canvasId, data, options);

    if (!this.isCanvasValid()) return;

    this.legendContainerId = legendContainerId;
    this.tooltipId = "chartjs-tooltip";

    // 도넛 차트 전용 색상 (BaseChart의 기본 색상을 오버라이드)
    this.colors = ["#926DFF", "#7FE47E", "#FF718B", "#FFC544", "#4587FF"];

    // 도넛 차트 전용 플러그인 등록
    this.plugins.push(this.createCustomTooltipPlugin());
    if (this.legendContainerId) {
      this.plugins.push(this.createCustomLegendPlugin());
    }

    // 툴팁 DOM 초기화
    this.initTooltipElement();

    // 차트 렌더링
    this.renderChart();
  }

  /**
   * 도넛 차트 렌더링
   */
  renderChart() {
    // key-value 형태의 데이터를 Chart.js 형식으로 변환
    const chartData = this.convertKeyValueData(
      this.data,
      this.options.label || ""
    );

    // 도넛 차트 전용 기본 옵션
    const doughnutDefaultOptions = {
      cutout: "70%",
      responsive: true,
      maintainAspectRatio: false,
      borderRadius: 10,
      borderWidth: 0,
      plugins: {
        legend: { display: false },
        tooltip: { enabled: false }, // 커스텀 툴팁을 사용하므로 기본 툴팁은 비활성화
      },
      onHover: (evt, items) => {
        evt.native.target.style.cursor = items.length ? "pointer" : "";
      },
    };

    // 변환된 데이터로 this.data 업데이트
    this.data = chartData;

    // 부모의 render 메소드 호출
    super.render("doughnut", doughnutDefaultOptions);
  }

  /**
   * 툴팁 엘리먼트 초기화
   */
  initTooltipElement() {
    if (!document.getElementById(this.tooltipId)) {
      const tooltipEl = document.createElement("div");
      tooltipEl.id = this.tooltipId;
      tooltipEl.style.position = "absolute";
      tooltipEl.style.pointerEvents = "none";
      tooltipEl.style.opacity = 0;
      document.body.appendChild(tooltipEl);
    }
  }

  /**
   * 커스텀 툴팁 플러그인 생성
   * @returns {Object} Chart.js 플러그인 객체
   */
  createCustomTooltipPlugin() {
    return {
      id: "customTooltip",
      afterDraw: (chart) => {
        const tooltipEl = this.getTooltipElement();
        const tooltipModel = chart.tooltip;

        // 툴팁이 보이지 않을 때 숨기기
        if (tooltipModel.opacity === 0) {
          tooltipEl.style.opacity = 0;
          return;
        }

        // 툴팁 내용 설정
        const dataIndex = tooltipModel.dataPoints[0].dataIndex;
        const value = chart.data.datasets[0].data[dataIndex];
        tooltipEl.innerHTML = `<div class="tooltip-box">${value}건</div>`;

        // 툴팁 위치 계산
        const { canvas } = chart;
        const position = canvas.getBoundingClientRect();
        const caretY = tooltipModel.caretY || 0;

        tooltipEl.style.opacity = 1;
        tooltipEl.style.left =
          position.left + window.pageXOffset + tooltipModel.caretX + "px";
        tooltipEl.style.top =
          position.top +
          window.pageYOffset +
          caretY -
          tooltipEl.offsetHeight -
          10 +
          "px";
      },
    };
  }

  /**
   * 커스텀 범례 플러그인 생성
   * @returns {Object} Chart.js 플러그인 객체
   */
  createCustomLegendPlugin() {
    if (!this.legendContainerId) return null;

    return {
      id: "customLegend",
      afterUpdate: (chart) => {
        const container = document.querySelector(this.legendContainerId);
        if (!container) return;

        container.innerHTML = ""; // 초기화

        chart.data.labels.forEach((label, i) => {
          const color = this.colors[i];
          const value = chart.data.datasets[0].data[i];

          // 범례 아이템 생성
          const item = document.createElement("div");
          item.className = "legend__item";
          item.innerHTML = `
            <div class="legend__item-label">
                <span class="label__color" style="background:${color}"></span>
                <span class="label__text">${label}</span>
            </div>
            <div class="legend__item-value">
                <span class="value__text">${value}</span>
            </div>
          `;

          // 클릭 시 해당 데이터셋 토글 기능
          item.onclick = () => {
            chart.toggleDataVisibility(i);
            chart.update();
          };

          container.appendChild(item);
        });
      },
    };
  }

  /**
   * 툴팁 엘리먼트 가져오기
   * @returns {HTMLElement} 툴팁 엘리먼트
   */
  getTooltipElement() {
    return document.getElementById(this.tooltipId);
  }

  /**
   * 도넛 차트용 데이터 업데이트 (key-value 형태 지원)
   * @param {Object} newData - 새로운 데이터 (key-value 형태)
   */
  update(newData) {
    if (!this.chart) {
      console.error("Chart not initialized");
      return;
    }

    // key-value 형태의 데이터를 Chart.js 형식으로 변환
    this.chart.data.labels = Object.keys(newData);
    this.chart.data.datasets[0].data = Object.values(newData);

    // 차트 다시 그리기
    this.chart.update();
  }
}

/**
 * 간편한 도넛 차트 생성 헬퍼 함수
 * @param {string} canvasId - 캔버스 ID
 * @param {Object} data - 차트 데이터 (key-value 형태)
 * @param {string} legendContainerId - 범례 컨테이너 ID (선택사항)
 * @param {string} label - 데이터셋 라벨
 * @returns {DoughnutChart} 도넛 차트 인스턴스
 */
export function createDoughnutChart(
  canvasId,
  data,
  legendContainerId = null,
  label = ""
) {
  return new DoughnutChart(canvasId, data, { label }, legendContainerId);
}
