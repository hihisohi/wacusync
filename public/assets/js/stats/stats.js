// 통계 분석 관련 JavaScript
console.log("Stats JS loaded!");

// 통계 초기화 함수
function initStats() {
  console.log("Stats initialized!");

  // 통계 특화 로직
  const charts = document.querySelectorAll(
    '.flick-panel[data-section="stats"] div[style*="linear-gradient"]'
  );
  console.log("Found stats charts:", charts.length);

  charts.forEach((chart, index) => {
    chart.addEventListener("click", () => {
      console.log(`Stats chart ${index + 1} clicked!`);

      // 차트 클릭 효과
      chart.style.transform = "scale(1.05)";
      setTimeout(() => {
        chart.style.transform = "scale(1)";
      }, 200);
    });

    // 호버 효과
    chart.addEventListener("mouseenter", () => {
      chart.style.opacity = "0.7";
      chart.style.transition = "all 0.2s ease";
    });

    chart.addEventListener("mouseleave", () => {
      chart.style.opacity = "0.3";
    });
  });

  // 통계 특화 기능들
  initStatsFeatures();
}

// 통계 특화 기능
function initStatsFeatures() {
  console.log("Initializing stats features...");

  // 예시: 차트 데이터 업데이트
  setInterval(() => {
    updateStatsCharts();
  }, 45000); // 45초마다 업데이트
}

// 통계 차트 업데이트
function updateStatsCharts() {
  const currentSection = document.querySelector(
    '.flick-panel[data-section="stats"]'
  );
  if (!currentSection || !currentSection.innerHTML.includes("통계")) return;

  console.log("Updating stats charts...");

  // 차트 애니메이션 예시
  const charts = currentSection.querySelectorAll(
    'div[style*="linear-gradient"]'
  );
  charts.forEach((chart) => {
    chart.style.opacity = "0.1";
    setTimeout(() => {
      chart.style.opacity = "0.3";
    }, 300);
  });
}

// 전역으로 노출
if (typeof window !== "undefined") {
  window.initStats = initStats;
  window.updateStatsCharts = updateStatsCharts;
}
