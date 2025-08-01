/**
 * 모달 기본 클래스
 * 모든 모달의 공통 기능을 제공합니다.
 */
class Modal {
  constructor(modalId, options = {}) {
    this.modalId = modalId;
    this.modal = document.getElementById(modalId);
    this.options = {
      closeOnBackdropClick: true,
      closeOnEscKey: true,
      ...options,
    };

    this.init();
  }

  init() {
    if (!this.modal) {
      console.warn(`Modal with id "${this.modalId}" not found`);
      return;
    }

    this.setupEventListeners();
  }

  setupEventListeners() {
    // 닫기 버튼 이벤트
    const closeButton = this.modal.querySelector(".btn--close");
    if (closeButton) {
      closeButton.addEventListener("click", () => this.close());
    }

    // 배경 클릭으로 닫기
    if (this.options.closeOnBackdropClick) {
      this.modal.addEventListener("click", (e) => {
        if (e.target === this.modal) {
          this.close();
        }
      });
    }

    // ESC 키로 닫기
    if (this.options.closeOnEscKey) {
      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && this.isOpen()) {
          this.close();
        }
      });
    }
  }

  open() {
    if (!this.modal) return false;

    this.modal.classList.add("active");
    this.onOpen();
    return true;
  }

  close() {
    if (!this.modal) return false;

    this.modal.classList.remove("active");
    this.onClose();
    return true;
  }

  isOpen() {
    return this.modal && this.modal.classList.contains("active");
  }

  // 서브클래스에서 오버라이드 가능한 훅 메서드들
  onOpen() {
    // 모달이 열릴 때 실행할 로직
  }

  onClose() {
    // 모달이 닫힐 때 실행할 로직
  }

  // 유틸리티 메서드들
  setContent(selector, content) {
    const element = this.modal.querySelector(selector);
    if (element) {
      element.textContent = content;
    }
  }

  setHTML(selector, html) {
    const element = this.modal.querySelector(selector);
    if (element) {
      element.innerHTML = html;
    }
  }

  getElement(selector) {
    return this.modal ? this.modal.querySelector(selector) : null;
  }
}

// 전역 모달 매니저
class ModalManager {
  constructor() {
    this.modals = new Map();
    this.setupGlobalEventHandlers();
  }

  register(modalId, modalInstance) {
    this.modals.set(modalId, modalInstance);
  }

  get(modalId) {
    return this.modals.get(modalId);
  }

  open(modalId, ...args) {
    const modal = this.get(modalId);
    if (modal && typeof modal.open === "function") {
      return modal.open(...args);
    }
    return false;
  }

  close(modalId) {
    const modal = this.get(modalId);
    if (modal && typeof modal.close === "function") {
      return modal.close();
    }
    return false;
  }

  closeAll() {
    this.modals.forEach((modal) => {
      if (modal.isOpen()) {
        modal.close();
      }
    });
  }

  setupGlobalEventHandlers() {
    // data-action 기반 이벤트 처리
    document.addEventListener("click", (e) => {
      const action = e.target.dataset.action;
      const target = e.target.dataset.target;

      if (action && action.startsWith("open") && action.endsWith("Modal")) {
        const modalId = action.replace("open", "").replace("Modal", "").toLowerCase();
        const modalKey = this.findModalKey(modalId);
        if (modalKey) {
          this.open(modalKey, target);
        }
      }

      if (action && action.startsWith("close") && action.endsWith("Modal")) {
        const modalId = action.replace("close", "").replace("Modal", "").toLowerCase();
        const modalKey = this.findModalKey(modalId);
        if (modalKey) {
          this.close(modalKey);
        }
      }
    });
  }

  findModalKey(partialId) {
    // 부분 ID로 모달 찾기 (예: 'loginerror' -> 'login-error-modal')
    for (const [key] of this.modals) {
      if (key.toLowerCase().includes(partialId)) {
        return key;
      }
    }
    return null;
  }
}

// 전역 인스턴스 생성
window.modalManager = new ModalManager();
window.Modal = Modal;

/*
사용법:

1. 기본 사용법 (data-action 속성 사용):
   <button data-action="openLoginErrorModal" data-target="로그인 실패">에러 모달 열기</button>
   <button data-action="closeLoginErrorModal">에러 모달 닫기</button>

2. 프로그래밍 방식:
   window.modalManager.open('login-error-modal', '에러 메시지');
   window.modalManager.close('login-error-modal');

3. 직접 인스턴스 사용:
   const modal = window.modalManager.get('login-error-modal');
   modal.open('에러 메시지');
   modal.close();

4. 새로운 모달 추가하기:
   class CustomModal extends Modal {
     constructor() {
       super('custom-modal');
     }
     
     onOpen() {
       // 커스텀 로직
     }
   }
   
   const customModal = new CustomModal();
   window.modalManager.register('custom-modal', customModal);

5. 하위 호환성 (기존 코드):
   window.ModalAPI.openLoginErrorModal('메시지');
   window.ModalAPI.closeLoginErrorModal();
*/
