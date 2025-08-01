document.addEventListener("DOMContentLoaded", function () {
  const passwordChangeBtn = document.querySelector("button[data-modal-trigger='password-change']");

  passwordChangeBtn.addEventListener("click", function (e) {
    e.preventDefault();

    window.ModalAPI.openPasswordChangeModal();
  });
});
