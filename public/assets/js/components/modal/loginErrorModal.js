/**
 * 로그인 에러 모달 클래스
 * Modal 클래스를 상속받아 특화된 기능을 제공합니다.
 */
class LoginErrorModal extends Modal {
  constructor() {
    super("login-error-modal");
  }

  open(message = "") {
    if (message) {
      this.setContent(".modal-body__content", message);
    }
    return super.open();
  }

  setErrorMessage(message) {
    this.setContent(".modal-body__content", message);
  }
}

// DOM 로드 후 인스턴스 생성 및 등록
document.addEventListener("DOMContentLoaded", () => {
  const loginErrorModal = new LoginErrorModal();
  window.modalManager.register("login-error-modal", loginErrorModal);

  // 하위 호환성을 위한 전역 함수 (점진적 제거 예정)
  window.ModalAPI = window.ModalAPI || {};
  window.ModalAPI.openLoginErrorModal = (message) => loginErrorModal.open(message);
  window.ModalAPI.closeLoginErrorModal = () => loginErrorModal.close();
});
