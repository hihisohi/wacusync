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

    <!-- 폰트 -->
    <link rel="stylesheet" href="/assets/fonts/font.css">

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
        $moduleCssPath = "/assets/css/{$module}/{$module}.css";
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


    <!-- lib : gsap -->
    <script src="/assets/js/lib/gsap/gsap.min.js"></script>
    <script src="/assets/js/lib/gsap/ScrollTrigger.min.js"></script>

    <!-- lib : chartjs -->
    <script src="/assets/js/lib/chartjs/chart.js"></script>
    <script src="/assets/js/lib/chartjs/chartjs-adapter-date-fns.bundle.min.js"></script>

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
        $moduleJsPath = "/assets/js/{$module}/{$module}.js";
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
    <?php include __DIR__ . '/../components/tabBar/tabBar.php'; ?>
    <!-- END :: TAB BAR -->

    <!-- START :: WRAP -->
    <div class="wrap">