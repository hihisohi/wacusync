document.addEventListener("DOMContentLoaded", function () {
  const elapseDaysEl = document.querySelector(
    ".dashboard__date-elapse .elapse-days"
  );

  if (!elapseDaysEl) {
    console.error("elapse-days 요소를 찾을 수 없습니다.");
    return;
  }

  createElapseDays(elapseDaysEl);
});

function createElapseDays(element) {
  let elapseDays = element.textContent;
  //   console.log("경과일수:", elapseDays);

  // 기존 텍스트 제거
  element.innerHTML = "";
  element.style.width = "0px";
  element.style.transition = "width 0.3s ease-in-out";

  let length = elapseDays.length;

  for (let i = length - 1; i >= 0; i--) {
    const digit = elapseDays[i];

    // console.log(`${i}번째 숫자:`, digit);

    const div = document.createElement("div");
    const span = document.createElement("span");

    span.textContent = "0 1 2 3 4 5 6 7 8 9 0 1 2 3 4 5 6 7 8 9"; // 작은 숫자도 어색하지 않게 룰렛효과 주기 위해 2번 반복
    span.style.wordBreak = "break-word";
    span.style.transition =
      "transform 1.2s cubic-bezier(0.36, 0.66, 0.04, 1), opacity 0.4s linear";
    span.style.display = "block";
    span.style.lineHeight = "1";
    span.style.opacity = "0";

    div.append(span);

    setTimeout(() => {
      element.prepend(div);

      let translateY = 0;
      translateY = (span.offsetHeight / 20) * (Number(digit) + 10);

      span.style.transform = `translateY(-${translateY}px)`;
      span.style.opacity = "1";
      element.style.width = `${(length - i) * 0.7 - 0.06 * (length - i - 1)}em`;
    }, 300 + (length - i) * 200);
  }

  let elapseDaysNum = Number(elapseDays);
  //   console.log("경과일수(숫자):", elapseDaysNum);
}
