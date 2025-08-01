<?php
// 해당 뷰에서 필요한 컴포넌트의 CSS/JS 파일을 배열로 등록
$cssFiles = [
    '/assets/css/components/modal/passwordChangeModal.css',
  ];
  
$jsFiles = [
    '/assets/js/components/modal/passwordChangeModal.js',
];

// 컴포넌트 불러오기 전용 헬퍼 함수
function renderComponent($name, $data = []) {
    extract($data);
    include __DIR__ . "/../components/{$name}.php";
}
?>

<div class="mypage l-container">
    <div class="l-title-box">
        <div class="l-inner">
            <div class="l-title">마이페이지</div>
        </div>
        <div class="notification-bell">
            <a href="/notification" class="btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="36" viewBox="0 0 32 36" fill="none">
                <path d="M7.71362 24C7.15566 24 6.64133 23.7225 6.35456 23.267C6.00232 22.6998 6.11454 21.9728 6.6164 21.5294L8.03468 20.2805V15.2368C8.0378 11.3816 11.3638 8 15.1511 8C18.9383 8 22.2643 11.3816 22.2643 15.2368V20.2805L23.6826 21.5294C24.1876 21.9728 24.2967 22.7029 23.9444 23.267C23.6608 23.7195 23.1433 24 22.5854 24H7.71362Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M19.1468 24C19.1468 26.211 17.3567 28 15.1483 28C12.94 28 11.1499 26.2079 11.1499 24H19.1499H19.1468Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="26.5" cy="7.5" r="1.5" fill="#4587FF"/>
            </svg>
            </a>
        </div>
    </div>
    <div class="l-gap-box"></div>

    <div class="mypage__content">
        <div class="l-grid settings-grid">
            <div class="l-grid__item">
                <div class="profile-card">
                    <div class="profile-image-box">
                        <div class="image">
                            <img src="/assets/images/common/profile_default.png" alt="profile">
                        </div>
                        <button type="button" class="btn btn--edit">
                            <div class="icon icon--edit"></div>
                            <span class="blind">프로필사진 변경하기</span>
                        </button>
                    </div>
                    <div class="profile-info-list">
                        <div class="info-item info-name">
                            <div class="info-label">병원명</div>
                            <div class="info-value">와커스</div>
                        </div>
                        <div class="info-item info-email">
                            <div class="info-label">이메일</div>
                            <div class="info-value">wacus@gmail.com</div>
                        </div>
                    </div>
                    <div class="password-change-box">
                        <button type="button" class="btn btn--border-default full" data-modal-trigger="password-change">
                            비밀번호 변경하기
                        </button>
                    </div>
                </div>
            </div>

            <div class="l-gap-box"></div>

            <div class="l-grid__item">
                <div class="list">
                    <div class="list__item">
                        <div class="list__item-inner l-inner">
                            <div class="list__item-text">
                                버전정보
                            </div>
                            <div class="list__item-info">
                                2.12
                            </div>
                        </div>
                    </div>
                    <div class="list__item">
                        <div class="list__item-inner l-inner">
                            <div class="list__item-text">
                                고객센터
                            </div>
                            <div class="list__item-button">
                                <button type="button" class="btn--link">
                                    <div class="icon icon--arrow-diagonal"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="list__item">
                        <div class="list__item-inner l-inner">
                            <div class="list__item-text">
                                이용약관
                            </div>
                            <div class="list__item-button">
                                <button type="button" class="btn--link">
                                    <div class="icon icon--arrow-right"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="list__item bd-btm">
                        <div class="list__item-inner l-inner">
                            <div class="list__item-text">
                                개인정보처리방침
                            </div>
                            <div class="list__item-button">
                                <button type="button" class="btn--link">
                                    <div class="icon icon--arrow-right"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="l-grid__item">
                <div class="user-utils">
                    <button type="button" class="btn--logout">
                        로그아웃
                    </button>
                    <button type="button" class="btn--withdrawal">
                        회원탈퇴
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
    renderComponent('modal/passwordChangeModal', [
        'id' => 'password-change-modal',
        'title' => '비밀번호 변경',
        'body' => '<div class="modal-body__content">비밀번호 변경</div>',
    ]);
?>