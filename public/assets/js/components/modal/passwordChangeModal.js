/**
 * 패스워드 변경 모달 클래스
 * Modal 클래스를 상속받아 특화된 기능을 제공합니다.
 */
class PasswordChangeModal extends Modal {
  constructor() {
    super('password-change-modal');
  }

  onOpen() {
    // 패스워드 변경 모달이 열릴 때 실행할 로직
    // 예: 폼 초기화, 포커스 설정 등
    const form = this.getElement('form');
    if (form) {
      form.reset();
    }
  }

  onClose() {
    // 패스워드 변경 모달이 닫힐 때 실행할 로직
    // 예: 폼 정리, 에러 메시지 제거 등
    const form = this.getElement('form');
    if (form) {
      form.reset();
    }
  }

  // 패스워드 변경 관련 특화 메서드들을 여기에 추가할 수 있습니다
  validatePasswords() {
    // 패스워드 유효성 검사 로직
  }

  submitPasswordChange() {
    // 패스워드 변경 제출 로직
  }
}

// DOM 로드 후 인스턴스 생성 및 등록
document.addEventListener('DOMContentLoaded', () => {
  const passwordChangeModal = new PasswordChangeModal();
  window.modalManager.register('password-change-modal', passwordChangeModal);
  
  // 하위 호환성을 위한 전역 함수 (점진적 제거 예정)
  window.ModalAPI = window.ModalAPI || {};
  window.ModalAPI.openPasswordChangeModal = () => passwordChangeModal.open();
  window.ModalAPI.closePasswordChangeModal = () => passwordChangeModal.close();
});
