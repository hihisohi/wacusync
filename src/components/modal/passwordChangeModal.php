<div id="password-change-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn--close" data-action="closePasswordChangeModal">
                    <span class="icon icon--go-back">
                        <span class="blind">뒤로가기</span>
                    </span>
                </button>
                <div class="modal-header__title">비밀번호 변경</div>
            </div>

            <div class="modal-body">
                <div class="modal-body__content">
                    <form action="" class="password-change-form" id="passwordChangeForm">
                        <div class="form-row">
                            <label for="currentPassword" class="blind">기존 비밀번호</label>
                            <div class="input-item">
                                <input id="currentPassword" type="password" placeholder="기존 비밀번호" required autocomplete="off">
                            </div>
                            <div class="error-message" data-input-error="currentPassword"></div>
                        </div>
                        <div class="form-row">
                            <label for="newPassword" class="blind">새 비밀번호</label>
                            <div class="input-item">
                                <input id="newPassword" type="password" placeholder="새 비밀번호" required autocomplete="off">
                            </div>
                            <div class="error-message" data-input-error="newPassword"></div>
                        </div>
                        <div class="form-row">
                            <label for="newPasswordConfirm" class="blind">새 비밀번호 확인</label>
                            <div class="input-item">
                                <input id="newPasswordConfirm" type="password" placeholder="새 비밀번호 확인" required autocomplete="off">
                            </div>
                            <div class="error-message" data-input-error="newPasswordConfirm"></div>
                        </div>
                        <div class="form-actions">
                            <!-- 나중에 btn-close 빼기 -->
                            <button type="button" class="btn btn--default full sm btn--close" data-action="closePasswordChangeModal">
                                변경하기
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>