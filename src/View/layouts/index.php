<?php
// index.php: header + view + footer 를 묶는 엔트리
// $title  : 페이지 제목
// $module : 현재 모듈명 (e.g. 'dashboard', 'stats')
// $view   : 렌더링할 뷰 파일 경로
include __DIR__ . '/_head.php';
include $view;
include __DIR__ . '/_end.php';