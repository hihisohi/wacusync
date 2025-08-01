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
    include __DIR__ . "/../../components/{$name}.php";
}
?>

<div class="page page-login l-auth">
    <div class="l-auth__inner">
        <div class="page__header l-auth__header">
            <div class="container">
                <div class="page__title m-b-30">
                    이메일로 로그인
                </div>
            </div>
        </div>

        <div class="page__content l-auth__content">
            <div class="container">
                <form action="" class="login__form" id="loginForm" novalidate>
                    <div class="form-row">
                        <label for="userId">이메일</label>
                        <div class="input-item">
                            <input id="userId" type="text" placeholder="wacus@email.com" required autocomplete="off">
                            <button class="btn--clear" type="button">
                                <span class="icon icon--clear"></span>
                                <span class="blind">삭제</span>
                            </button>
                        </div>
                        <div class="error-message" data-input-error="userId"></div>
                    </div>
                    <div class="form-row">
                        <label for="userPw">비밀번호</label>
                        <div class="input-item">
                            <input id="userPw" type="password" placeholder="영문, 숫자, 특수문자 조합 8자리 이상" required
                                autocomplete="off">
                            <button class="btn--clear" type="button">
                                <span class="icon icon--clear"></span>
                                <span class="blind">삭제</span>
                            </button>
                        </div>
                        <div class="error-message" data-input-error="userPw"></div>
                    </div>
                    <div class="form-row">
                        <div class="checkbox-item">
                            <label class="remember-login">
                                <span class="checkbox-text">자동로그인</span>
                                <input type="checkbox" checked="checked">
                                <span class="checkbox-mark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-row form-row--submit">
                        <button type="submit" class="btn btn--default full login__button disabled">
                            로그인
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="l-auth__footer">
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