<?php
namespace src\Controller;

// use src\Service\DashboardService;

class DashboardController
{
    private DashboardService $dashboardService;
    private array $config;

    /**
     * 생성자에서 서비스와 설정을 주입합니다.
     *
     * @param DashboardService $dashboardService
     * @param array        $config
     */
    public function __construct(array $config) // DashboardService $dashboardService, 
    {
        // $this->dashboardService = $dashboardService;
        $this->config       = $config;
    }

    /**
     * GET /dashboard
     * 로그인된 사용자에게 메인 대시보드를 보여줍니다.
     */
    public function index(): void
    {
        // 1. 인증 검사
        // session_start();
        // if (empty($_SESSION['user'])) {
        //     header('Location: ' . $this->config['base_url'] . '/login');
        //     exit;
        // }

        // 2. 대시보드에 필요한 데이터 조회
        // $userId      = $_SESSION['user']['id'];
        // $stats       = $this->statsService->getOverviewStats($userId);
        // $recentSales = $this->statsService->getRecentSales($userId);

        // 3. 뷰에 전달할 변수 설정
        $title       = '대시보드';
        $module      = 'dashboard';
        $view        = __DIR__ . '/../View/dashboard/index.php';

        // 4. 공통 레이아웃에 변수 바인딩 후 렌더링
        include __DIR__ . '/../View/layouts/index.php';
    }
}