<div class="l-inner">
    <div class="l-title-box m-b-30">
        <div class="l-title">통계 분석</div>
    </div>

    <div>
        <h2 style="color: var(--color-blue); margin-bottom: 20px;">월별 통계</h2>

        <!-- 스크롤 테스트를 위한 더미 통계 데이터 -->
        <?php for($i = 1; $i <= 15; $i++): ?>
        <div
            style="background: var(--color-secondary-bg); border: 1px solid var(--color-secondary-border); border-radius: 8px; padding: 20px; margin-bottom: 15px;">
            <h3 style="color: var(--color-main-text); margin-bottom: 10px;">통계 항목 <?php echo $i; ?></h3>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="color: #888;">값</span>
                <span style="color: var(--color-blue); font-weight: bold;"><?php echo random_int(100, 9999); ?></span>
            </div>
            <div style="margin-top: 10px; color: #666; font-size: 14px;">
                동적으로 로드된 통계 데이터입니다.
                세로로 스크롤하여 모든 데이터를 확인할 수 있습니다.
            </div>

            <!-- 가짜 차트 영역 -->
            <div
                style="width: 100%; height: 60px; background: linear-gradient(90deg, var(--color-blue) 0%, transparent 100%); margin-top: 15px; border-radius: 4px; opacity: 0.3;">
            </div>
        </div>
        <?php endfor; ?>

        <div style="text-align: center; padding: 40px 0; color: #888;">
            <p>통계 분석 동적 로딩 완료!</p>
        </div>
    </div>
</div>

<script>
// 통계 초기화 함수
function initStats() {
    console.log('Stats initialized!');

    // 통계 특화 로직
    const charts = document.querySelectorAll('.flick-panel[data-section="stats"] div[style*="linear-gradient"]');
    charts.forEach((chart, index) => {
        chart.addEventListener('click', () => {
            console.log(`Stats chart ${index + 1} clicked!`);
            // 여기서 실제 차트 라이브러리 초기화 가능
        });
    });
}
</script>