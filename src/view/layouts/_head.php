<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'My App') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    // 파일 존재 여부와 filemtime을 안전하게 확인하는 헬퍼 함수
    function getFileVersionParam($relativePath) {
        $publicPath = __DIR__ . '/../../../public' . $relativePath;
        if (file_exists($publicPath)) {
            return '?v=' . filemtime($publicPath);
        }
        return '';
    }
    ?>

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Peddana&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- 폰트 -->
    <link rel="stylesheet" href="/assets/fonts/font.css">

    <!-- lib : axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- lib : gsap -->
    <script src="/assets/js/lib/gsap/gsap.min.js"></script>
    <script src="/assets/js/lib/gsap/ScrollTrigger.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js"></script> -->

    <!-- lib : chartjs -->
    <script src="/assets/js/lib/chartjs/chart.js"></script>
    <script src="/assets/js/lib/chartjs/chartjs-adapter-date-fns.bundle.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script> -->

    <!-- lib : flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- 공통 CSS -->
    <?php
        $resetCssPath = '/assets/css/reset.css';
        $commonCssPath = '/assets/css/common.css';
        $layoutCssPath = '/assets/css/layout.css';
        $tabBarCssPath = '/assets/css/components/tabBar/tabBar.css';
        $flickingCssPath = '/assets/css/flicking.css';
    ?>
    <link rel="stylesheet" href="<?= $resetCssPath . getFileVersionParam($resetCssPath) ?>">
    <link rel="stylesheet" href="<?= $commonCssPath . getFileVersionParam($commonCssPath) ?>">
    <link rel="stylesheet" href="<?= $layoutCssPath . getFileVersionParam($layoutCssPath) ?>">
    <link rel="stylesheet" href="<?= $tabBarCssPath . getFileVersionParam($tabBarCssPath) ?>">
    <link rel="stylesheet" href="<?= $flickingCssPath . getFileVersionParam($flickingCssPath) ?>">

    <!-- 모듈별 CSS (있으면) -->
    <?php if (!empty($module)): ?>
    <?php
        $moduleCssPath = "/assets/css/view/{$module}/{$module}.css";
        $modulePublicPath = __DIR__ . "/../../../public" . $moduleCssPath;
        if (file_exists($modulePublicPath)):
    ?>
    <link rel="stylesheet" href="<?= $moduleCssPath . getFileVersionParam($moduleCssPath) ?>">
    <?php endif; ?>
    <?php endif; ?>

    <!-- 페이지별 추가 CSS -->
    <?php if (!empty($cssFiles) && is_array($cssFiles)): ?>
    <?php foreach($cssFiles as $css): ?>
    <?php
        $cssPublicPath = __DIR__ . '/../../../public' . $css;
        if (file_exists($cssPublicPath)):
    ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($css) . getFileVersionParam($css) ?>">
    <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>

    <!-- 공통 JS -->
    <?php
        $commonJsPath = '/assets/js/common.js';
        $commonJsPublicPath = __DIR__ . '/../../../public' . $commonJsPath;
        if (file_exists($commonJsPublicPath)):
    ?>
    <script defer type="module" src="<?= $commonJsPath . getFileVersionParam($commonJsPath) ?>"></script>
    <?php endif; ?>

    <!-- 모듈별 JS (있으면) -->
    <?php if (!empty($module)): ?>
    <?php
        $moduleJsPath = "/assets/js/view/{$module}/{$module}.js";
        $moduleJsPublicPath = __DIR__ . "/../../../public" . $moduleJsPath;
        if (file_exists($moduleJsPublicPath)):
    ?>
    <script defer type="module" src="<?= $moduleJsPath . getFileVersionParam($moduleJsPath) ?>"></script>
    <?php endif; ?>
    <?php endif; ?>

    <!-- 페이지별 추가 JS -->
    <?php if (!empty($jsFiles) && is_array($jsFiles)): ?>
    <?php foreach($jsFiles as $js): ?>
    <?php
        $jsPublicPath = __DIR__ . '/../../../public' . $js;
        if (file_exists($jsPublicPath)):
    ?>
    <script defer type="module" src="<?= htmlspecialchars($js) . getFileVersionParam($js) ?>"></script>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>

    <!-- START :: TAB BAR -->
    <?php 
    // tabBar를 숨길 모듈 리스트
    $showTabBarModules = ['dashboard', 'stats', 'mypage', 'settings'];
    if (in_array($module ?? '', $showTabBarModules)): 
    ?>
    <?php include __DIR__ . '/../../components/tabBar/tabBar.php'; ?>
    <?php endif; ?>
    <!-- END :: TAB BAR -->

    <!-- START :: WRAP -->
    <div class="wrap">