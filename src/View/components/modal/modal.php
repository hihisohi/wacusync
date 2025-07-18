<?php
// $id        : 모달 고유 ID
// $title     : 모달 헤더 타이틀
// $body      : 모달 본문(html 문자열)
// $footer    : 모달 푸터(html 문자열, 버튼 등)
?>
<div id="<?= htmlspecialchars($id) ?>" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php if (!empty($title)): ?>
            <div class="modal-header">
                <h5 class="modal-title"><?= htmlspecialchars($title) ?></h5>
                <button type="button" class="close" data-action="closeModal"
                    data-target="<?= htmlspecialchars($id) ?>">&times;</button>
            </div>
            <?php endif; ?>

            <div class="modal-body">
                <?= $body /* 이미 escape 처리된 HTML이면 그대로 출력 */ ?>
            </div>

            <?php if (!empty($footer)): ?>
            <div class="modal-footer">
                <?= $footer ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>