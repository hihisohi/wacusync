<?php
// 해당 뷰에서 필요한 컴포넌트의 CSS/JS 파일을 배열로 등록
$cssFiles = [
    '/assets/css/components/modal/loginErrorModal.css',
  ];
  
$jsFiles = [
    '/assets/js/components/modal/loginErrorModal.js',
];

// 컴포넌트 불러오기 전용 헬퍼 함수
function renderComponent($name, $data = []) {
    extract($data);
    include __DIR__ . "/../components/{$name}.php";
}
?>

<div class="page__login">
    <div class="p-inner login__inner">
        <div class="p-header">
            <div class="p-header-title login__title">이메일로 로그인</div>
        </div>
        <div class="p-content">
            <form action="" class="login__form" id="loginForm" novalidate>
                <div class="form-row">
                    <label for="userId">아이디</label>
                    <input id="userId" type="text" placeholder="wacus@email.com" required autocomplete="off">
                    <p class="form-row__error"></p>
                </div>
                <div class="form-row">
                    <label for="userPw">비밀번호</label>
                    <input id="userPw" type="password" placeholder="영문, 숫자, 특수문자 조합 8자리 이상" required autocomplete="off">
                    <p class="form-row__error"></p>
                </div>
                <div class="form-row form-row--submit">
                    <button type="submit" class="btn--submit login__button" disabled>
                        로그인
                    </button>
                </div>
            </form>
        </div>
        <div class="p-footer">
            <div class="login-util">
                <div class="login-util__item">
                    <a href="/find-id">아이디 찾기</a>
                </div>
                <div class="login-util__item">
                    <a href="/find-pw">비밀번호 찾기</a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
    renderComponent('modal/loginErrorModal');
?>