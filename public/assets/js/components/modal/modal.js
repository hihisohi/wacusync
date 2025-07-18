/**
 * id에 해당하는 모달을 보여줍니다.
 * @param {string} id - modal 요소의 id
 */
function openModal(id) {
  const modal = document.getElementById(id);
  if (!modal) return console.warn(`Modal with id="${id}" not found.`);
  modal.classList.add("active");
}

/**
 * id에 해당하는 모달을 숨깁니다.
 * @param {string} id - modal 요소의 id
 */
function closeModal(id) {
  const modal = document.getElementById(id);
  if (!modal) return console.warn(`Modal with id="${id}" not found.`);
  modal.classList.remove("active");
}

// 이벤트 위임으로 전역 함수 노출 없이 처리
document.addEventListener("DOMContentLoaded", () => {
  document.addEventListener("click", (e) => {
    const action = e.target.dataset.action;

    if (action === "openModal") {
      const target = e.target.dataset.target;
      if (target) openModal(target);
    }

    if (action === "closeModal") {
      const modal = e.target.closest(".modal");
      if (modal) modal.classList.remove("active");
    }
  });
});

// 필요시에만 API로 노출
window.ModalAPI = { open: openModal, close: closeModal };
