document.addEventListener("DOMContentLoaded", function () {
  // 초기 설정
  setVhProperty();

  // 브라우저 UI(주소창 등)로 인해 변동되는 뷰포트 높이 문제를 해결
  function setVhProperty() {
    // 실제 화면 높이를 정확히 측정
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty("--vh", `${vh}px`);
  }

  // 리사이즈 이벤트 (orientation 변경 포함)
  window.addEventListener("resize", setVhProperty);

  //   // 모바일에서 주소창 숨김/표시 감지
  //   window.addEventListener("orientationchange", () => {
  //     // orientationchange 후 약간의 지연을 두고 재계산
  //     setTimeout(setVhProperty, 100);
  //   });

  //   // iOS Safari의 경우 추가 처리
  //   if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
  //     window.addEventListener("scroll", setVhProperty);
  //     // 화면 터치 시에도 재계산
  //     document.addEventListener("touchstart", setVhProperty);
  //   }

  //   // Visual Viewport API 지원 브라우저에서 더 정확한 처리
  //   if (window.visualViewport) {
  //     window.visualViewport.addEventListener("resize", setVhProperty);
  //   }
});
