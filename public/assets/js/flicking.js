class FlickingController {
  constructor() {
    this.flickWrapper = document.querySelector(".flick-wrapper");
    this.flickPanel = document.querySelectorAll(".flick-panel");
    this.filckItems = ["dashboard", "stats", "mypage", "settings"];
    this.currentIndex = 0;
    this.isAnimating = false;

    // 터치/마우스 관련 변수
    this.startX = 0;
    this.startY = 0;
    this.currentX = 0;
    this.currentY = 0;
    this.isDragging = false;
    this.isHorizontalSwipe = false;
    this.startTime = 0;
    this.threshold = 50; // 스와이프 임계값 (px)
    this.velocityThreshold = 0.3; // 속도 임계값
    this.swipeThreshold = 10; // 수평/수직 판단 임계값 (px)

    // 동적 로딩 관련 변수
    this.loadedSections = new Set(); // 이미 로드된 섹션들 추적
    this.loadingPromises = new Map(); // 로딩 중인 프로미스들

    // 각 섹션별 필요한 CSS/JS 파일 정의
    this.sectionAssets = {
      dashboard: {
        css: ["/public/assets/css/dashboard/dashboard.css"],
        js: ["/public/assets/js/dashboard/dashboard.js"],
        content: "/src/View/sections/dashboard.php",
      },
      stats: {
        css: ["/public/assets/css/stats/stats.css"],
        js: ["/public/assets/js/stats/stats.js"],
        content: "/src/View/sections/stats.php",
      },
      mypage: {
        css: ["/public/assets/css/mypage/mypage.css"],
        js: ["/public/assets/js/mypage/mypage.js"],
        content: "/src/View/sections/mypage.php",
      },
      settings: {
        css: ["/public/assets/css/settings/settings.css"],
        js: ["/public/assets/js/settings/settings.js"],
        content: "/src/View/sections/settings.php",
      },
    };

    this.init();
  }

  init() {
    this.setupEventListeners();
    // this.updateURL();
    this.setActiveTab();

    // 초기 섹션을 비동기로 로드
    this.loadInitialSection().catch((error) => {
      console.error("Failed to load initial section:", error);
    });
  }

  // CSS 파일을 동적으로 로드
  async loadCSS(href) {
    return new Promise((resolve, reject) => {
      // 이미 로드된 CSS인지 확인
      const existingLink = document.querySelector(`link[href="${href}"]`);
      if (existingLink) {
        resolve();
        return;
      }

      const link = document.createElement("link");
      link.rel = "stylesheet";
      link.href = href;

      link.onload = () => {
        console.log(`CSS loaded: ${href}`);
        resolve();
      };

      link.onerror = () => {
        console.error(`Failed to load CSS: ${href}`);
        reject(new Error(`Failed to load CSS: ${href}`));
      };

      document.head.appendChild(link);
    });
  }

  // JS 파일을 동적으로 로드
  async loadJS(src) {
    return new Promise((resolve, reject) => {
      // 이미 로드된 스크립트인지 확인
      const existingScript = document.querySelector(`script[src="${src}"]`);
      if (existingScript) {
        resolve();
        return;
      }

      const script = document.createElement("script");
      script.src = src;
      script.async = true;
      script.defer = true;

      script.onload = () => {
        console.log(`JS loaded: ${src}`);
        resolve();
      };

      script.onerror = () => {
        console.error(`Failed to load JS: ${src}`);
        reject(new Error(`Failed to load JS: ${src}`));
      };

      document.head.appendChild(script);
    });
  }

  // 섹션 컨텐츠를 동적으로 로드
  async loadSectionContent(sectionName, targetElement) {
    try {
      const response = await fetch(this.sectionAssets[sectionName].content);
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const html = await response.text();
      targetElement.innerHTML = html;
      console.log(`Content loaded for section: ${sectionName}`);
    } catch (error) {
      console.error(`Failed to load content for ${sectionName}:`, error);
      targetElement.innerHTML = `<div class="l-inner"><div class="l-title">${sectionName} 로딩 실패</div><p>컨텐츠를 불러올 수 없습니다.</p></div>`;
    }
  }

  // 섹션의 모든 리소스를 로드
  async loadSectionResources(sectionName) {
    // 이미 로드된 섹션이면 스킵
    if (this.loadedSections.has(sectionName)) {
      return;
    }

    // 이미 로딩 중이면 해당 프로미스 반환
    if (this.loadingPromises.has(sectionName)) {
      return this.loadingPromises.get(sectionName);
    }

    console.log(`Loading resources for section: ${sectionName}`);

    const loadingPromise = (async () => {
      try {
        const assets = this.sectionAssets[sectionName];
        if (!assets) {
          console.warn(`No assets defined for section: ${sectionName}`);
          return;
        }

        // 로딩 인디케이터 표시
        const targetPanel = document.querySelector(
          `.flick-panel[data-section="${sectionName}"]`
        );
        if (targetPanel && !targetPanel.innerHTML.trim()) {
          targetPanel.innerHTML =
            '<div class="loading-indicator" style="display: flex; justify-content: center; align-items: center; height: 200px; color: #888;"><p>로딩 중...</p></div>';
        }

        // CSS 파일들 로드
        const cssPromises = assets.css.map((href) => this.loadCSS(href));

        // JS 파일들 로드
        const jsPromises = assets.js.map((src) => this.loadJS(src));

        // 컨텐츠 로드
        const contentPromise = targetPanel
          ? this.loadSectionContent(sectionName, targetPanel)
          : Promise.resolve();

        // 모든 리소스 로드 완료 대기
        await Promise.all([...cssPromises, ...jsPromises, contentPromise]);

        // 로드 완료 표시
        this.loadedSections.add(sectionName);

        // 섹션별 초기화 함수 호출 (있다면)
        this.initializeSection(sectionName);

        console.log(`All resources loaded for section: ${sectionName}`);
      } catch (error) {
        console.error(`Error loading section ${sectionName}:`, error);
      } finally {
        // 로딩 프로미스 제거
        this.loadingPromises.delete(sectionName);
      }
    })();

    this.loadingPromises.set(sectionName, loadingPromise);
    return loadingPromise;
  }

  // 섹션별 초기화 함수
  initializeSection(sectionName) {
    // 스크립트가 완전히 로드될 때까지 잠시 대기
    setTimeout(() => {
      console.log(`Attempting to initialize section: ${sectionName}`);

      switch (sectionName) {
        case "dashboard":
          if (typeof window.initDashboard === "function") {
            console.log("Calling initDashboard...");
            window.initDashboard();
          } else {
            console.warn("initDashboard function not found");
          }
          break;
        case "stats":
          if (typeof window.initStats === "function") {
            console.log("Calling initStats...");
            window.initStats();
          } else {
            console.warn("initStats function not found");
          }
          break;
        case "mypage":
          if (typeof window.initMypage === "function") {
            console.log("Calling initMypage...");
            window.initMypage();
          } else {
            console.warn("initMypage function not found");
          }
          break;
        case "settings":
          if (typeof window.initSettings === "function") {
            console.log("Calling initSettings...");
            window.initSettings();
          } else {
            console.warn("initSettings function not found");
          }
          break;
      }
    }, 100); // 100ms 지연으로 스크립트 로드 완료 보장
  }

  setupEventListeners() {
    // 탭바 클릭 이벤트
    const tabItems = document.querySelectorAll(".tabBar__item");
    tabItems.forEach((tab, index) => {
      // a 태그의 기본 동작 방지
      const link = tab.querySelector("a");
      if (link) {
        link.addEventListener("click", (e) => {
          e.preventDefault();
        });
      }

      // 탭 클릭 이벤트
      tab.addEventListener("click", (e) => {
        e.preventDefault();
        this.goToSection(index);
      });
    });

    // 터치 이벤트 (모바일)
    this.flickWrapper.addEventListener(
      "touchstart",
      this.handleTouchStart.bind(this),
      { passive: false }
    );
    this.flickWrapper.addEventListener(
      "touchmove",
      this.handleTouchMove.bind(this),
      { passive: false }
    );
    this.flickWrapper.addEventListener(
      "touchend",
      this.handleTouchEnd.bind(this),
      { passive: false }
    );

    // 마우스 이벤트 (데스크톱)
    this.flickWrapper.addEventListener(
      "mousedown",
      this.handleMouseDown.bind(this)
    );
    this.flickWrapper.addEventListener(
      "mousemove",
      this.handleMouseMove.bind(this)
    );
    this.flickWrapper.addEventListener(
      "mouseup",
      this.handleMouseUp.bind(this)
    );
    this.flickWrapper.addEventListener(
      "mouseleave",
      this.handleMouseUp.bind(this)
    );

    // 키보드 이벤트 (선택사항)
    document.addEventListener("keydown", this.handleKeyDown.bind(this));

    // 브라우저 뒤로가기/앞으로가기
    window.addEventListener("popstate", this.handlePopState.bind(this));

    // 리사이즈 이벤트
    window.addEventListener("resize", this.handleResize.bind(this));
  }

  // 터치 시작
  handleTouchStart(e) {
    if (this.isAnimating) return;

    this.startX = e.touches[0].clientX;
    this.startY = e.touches[0].clientY;
    this.currentX = this.startX;
    this.currentY = this.startY;
    this.isDragging = true;
    this.isHorizontalSwipe = false;
    this.startTime = Date.now();

    // 애니메이션 비활성화
    this.flickWrapper.style.transition = "none";
  }

  // 터치 이동
  handleTouchMove(e) {
    if (!this.isDragging || this.isAnimating) return;

    this.currentX = e.touches[0].clientX;
    this.currentY = e.touches[0].clientY;

    const deltaX = this.currentX - this.startX;
    const deltaY = this.currentY - this.startY;

    // 수평/수직 이동 판단 (첫 번째 이동에서만)
    if (
      !this.isHorizontalSwipe &&
      (Math.abs(deltaX) > this.swipeThreshold ||
        Math.abs(deltaY) > this.swipeThreshold)
    ) {
      this.isHorizontalSwipe = Math.abs(deltaX) > Math.abs(deltaY);
    }

    // 수평 스와이프인 경우에만 섹션 이동 처리
    if (this.isHorizontalSwipe) {
      e.preventDefault(); // 수평 스와이프일 때만 기본 동작 방지

      const currentTransform = -this.currentIndex * 25; // 25% = 100% / 4
      const dragTransform =
        currentTransform + (deltaX / window.innerWidth) * 25;

      // 경계 처리
      const maxTransform = 0;
      const minTransform = -75; // -(sections.length - 1) * 25
      const clampedTransform = Math.max(
        minTransform,
        Math.min(maxTransform, dragTransform)
      );

      this.flickWrapper.style.transform = `translateX(${clampedTransform}%)`;
    }
    // 수직 스크롤인 경우 기본 동작 허용 (preventDefault 호출하지 않음)
  }

  // 터치 종료
  handleTouchEnd(e) {
    if (!this.isDragging) return;

    this.isDragging = false;

    // 수평 스와이프인 경우에만 섹션 변경 처리
    if (this.isHorizontalSwipe) {
      const deltaX = this.currentX - this.startX;
      const deltaTime = Date.now() - this.startTime;
      const velocity = Math.abs(deltaX) / deltaTime;

      // 애니메이션 재활성화
      this.flickWrapper.style.transition =
        "transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94)";

      // 스와이프 방향 및 임계값 확인
      if (
        Math.abs(deltaX) > this.threshold ||
        velocity > this.velocityThreshold
      ) {
        if (deltaX > 0 && this.currentIndex > 0) {
          // 오른쪽 스와이프 (이전 섹션)
          this.goToSection(this.currentIndex - 1);
        } else if (
          deltaX < 0 &&
          this.currentIndex < this.filckItems.length - 1
        ) {
          // 왼쪽 스와이프 (다음 섹션)
          this.goToSection(this.currentIndex + 1);
        } else {
          // 원래 위치로 복귀
          this.goToSection(this.currentIndex);
        }
      } else {
        // 원래 위치로 복귀
        this.goToSection(this.currentIndex);
      }
    }

    // 상태 리셋
    this.isHorizontalSwipe = false;
  }

  // 마우스 이벤트 (데스크톱용)
  handleMouseDown(e) {
    if (this.isAnimating) return;

    this.startX = e.clientX;
    this.currentX = this.startX;
    this.isDragging = true;
    this.startTime = Date.now();

    this.flickWrapper.style.transition = "none";

    e.preventDefault();
  }

  handleMouseMove(e) {
    if (!this.isDragging || this.isAnimating) return;

    this.currentX = e.clientX;
    const deltaX = this.currentX - this.startX;
    const currentTransform = -this.currentIndex * 25;
    const dragTransform = currentTransform + (deltaX / window.innerWidth) * 25;

    const maxTransform = 0;
    const minTransform = -75;
    const clampedTransform = Math.max(
      minTransform,
      Math.min(maxTransform, dragTransform)
    );

    this.flickWrapper.style.transform = `translateX(${clampedTransform}%)`;
  }

  handleMouseUp(e) {
    if (!this.isDragging) return;

    this.isDragging = false;
    const deltaX = this.currentX - this.startX;
    const deltaTime = Date.now() - this.startTime;
    const velocity = Math.abs(deltaX) / deltaTime;

    this.flickWrapper.style.transition =
      "transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94)";

    if (
      Math.abs(deltaX) > this.threshold ||
      velocity > this.velocityThreshold
    ) {
      if (deltaX > 0 && this.currentIndex > 0) {
        this.goToSection(this.currentIndex - 1);
      } else if (deltaX < 0 && this.currentIndex < this.filckItems.length - 1) {
        this.goToSection(this.currentIndex + 1);
      } else {
        this.goToSection(this.currentIndex);
      }
    } else {
      this.goToSection(this.currentIndex);
    }
  }

  // 키보드 네비게이션
  handleKeyDown(e) {
    if (this.isAnimating) return;

    switch (e.key) {
      case "ArrowLeft":
        if (this.currentIndex > 0) {
          this.goToSection(this.currentIndex - 1);
        }
        break;
      case "ArrowRight":
        if (this.currentIndex < this.filckItems.length - 1) {
          this.goToSection(this.currentIndex + 1);
        }
        break;
    }
  }

  // 브라우저 히스토리 처리
  handlePopState(e) {
    const section = e.state?.section || "dashboard";
    const index = this.filckItems.indexOf(section);
    if (index !== -1 && index !== this.currentIndex) {
      this.currentIndex = index;
      this.moveToCurrentSection();
      this.setActiveTab();
    }
  }

  // 리사이즈 처리
  handleResize() {
    this.moveToCurrentSection();
  }

  // 특정 섹션으로 이동
  async goToSection(index, pushState = true) {
    if (index === this.currentIndex || this.isAnimating) return;
    if (index < 0 || index >= this.filckItems.length) return;

    this.isAnimating = true;
    this.currentIndex = index;

    this.moveToCurrentSection();
    this.setActiveTab();

    if (pushState) {
      //   this.updateURL();
    }

    // 현재 섹션의 리소스를 동적으로 로드
    const currentSectionName = this.filckItems[index];
    await this.loadSectionResources(currentSectionName);

    // 섹션별 데이터 로딩 (기존 로직 유지)
    this.loadSectionData(currentSectionName);

    // 애니메이션 완료 후
    setTimeout(() => {
      this.isAnimating = false;
    }, 300);
  }

  // 섹션 이동 애니메이션
  moveToCurrentSection() {
    const translateX = -this.currentIndex * 25; // 25% = 100% / 4
    this.flickWrapper.style.transform = `translateX(${translateX}%)`;

    // 스와이프 인디케이터 업데이트 (있는 경우)
    const indicator = document.querySelector(".swipe-indicator::after");
    if (indicator) {
      indicator.style.transform = `translateX(${this.currentIndex * 100}%)`;
    }
  }

  // 활성 탭 표시
  setActiveTab() {
    const tabItems = document.querySelectorAll(".tabBar__item");
    tabItems.forEach((tab, index) => {
      tab.classList.toggle("active", index === this.currentIndex);
    });
  }

  // URL 업데이트
  updateURL() {
    const section = this.filckItems[this.currentIndex];
    const url = `/${section}`;

    if (window.location.pathname !== url) {
      window.history.pushState({ section }, "", url);
    }
  }

  // 초기 섹션 로드
  async loadInitialSection() {
    const path = window.location.pathname.substring(1);
    const index = this.filckItems.indexOf(path);

    if (index !== -1) {
      this.currentIndex = index;
      this.moveToCurrentSection();
      this.setActiveTab();
    }

    // 초기 섹션의 리소스를 동적으로 로드
    const initialSectionName = this.filckItems[this.currentIndex];
    await this.loadSectionResources(initialSectionName);
    this.loadSectionData(initialSectionName);
  }

  // 섹션별 데이터 로딩
  loadSectionData(section) {
    console.log(`Loading data for section: ${section}`);

    // 각 섹션별로 필요한 데이터 로딩 로직
    switch (section) {
      case "dashboard":
        this.loadDashboardData();
        break;
      case "stats":
        this.loadStatsData();
        break;
      case "mypage":
        this.loadMypageData();
        break;
      case "settings":
        this.loadSettingsData();
        break;
    }
  }

  // 각 섹션별 데이터 로딩 메소드
  loadDashboardData() {
    // 대시보드 데이터 로딩
    if (typeof updateSummaryCardData === "function") {
      updateSummaryCardData("monthly");
    }
  }

  loadStatsData() {
    // 통계 데이터 로딩
    console.log("Loading stats data...");
  }

  loadMypageData() {
    // 마이페이지 데이터 로딩
    console.log("Loading mypage data...");
  }

  loadSettingsData() {
    // 설정 데이터 로딩
    console.log("Loading settings data...");
  }

  // 외부에서 호출 가능한 메소드들
  next() {
    if (this.currentIndex < this.filckItems.length - 1) {
      this.goToSection(this.currentIndex + 1);
    }
  }

  prev() {
    if (this.currentIndex > 0) {
      this.goToSection(this.currentIndex - 1);
    }
  }

  getCurrentSection() {
    return this.filckItems[this.currentIndex];
  }

  getSectionIndex(sectionName) {
    return this.filckItems.indexOf(sectionName);
  }
}

// 초기화
document.addEventListener("DOMContentLoaded", function () {
  window.flickingController = new FlickingController();
});

// 외부에서 사용할 수 있는 전역 함수들
window.goToSection = function (sectionName) {
  const index = window.flickingController.getSectionIndex(sectionName);
  if (index !== -1) {
    window.flickingController.goToSection(index);
  }
};

window.nextSection = function () {
  window.flickingController.next();
};

window.prevSection = function () {
  window.flickingController.prev();
};
