<div class="dashboard">
    <h1>대시보드</h1>
    <p>환영합니다! 이곳은 대시보드 페이지입니다.</p>

    <div class="dashboard-grid">
        <div class="card">
            <h3>사용자 통계</h3>
            <p>총 사용자: 1,234명</p>
        </div>

        <div class="card">
            <h3>최근 활동</h3>
            <p>오늘 로그인: 56명</p>
        </div>
    </div>
</div>

<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: 1px solid #e0e0e0;
}

.card h3 {
    margin-top: 0;
    color: #333;
}
</style>