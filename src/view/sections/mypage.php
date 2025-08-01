<div class="l-inner">
    <div class="l-title-box m-b-30">
        <div class="l-title">마이페이지</div>
    </div>

    <div>
        <!-- 프로필 섹션 -->
        <div
            style="background: var(--color-secondary-bg); border: 1px solid var(--color-secondary-border); border-radius: 8px; padding: 20px; margin-bottom: 20px;">
            <h3 style="color: var(--color-main-text); margin-bottom: 15px;">프로필 정보</h3>
            <div style="margin-bottom: 10px;">
                <span style="color: #888;">이름:</span>
                <span style="color: var(--color-main-text); margin-left: 10px;">와커스</span>
            </div>
            <div style="margin-bottom: 10px;">
                <span style="color: #888;">이메일:</span>
                <span style="color: var(--color-main-text); margin-left: 10px;">wacus@example.com</span>
            </div>
            <div style="margin-bottom: 10px;">
                <span style="color: #888;">가입일:</span>
                <span style="color: var(--color-main-text); margin-left: 10px;">2019.11.01</span>
            </div>
        </div>

        <!-- 메뉴 리스트 -->
        <?php 
        $menuItems = [
            "개인정보 수정", "비밀번호 변경", "알림 설정", "결제 내역", 
            "이용 약관", "개인정보 처리방침", "문의하기", "앱 정보",
            "로그아웃", "회원탈퇴", "데이터 백업", "테마 설정",
            "언어 설정", "접근성", "고객지원"
        ];
        ?>

        <?php foreach($menuItems as $index => $menuItem): ?>
        <div class="mypage-menu-item"
            style="background: var(--color-secondary-bg); border: 1px solid var(--color-secondary-border); border-radius: 8px; padding: 15px; margin-bottom: 10px; cursor: pointer; transition: background-color 0.2s;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="color: var(--color-main-text);"><?php echo $menuItem; ?></span>
                <span style="color: #666;">›</span>
            </div>
            <?php if ($index % 3 === 0): ?>
            <div style="margin-top: 8px; color: #666; font-size: 12px;">
                동적 로딩된 메뉴 항목입니다
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

        <div style="text-align: center; padding: 40px 0; color: #888;">
            <p>마이페이지 동적 로딩 완료!</p>
        </div>
    </div>
</div>

<script>
// 마이페이지 초기화 함수
function initMypage() {
    console.log('Mypage initialized!');

    // 마이페이지 특화 로직
    const menuItems = document.querySelectorAll('.mypage-menu-item');
    menuItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            console.log(`Mypage menu item ${index + 1} clicked!`);
            // 실제 페이지 이동이나 모달 표시 로직
        });

        // 호버 효과
        item.addEventListener('mouseenter', () => {
            item.style.opacity = '0.8';
        });

        item.addEventListener('mouseleave', () => {
            item.style.opacity = '1';
        });
    });
}
</script>