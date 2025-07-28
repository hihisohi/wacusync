export function daysSince(dateString) {
  const date = new Date(dateString);
  const today = new Date();
  const diffTime = Math.abs(today - date);
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

  return diffDays + 1;
}

export function formatDate(dateString) {
  const date = new Date(dateString);
  return date.toLocaleDateString("ko-KR", {
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
  });
}

export function createRouletteNumber(element, targetNumber) {
  let targetNumberString = targetNumber.toString();

  // 기존 텍스트 제거
  element.innerHTML = "";
  element.style.width = "0px";
  element.style.transition = "width 0.3s ease-in-out";

  let length = targetNumberString.length;

  for (let i = length - 1; i >= 0; i--) {
    const digit = targetNumberString[i];

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
}
