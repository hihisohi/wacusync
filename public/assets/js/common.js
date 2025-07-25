document.addEventListener("DOMContentLoaded", function () {
  // 초기 설정
  setVhProperty();

  initFadeAnimations();

  const customSelects = document.querySelectorAll(".custom-select");
  customSelects.forEach((customSelect) => {
    handleCustomSelect(customSelect);
  });

  // 브라우저 UI(주소창 등)로 인해 변동되는 뷰포트 높이 문제를 해결
  function setVhProperty() {
    // 실제 화면 높이를 정확히 측정
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty("--vh", `${vh}px`);
  }

  function handleCustomSelect(select) {
    const trigger = select.querySelector(".custom-select__trigger");
    const selected = select.querySelector(".custom-select__selected");
    const options = select.querySelector(".custom-select__options");

    trigger.addEventListener("click", (e) => {
      select.classList.toggle("open");
    });

    options.addEventListener("click", (e) => {
      const opt = e.target.closest(".custom-select__option");
      if (!opt) return;
      const value = opt.dataset.value;
      const label = opt.textContent;

      selected.textContent = label;
      select.dataset.value = value;

      select.classList.remove("open");

      // 변경된 select 요소를 매개변수로 전달
      //   if (typeof onCustomSelectChange === "function") {
      //     onCustomSelectChange(select);
      //   }
    });

    document.addEventListener("click", (e) => {
      if (!select.contains(e.target)) {
        select.classList.remove("open");
      }
    });
  }

  function initFadeAnimations() {
    // 공통 페이드 애니메이션
    gsap.utils.toArray("[data-fade]").forEach((el) => {
      const direction = el.dataset.fade;
      const delay = parseFloat(el.dataset.fadeDelay) || 0;
      const distance = parseFloat(el.dataset.fadeDistance) || 20;
      const duration = parseFloat(el.dataset.fadeDuration) || 0.5;

      // 방향 설정
      let x = 0,
        y = 0;

      switch (direction) {
        case "":
          x = 0;
          y = 0;
          break;
        case "up":
          y = distance;
          break;
        case "down":
          y = -distance;
          break;
        case "left":
          x = distance;
          break;
        case "right":
          x = -distance;
          break;
      }

      // 애니메이션 생성
      const anim = gsap.fromTo(
        el,
        { opacity: 0, x, y },
        {
          opacity: 1,
          x: 0,
          y: 0,
          duration: duration,
          ease: "power1.out",
          paused: true, // 일단 자동 재생하지 않음
        }
      );

      const triggerParent = el.closest("[data-fade-trigger]");

      // ScrollTrigger
      ScrollTrigger.create({
        trigger: triggerParent ? triggerParent : el,
        start: "20% 90%",
        onEnter: () => gsap.delayedCall(delay, () => anim.play()),
        onLeaveBack: () => anim.reverse(),
      });
    });
  }

  // 리사이즈 이벤트 (orientation 변경 포함)
  window.addEventListener("resize", () => {
    setVhProperty();

    ScrollTrigger.refresh();
  });

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
