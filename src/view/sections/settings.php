<div class="l-inner">
    <div class="l-title-box m-b-30">
        <div class="l-title">시스템 설정</div>
    </div>

    <div>
        <!-- 설정 카테고리 -->
        <?php 
        $settingCategories = [
            "일반 설정" => [
                "알림 설정" => "푸시 알림, 이메일 알림 등",
                "테마 설정" => "다크모드, 라이트모드 선택",
                "언어 설정" => "한국어, 영어, 일본어",
                "폰트 크기" => "작게, 보통, 크게"
            ],
            "보안 설정" => [
                "비밀번호 변경" => "계정 보안 강화",
                "2단계 인증" => "SMS, 앱 인증 설정",
                "로그인 기록" => "최근 로그인 내역 확인",
                "세션 관리" => "활성 세션 관리"
            ],
            "데이터 설정" => [
                "데이터 백업" => "클라우드 백업 설정",
                "동기화 설정" => "디바이스 간 동기화",
                "캐시 관리" => "앱 캐시 정리",
                "오프라인 모드" => "오프라인 사용 설정"
            ]
        ];
        ?>

        <?php foreach($settingCategories as $categoryName => $settings): ?>
        <div style="margin-bottom: 30px;">
            <h3 style="color: var(--color-blue); margin-bottom: 15px; font-size: 18px;"><?php echo $categoryName; ?>
            </h3>

            <?php foreach($settings as $settingName => $description): ?>
            <div class="settings-item"
                style="background: var(--color-secondary-bg); border: 1px solid var(--color-secondary-border); border-radius: 8px; padding: 15px; margin-bottom: 10px; cursor: pointer;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                    <span style="color: var(--color-main-text); font-weight: 500;"><?php echo $settingName; ?></span>
                    <span style="color: #666;">›</span>
                </div>
                <div style="color: #888; font-size: 14px;">
                    <?php echo $description; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>

        <!-- 고급 설정 -->
        <div style="margin-bottom: 30px;">
            <h3 style="color: var(--color-blue); margin-bottom: 15px; font-size: 18px;">고급 설정</h3>

            <?php for($i = 1; $i <= 8; $i++): ?>
            <div class="settings-toggle"
                style="background: var(--color-secondary-bg); border: 1px solid var(--color-secondary-border); border-radius: 8px; padding: 15px; margin-bottom: 10px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                    <span style="color: var(--color-main-text); font-weight: 500;">고급 옵션 <?php echo $i; ?></span>
                    <label class="toggle-switch"
                        style="position: relative; display: inline-block; width: 44px; height: 24px;">
                        <input type="checkbox" style="opacity: 0; width: 0; height: 0;"
                            <?php echo $i % 2 === 0 ? 'checked' : ''; ?>>
                        <span class="toggle-slider"
                            style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px;"></span>
                    </label>
                </div>
                <div style="color: #888; font-size: 14px;">
                    동적으로 로드된 고급 설정 옵션입니다. 각종 시스템 동작을 제어할 수 있습니다.
                </div>
            </div>
            <?php endfor; ?>
        </div>

        <div style="text-align: center; padding: 40px 0; color: #888;">
            <p>시스템 설정 동적 로딩 완료!</p>
        </div>
    </div>
</div>

<script>
// 설정 초기화 함수
function initSettings() {
    console.log('Settings initialized!');

    // 설정 항목 클릭 이벤트
    const settingsItems = document.querySelectorAll('.settings-item');
    settingsItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            console.log(`Settings item ${index + 1} clicked!`);
            // 실제 설정 페이지로 이동하거나 모달 표시
        });

        // 호버 효과
        item.addEventListener('mouseenter', () => {
            item.style.opacity = '0.8';
        });

        item.addEventListener('mouseleave', () => {
            item.style.opacity = '1';
        });
    });

    // 토글 스위치 이벤트
    const toggles = document.querySelectorAll('.toggle-switch input[type="checkbox"]');
    toggles.forEach((toggle, index) => {
        toggle.addEventListener('change', (e) => {
            console.log(`Toggle ${index + 1} changed to: ${e.target.checked}`);

            // 스위치 애니메이션
            const slider = toggle.nextElementSibling;
            if (e.target.checked) {
                slider.style.backgroundColor = 'var(--color-blue)';
                slider.style.boxShadow = '0 0 1px var(--color-blue)';
            } else {
                slider.style.backgroundColor = '#ccc';
                slider.style.boxShadow = 'none';
            }
        });

        // 초기 상태 설정
        if (toggle.checked) {
            const slider = toggle.nextElementSibling;
            slider.style.backgroundColor = 'var(--color-blue)';
        }
    });
}
</script>