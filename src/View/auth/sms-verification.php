<div class="page page-smsVerification l-auth">
    <div class="l-auth__inner">
        <div class="page__header l-auth__header">
            <div class="container">
                <div class="page__go-back">
                    <button class="btn--go-back" type="button" onclick="window.location.href = '/login'">
                        <div class="icon icon--go-back">
                            <span class="blind">뒤로가기</span>
                        </div>
                    </button>
                </div>
                <div class="page__title m-b-30">
                    문자인증받기
                </div>
                <div class="page__description">
                    문자인증은 최초 로그인시에만 진행됩니다.
                </div>
            </div>
        </div>

        <div class="page__content l-auth__content">
            <div class="container">
                <form action="" class="verify__form" id="verifyForm" novalidate>
                    <div class="form-row">
                        <label for="userId">가입자명</label>
                        <div class="input-item">
                            <input id="userId" type="text" placeholder="와커스" required autocomplete="off">
                            <button class="btn--clear" type="button">
                                <span class="icon icon--clear"></span>
                                <span class="blind">삭제</span>
                            </button>
                        </div>
                        <div class="error-message" data-input-error="userId"></div>
                    </div>
                    <div class="form-row">
                        <label for="userPw">핸드폰 번호</label>
                        <div class="input-item">
                            <input id="userPw" type="text" placeholder="핸드폰 번호를 입력해주세요" required
                                autocomplete="off">
                            <button class="btn btn--border-default btn--send" type="button">
                                인증 요청
                            </button>
                        </div>
                        <div class="error-message" data-input-error="userPw"></div>
                    </div>
                    <div class="form-row">
                        <label for="userPw">인증번호</label>
                        <div class="input-item">
                            <input id="userPw" type="text" placeholder="인증번호를 입력해주세요" required
                                autocomplete="off">
                            <button class="btn btn--default white btn--send" type="button">
                                인증 확인
                            </button>
                        </div>
                        <div class="error-message" data-input-error="userPw"></div>
                    </div>
                    <div class="form-row form-row--submit">
                        <a href = '/welcome' type="submit" class="btn btn--default full login__button disabled">
                            인증완료
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>