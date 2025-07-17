<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'My App') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- 공통 CSS -->
    <link rel="stylesheet"
        href="/assets/css/common.css?v=<?= filemtime(__DIR__.'/../../../public/assets/css/common.css') ?>">

    <!-- 모듈별 CSS (있으면) -->
    <?php if (!empty($module)): ?>
    <link rel="stylesheet"
        href="/assets/<?= $module ?>/<?= $module ?>.css?v=<?= filemtime(__DIR__."/../../../public/assets/{$module}/{$module}.css") ?>">
    <?php endif; ?>
</head>

<body>