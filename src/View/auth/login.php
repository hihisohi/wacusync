<?php
// 모달 컴포넌트 불러오기 전용 헬퍼 함수
function renderComponent($name, $data = []) {
    extract($data);
    include __DIR__ . "/../components/{$name}.php";
}

// 대시보드 페이지
?>

<head>
    <!-- 모듈별 CSS 로드... -->
    <link rel="stylesheet" href="/pubilc/assets/css/modal.css" />
</head>

<body>
    <h1>대시보드</h1>
    <button onclick="showModal('user-info-modal')">유저 정보 보기</button>

    <?php
        renderComponent('modal', [
        'id'     => 'user-info-modal',
        'title'  => '유저 정보',
        'body'   => '<p>이름: 홍길동</p><p>가입일: 2025-01-01</p>',
        'footer' => '<button data-dismiss="modal">닫기</button>',
        ]);
    ?>

    <script src="/pubilc/assets/js/common.js"></script>
</body>