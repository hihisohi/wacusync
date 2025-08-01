import { ERROR_CODES, ERROR_MESSAGES } from "../../../../../config/constants/errors.js";
import { authAPI } from "../../api/authApi.js";

document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.querySelector("#loginForm");

  const inputUserId = document.getElementById("userId");
  const inputUserPw = document.getElementById("userPw");
  const loginButton = document.querySelector(".login__button");

  initLoginView();

  const clearBtns = document.querySelectorAll(".btn--clear");

  clearBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      const input = btn.closest(".input-item").querySelector("input");

      input.value = "";
      input.dispatchEvent(new Event("input", { bubbles: true }));
      input.focus();

      btn.style.display = "none";
    });
  });

  // 아이디 input 값 변경 시 폼 유효성 체크
  inputUserId.addEventListener("input", (e) => {
    const clearBtn = e.target.closest(".input-item").querySelector(".btn--clear");

    if (e.target.value !== "") {
      clearBtn.style.display = "block";
    } else {
      clearBtn.style.display = "none";
    }

    e.target.classList.remove("error");
    document.querySelector(`[data-input-error="userId"]`).textContent = "";

    handleLoginButton();
  });

  // 비밀번호 input 값 변경 시 폼 유효성 체크
  inputUserPw.addEventListener("input", (e) => {
    const clearBtn = e.target.closest(".input-item").querySelector(".btn--clear");

    if (e.target.value !== "") {
      clearBtn.style.display = "block";
    } else {
      clearBtn.style.display = "none";
    }

    e.target.classList.remove("error");
    document.querySelector(`[data-input-error="userPw"]`).textContent = "";

    handleLoginButton();
  });

  // 로그인 폼 제출
  loginForm.addEventListener("submit", async function (e) {
    // 폼 제출 시 기존 에러 상태 초기화
    resetValidateField([inputUserId, inputUserPw]);

    e.preventDefault();

    // userId 검증 (빈값, 이메일 형식)
    const isUserIdValid = validateField(inputUserId, validateUserId, "userId");
    if (!isUserIdValid) return;

    // userPw 검증 (빈값, 8자리 이상, 영문/숫자/특수문자 포함)
    const isUserPwValid = validateField(inputUserPw, validateUserPw, "userPw");
    if (!isUserPwValid) return;

    // 필드 유효성 검증이 통과하면 로그인 api 호출
    const response = await authAPI.login({
      userId: inputUserId.value,
      userPw: inputUserPw.value,
    });

    // 로그인 결과에 따른 처리
    if (response.success) {
      console.log("로그인 성공");

      // 토큰 저장
      //   localStorage.setItem("token", response.data.token);

      window.location.href = "/sms-verification";
    } else {
      console.log("로그인 실패");

      const errorCode = response.errorCode;
      const errorDetails = response.details;

      // 로그인 에러 코드에 해당하는 메시지 가져오기
      const errorMessage = ERROR_MESSAGES[errorCode] || ERROR_MESSAGES[ERROR_CODES.AUTH.DEFAULT];

      // 로그인 오류 모달 실행
      window.ModalAPI.openLoginErrorModal(errorMessage);

      return;
    }
  });

  /**
   * 로그인 페이지 초기화
   */
  function initLoginView() {
    inputUserId.focus();
    loginButton.classList.add("disabled");
  }

  /**
   * 로그인 버튼 활성화 여부 체크
   */
  function handleLoginButton() {
    const userIdValue = inputUserId.value.trim();
    const userPwValue = inputUserPw.value.trim();

    // 모든 필드가 빈값이 아닐 때만 버튼 활성화
    if (userIdValue && userPwValue) {
      loginButton.classList.remove("disabled");
    } else {
      loginButton.classList.add("disabled");
    }
  }

  /**
   * 입력 필드의 유효성을 검사하고 UI를 업데이트하는 함수
   * @param {HTMLElement} inputElement - 검사할 input 요소
   * @param {Function} validationFunction - 유효성 검사 함수
   * @param {string} fieldName - 필드명 (에러 로깅용)
   * @returns {boolean} 유효성 검사 통과 여부 (true: 통과, false: 실패)
   */
  function validateField(inputElement, validationFunction, fieldName) {
    const value = inputElement.value;
    const errorElement = document.querySelector(`[data-input-error="${fieldName}"]`);
    const validationResult = validationFunction(value);

    if (validationResult !== null) {
      // 유효성 검사 실패 - 에러 상태로 변경
      errorElement.textContent =
        ERROR_MESSAGES[validationResult] || ERROR_MESSAGES[ERROR_CODES.VALIDATION.UNKNOWN_ERROR];
      inputElement.focus();
      inputElement.classList.add("error");

      loginButton.classList.add("disabled");

      return false;
    } else {
      // 유효성 검사 통과 - 에러 상태 초기화
      inputElement.classList.remove("error");
      errorElement.textContent = "";

      return true;
    }
  }

  let baseHeight = window.visualViewport ? window.visualViewport.height : window.innerHeight;

  /**
   * 키보드 상태 변경 시 버튼 위치 업데이트
   * @param {boolean} isOpen - 키보드 열림 여부
   */
  function onKeyboardChange(isOpen) {
    // 실제 UI 조정 로직
    if (isOpen) {
      updateButtonPosition();
    } else {
      // 키보드가 닫혔을 때 버튼 스타일 초기화
      resetButtonPosition();
    }
  }

  /**
   * 로그인 버튼 위치 업데이트
   */
  function updateButtonPosition() {
    const button = document.querySelector(".login__button");
    if (!button) return;

    // 키보드 높이 계산
    const keyboardHeight = window.innerHeight - window.visualViewport.height;

    // 현재 스크롤 위치 고려하여 버튼 위치 조정
    const scrollOffset = window.visualViewport.offsetTop || 0;

    button.style.position = "fixed";
    button.style.bottom = keyboardHeight + "px";
    button.style.left = "0";
    button.style.width = "100%";
    button.style.transform = `translate3d(0, ${scrollOffset}px, 0)`;
    button.style.borderRadius = "0";
    button.style.zIndex = "1000";
  }

  /**
   * 로그인 버튼 위치 초기화
   */
  function resetButtonPosition() {
    const button = document.querySelector(".login__button");
    if (!button) return;

    button.style.position = "";
    button.style.bottom = "";
    button.style.left = "";
    button.style.width = "";
    button.style.transform = "";
    button.style.borderRadius = "";
  }

  /**
   * 리사이즈 이벤트 핸들러
   */
  const onResize = () => {
    const h = window.visualViewport?.height ?? window.innerHeight;
    const isKeyboardOpen = h < baseHeight - 100;
    onKeyboardChange(isKeyboardOpen);

    // 키보드가 열린 상태에서 리사이즈 시 버튼 위치 업데이트
    if (isKeyboardOpen) {
      updateButtonPosition();
    }
  };

  /**
   * 스크롤 이벤트 핸들러
   */
  const onScroll = () => {
    const h = window.visualViewport?.height ?? window.innerHeight;
    const isKeyboardOpen = h < baseHeight - 100;

    // 키보드가 열린 상태에서만 스크롤 시 버튼 위치 업데이트
    if (isKeyboardOpen) {
      updateButtonPosition();
    }
  };

  window.addEventListener("resize", onResize);

  // visualViewport 스크롤 이벤트 감지
  if (window.visualViewport) {
    window.visualViewport.addEventListener("scroll", onScroll);
    window.visualViewport.addEventListener("resize", onResize);
  }
});

/**
 * 아이디 값 유효성 검사
 * @param {*} value - 아이디 입력 값
 * @returns {string} - 유효성 검사 결과 (null: 통과, 에러 코드: 실패)
 */
function validateUserId(value) {
  // 빈값 체크
  if (!value || value.trim() === "") {
    return ERROR_CODES.VALIDATION.EMPTY_ID_FIELD;
  }

  const email = value.trim();

  // 이메일 형식 체크
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!re.test(email)) {
    return ERROR_CODES.VALIDATION.INVALID_EMAIL_FORMAT;
  }

  return null;
}

/**
 * 비밀번호 값 유효성 검사
 * @param {*} value - 비밀번호 입력 값
 * @returns {string} - 유효성 검사 결과 (null: 통과, 에러 코드: 실패)
 */
function validateUserPw(value) {
  // 빈값 체크
  if (!value || value.trim() === "") {
    return ERROR_CODES.VALIDATION.EMPTY_PASSWORD_FIELD;
  }

  const password = value.trim();

  // 8자리 미만 체크
  if (password.length < 8) {
    return ERROR_CODES.VALIDATION.PASSWORD_TOO_SHORT;
  }

  // 영문 체크
  const hasEnglish = /[a-zA-Z]/.test(password);
  // 숫자 체크
  const hasNumber = /[0-9]/.test(password);
  // 특수문자 체크
  const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);

  if (!hasEnglish || !hasNumber || !hasSpecialChar) {
    return ERROR_CODES.VALIDATION.INVALID_PASSWORD_FORMAT;
  }

  return null;
}

/**
 * 입력 필드의 검증 에러 상태를 초기화하는 함수
 * @param {HTMLElement[]} inputElements - 초기화할 input 요소들의 배열
 */
function resetValidateField(inputElements) {
  inputElements.forEach((inputElement) => {
    inputElement.classList.remove("error");

    const errorElement = document.querySelector(`[data-input-error="${inputElement.id}"]`);

    if (errorElement) {
      errorElement.textContent = "";
    }
  });
}
