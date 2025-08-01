/**
 * 설정 옵션 모달 클래스
 * Modal 클래스를 상속받아 특화된 기능을 제공합니다.
 */
class SettingOptionModal extends Modal {
  constructor() {
    super('setting-option-modal');
  }

  onOpen() {
    // 설정 옵션 모달이 열릴 때 실행할 로직
    // 예: 현재 설정값 로드, 라디오 버튼 상태 설정 등
    this.loadCurrentSettings();
  }

  onClose() {
    // 설정 옵션 모달이 닫힐 때 실행할 로직
  }

  loadCurrentSettings() {
    // 현재 설정값을 불러와서 폼에 반영하는 로직
    // 예: localStorage나 API에서 설정값 가져오기
  }

  saveSettings() {
    // 선택된 설정을 저장하는 로직
    const selectedOption = this.getElement('input[name="setting"]:checked');
    if (selectedOption) {
      // 설정 저장 로직
      console.log('Setting saved:', selectedOption.value);
      this.close();
    }
  }

  // 설정 관련 특화 메서드들
  handleOptionChange(optionValue) {
    // 옵션 변경 처리 로직
  }
}

// DOM 로드 후 인스턴스 생성 및 등록
document.addEventListener('DOMContentLoaded', () => {
  const settingOptionModal = new SettingOptionModal();
  window.modalManager.register('setting-option-modal', settingOptionModal);
  
  // 하위 호환성을 위한 전역 함수 (점진적 제거 예정)
  window.ModalAPI = window.ModalAPI || {};
  window.ModalAPI.openSettingOptionModal = () => settingOptionModal.open();
  window.ModalAPI.closeSettingOptionModal = () => settingOptionModal.close();
});
