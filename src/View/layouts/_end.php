<footer>

</footer>

<!-- 공통 JS -->
<script src="/assets/js/common.js?v=<?= filemtime(__DIR__.'/../../../public/assets/js/common.js') ?>"></script>

<!-- 모듈별 JS (있으면) -->
<?php if (!empty($module)): ?>
<script
    src="/assets/<?= $module ?>/<?= $module ?>.js?v=<?= filemtime(__DIR__."/../../../public/assets/{$module}/{$module}.js") ?>">
</script>
<?php endif; ?>

</body>

</html>