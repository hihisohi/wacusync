<!-- 
 웹서버가 처음으로 요청을 전달하는 Front Controller 역할을 합니다. 
 모든 HTTP 요청(예: /, /login, /api/data)이 이 한 파일로 들어오고, 
 이 파일에서 애플리케이션을 부트스트랩한 뒤에 내부 라우터에 넘겨서 적절한 컨트롤러로 전달


이렇게 public/index.php 하나만 웹서버에 노출시키고, 
나머지 비즈니스 로직(컨트롤러, 모델, 뷰 등)은 src/나 app/ 디렉터리 안에 안전하게 감추는 구조가 모던 PHP 애플리케이션의 기본 패턴입니다. 

이 방식을 쓰면:

라우팅·미들웨어 로직을 한 곳에서 관리

보안상 public/ 외부는 절대 직접 노출되지 않음

PSR-4 오토로딩으로 클래스를 간편하게 관리

등의 이점을 얻을 수 있습니다.
-->


<?php
// 1. 에러 리포팅
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. 세션/오토로더/설정 등 필요하다면
session_start();
// require __DIR__ . '/../vendor/autoload.php';
// $config = require __DIR__ . '/../config/app.php';

// 3. 요청 경로 파싱
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$page = trim($uri, '/');         // '/dashboard' → 'dashboard'

if ($page === '') {
    $page = 'home';
}

// 4. 라우트 정의 (페이지명 → 뷰 또는 콜러블)
$routes = [
    'home' => function() {
        $title  = 'Home';
        $module = 'home';
        $view   = __DIR__ . '/../src/view/home/index.php';
        include __DIR__ . '/../src/view/layouts/index.php';
    },

    'login' => function() {
        $title  = 'Login';
        $module = 'login';
        $view   = __DIR__ . '/../src/view/auth/login.php';
        include __DIR__ . '/../src/view/layouts/index.php';
    },
    'find-id' => function() {
        $title  = 'Find ID';
        $module = 'find-id';
        $view   = __DIR__ . '/../src/view/auth/find-id.php';
        include __DIR__ . '/../src/view/layouts/index.php';
    },
    'find-pw' => function() {
        $title  = 'Find PW';
        $module = 'find-pw';
        $view   = __DIR__ . '/../src/view/auth/find-pw.php';
        include __DIR__ . '/../src/view/layouts/index.php';
    },
    'dashboard' => function() {
        $title  = 'Dashboard';
        $module = 'dashboard';
        $view   = __DIR__ . '/../src/view/dashboard/index.php';
        include __DIR__ . '/../src/view/layouts/index.php';
    },
    'stats'     => function() {
        $title  = 'Stats';
        $module = 'stats';
        $view   = __DIR__ . '/../src/view/stats/index.php';
        include __DIR__ . '/../src/view/layouts/index.php';
    },
    'mypage' => function() {
        $title  = 'Mypage';
        $module = 'mypage';
        $view   = __DIR__ . '/../src/view/mypage/index.php';
        include __DIR__ . '/../src/view/layouts/index.php';
    },
    'settings' => function() {
        $title  = 'Settings';
        $module = 'settings';
        $view   = __DIR__ . '/../src/view/settings/index.php';
        include __DIR__ . '/../src/view/layouts/index.php';
    },
];

// 5. 라우트 실행 또는 404
if (isset($routes[$page])) {
    $routes[$page]();
} else {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Not Found</h1>";
}