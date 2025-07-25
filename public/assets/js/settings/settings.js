const settingOptions = {
  "sync-cycle": {
    title: "동기화 주기",
    // options: ["실시간", "1시간", "12시간", "24시간"],
    optionsObject: {
      realtime: {
        label: "실시간",
        flag: true,
      },
      hour1: {
        label: "1시간",
        flag: false,
      },
      hour12: {
        label: "12시간",
        flag: false,
      },
    },
  },
  "report-format": {
    title: "보고서 포맷",
    // options: ["PDF", "Excel", "CSV"],
    optionsObject: {
      pdf: {
        label: "PDF",
        flag: true,
      },
      excel: {
        label: "Excel",
        flag: false,
      },
      csv: {
        label: "CSV",
        flag: false,
      },
    },
  },
};

document.addEventListener("DOMContentLoaded", function () {
  const settingBtns = document.querySelectorAll(".btn--setting");

  settingBtns.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();

      const settingKey = btn.dataset.setting;

      window.ModalAPI.openSettingOptionModal(
        settingKey,
        settingOptions[settingKey]
      );
    });
  });
});
