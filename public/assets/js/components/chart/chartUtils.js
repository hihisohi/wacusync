export const ChartUtils = {
  // 차트 공통 기본 색상 팔레트
  colors: [
    "rgba(54, 162, 235, 0.8)",
    "rgba(255, 99, 132, 0.8)",
    "rgba(255, 206, 86, 0.8)",
    "rgba(75, 192, 192, 0.8)",
    "rgba(153, 102, 255, 0.8)",
    "rgba(255, 159, 64, 0.8)",
  ],

  // 차트 공통 기본 옵션
  getGlobalOptions() {
    return {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: "top",
          labels: {
            font: {
              family: "'Pretendard', sans-serif",
              size: 12,
              color: "#615E83",
            },
          },
        },
        tooltip: {
          enabled: true,
          mode: "index",
          intersect: false,
          titleFont: { family: "'Pretendard', sans-serif" },
          bodyFont: { family: "'Pretendard', sans-serif" },
        },
      },
      // scales: {
      //   x: {
      //     ticks: {
      //       font: { family: "'Pretendard', sans-serif", size: 11 },
      //     },
      //   },
      //   y: {
      //     ticks: {
      //       font: { family: "'Pretendard', sans-serif", size: 11 },
      //     },
      //   },
      // },
    };
  },
};
