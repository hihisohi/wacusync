function openLoginErrorModal(message) {
  const modal = document.getElementById("login-error-modal");
  if (!modal) return;
  // 내용 교체
  const bodyEl = modal.querySelector(".modal-body__content");
  if (bodyEl) bodyEl.textContent = message;
  // 모달 열기
  modal.classList.add("active");
}

function closeLoginErrorModal() {
  const modal = document.getElementById("login-error-modal");
  if (!modal) return;

  modal.classList.remove("active");
}

// 이벤트 위임으로 전역 함수 노출 없이 처리
document.addEventListener("DOMContentLoaded", () => {
  document.addEventListener("click", (e) => {
    const action = e.target.dataset.action;

    if (action === "openLoginErrorModal") {
      const target = e.target.dataset.target;
      if (target) openLoginErrorModal(target);
    }

    if (action === "closeLoginErrorModal") {
      closeLoginErrorModal();
    }
  });
});
// 필요시에만 API로 노출
window.ModalAPI = {
  openLoginErrorModal: openLoginErrorModal,
  closeLoginErrorModal: closeLoginErrorModal,
};
