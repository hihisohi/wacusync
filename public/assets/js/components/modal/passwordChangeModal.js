function openPasswordChangeModal() {
  const modal = document.getElementById("password-change-modal");
  if (!modal) return;

  modal.classList.add("active");
}

function closePasswordChangeModal() {
  const modal = document.getElementById("password-change-modal");
  if (!modal) return;

  modal.classList.remove("active");
}

// 이벤트 위임으로 전역 함수 노출 없이 처리
document.addEventListener("DOMContentLoaded", () => {
  document.addEventListener("click", (e) => {
    const action = e.target.closest(".btn--close")?.dataset.action;

    if (action === "openPasswordChangeModal") {
      openPasswordChangeModal();
    }

    if (action === "closePasswordChangeModal") {
      closePasswordChangeModal();
    }
  });
});

// 필요시에만 API로 노출
window.ModalAPI = {
  openPasswordChangeModal: openPasswordChangeModal,
  closePasswordChangeModal: closePasswordChangeModal,
};
