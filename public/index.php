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


<!-- <?php

// 1. 에러 리포팅 및 환경 초기화
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
// session_start();

// 2. 오토로더 로드 (Composer, 또는 PSR-4 오토로딩)
// require __DIR__ . '/../vendor/autoload.php';

// 3. 설정 파일 로드
// $config = require __DIR__ . '/../config/app.php';

// 4. 간단한 라우터 초기화 (FastRoute 예시)
use FastRoute\RouteCollector;

$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
    // URL 패턴 ↔ 컨트롤러 매핑
    $r->addRoute('GET',  '/',           ['src\Controller\HomeController',   'index']);
    $r->addRoute('GET',  '/login',      ['src\Controller\AuthController',   'showLoginForm']);
    $r->addRoute('POST', '/login',      ['src\Controller\AuthController',   'login']);
    $r->addRoute('GET',  '/api/data',   ['src\Controller\Api\DataController','fetch']);
    $r->addRoute('GET', '/dashboard',   ['src\Controller\DashboardController','index']);
    // ... 그 외 라우트들
});

// 5. 현재 요청 URI와 메서드 파싱
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

// 6. 라우팅 실행
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        header("HTTP/1.0 404 Not Found");
        echo '404 페이지를 찾을 수 없습니다.';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        header("HTTP/1.0 405 Method Not Allowed");
        echo '허용되지 않는 HTTP 메서드입니다.';
        break;
    case FastRoute\Dispatcher::FOUND:
        list(, $handler, $vars) = $routeInfo;
        list($controllerClass, $method) = $handler;
        // 7. 컨트롤러 인스턴스 생성 후 메서드 호출
        $controller = new $controllerClass($config);
        call_user_func_array([$controller, $method], $vars);
        break;
}

?> -->


<?php
// 페이지 파라미터에 따라 뷰를 결정하는 간단한 프론트 스터브
$page   = $_GET['page'] ?? 'dashboard';

$allowed = ['dashboard', 'stats'];

if (!in_array($page, $allowed)) {
    $page = 'dashboard';
}

$module = $page;
$title  = ucfirst($page) . ' | My CRM';
$view   = __DIR__ . '/../src/View/' . $page . '/index.php';

include __DIR__ . '/../src/View/layouts/index.php';