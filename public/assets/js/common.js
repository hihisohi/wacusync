// public/assets/js/common.js

/**
 * id에 해당하는 모달을 보여줍니다.
 * @param {string} id - modal 요소의 id
 */
function showModal(id) {
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

// 모달 헤더의 닫기 버튼(data-dismiss="modal") 자동 바인딩
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('[data-dismiss="modal"]').forEach((btn) => {
    btn.addEventListener("click", () => {
      const modal = btn.closest(".modal");
      if (modal) modal.classList.remove("active");
    });
  });
});
