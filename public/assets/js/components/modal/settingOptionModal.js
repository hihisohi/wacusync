function openSettingOptionModal(settingKey, settingOptions) {
  const modal = document.getElementById("setting-option-modal");
  if (!modal) return;

  const headerTitleEl = modal.querySelector(".modal-header__title");
  if (headerTitleEl) headerTitleEl.textContent = settingOptions.title;

  const bodyEl = modal.querySelector(".modal-body__content");
  if (bodyEl) {
    const options = settingOptions.optionsObject;

    const optionEls = Object.keys(options).map((option) => {
      const div = document.createElement("div");
      const input = document.createElement("input");
      const label = document.createElement("label");

      div.className = "option-item";

      input.type = "radio";
      input.name = settingKey;
      input.value = options[option];
      input.id = option;
      input.checked = options[option].flag;

      label.textContent = options[option].label;
      label.htmlFor = option;

      div.append(input, label);

      bodyEl.querySelector(".option-list").append(div);
    });
  }

  modal.classList.add("active");
}

function closeSettingOptionModal() {
  const modal = document.getElementById("setting-option-modal");
  if (!modal) return;

  const bodyEl = modal.querySelector(".modal-body__content");
  if (bodyEl) {
    const optionList = bodyEl.querySelector(".option-list");
    if (optionList) {
      // option-list의 모든 자식 요소 제거
      optionList.innerHTML = "";
    }
  }

  modal.classList.remove("active");
}

// 이벤트 위임으로 전역 함수 노출 없이 처리
document.addEventListener("DOMContentLoaded", () => {
  document.addEventListener("click", (e) => {
    const action = e.target.closest(".btn--close")?.dataset.action;

    if (action === "openSettingOptionModal") {
      const target = e.target.dataset.target;
      if (target) openSettingOptionModal(target);
    }

    if (action === "closeSettingOptionModal") {
      closeSettingOptionModal();
    }
  });
});

// 필요시에만 API로 노출
window.ModalAPI = {
  openSettingOptionModal: openSettingOptionModal,
  closeSettingOptionModal: closeSettingOptionModal,
};
