<?php
// 뷰 파일에서 정의될 수 있는 변수들을 미리 초기화
$cssFiles = [];
$jsFiles = [];

// 뷰 파일을 먼저 include하여 그 안에서 정의된 변수들을 가져옴
if (isset($view) && file_exists($view)) {
    // 뷰 파일의 출력을 버퍼링
    ob_start();
    include $view;
    $content = ob_get_clean();
}

// 이제 헤드 부분 출력 (뷰에서 정의된 cssFiles, jsFiles 사용 가능)
include __DIR__ . '/_head.php';

// 뷰 컨텐츠 출력
echo $content ?? '';

// 푸터 부분 출력
include __DIR__ . '/_end.php';
?>