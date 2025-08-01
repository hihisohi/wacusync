<?php
// 해당 뷰에서 필요한 컴포넌트의 CSS/JS 파일을 배열로 등록
$cssFiles = [
    '/assets/css/components/modal/settingOptionModal.css',
  ];
  
$jsFiles = [
    '/assets/js/components/modal/settingOptionModal.js',
];

// 컴포넌트 불러오기 전용 헬퍼 함수
function renderComponent($name, $data = []) {
    extract($data);
    include __DIR__ . "/../components/{$name}.php";
}
?>

<div class="settings l-container">
    <div class="l-title-box">
        <div class="l-inner">
            <div class="l-title">시스템 설정</div>
        </div>
    </div>
    <div class="l-gap-box"></div>

    <div class="settings__content">
        <div class="l-grid settings-grid">
            <div class="l-grid__item">
                <div class="list">
                    <div class="list__title">
                        <div class="list__item-inner l-inner">
                            데이터 동기화 설정
                        </div>
                    </div>
                    <div class="list__item">
                        <div class="list__item-inner l-inner">
                            <div class="list__item-text">
                                CRM 자동화
                            </div>
                            <div class="list__item-button">
                                <div class="btn--switch" data-setting="crm-sync">
                                    <input type="checkbox" name="crm-sync" class="swtich" />
                                    <div class="swtich__knob"></div>
                                    <div class="swtich__bg"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list__item">
                        <div class="list__item-inner l-inner">
                            <div class="list__item-text">
                                홈페이지 데이터 동기화
                            </div>
                            <div class="list__item-button">
                                <div class="btn--switch" data-setting="homepage-sync">
                                    <input type="checkbox" name="homepage-sync" class="swtich" />
                                    <div class="swtich__knob"></div>
                                    <div class="swtich__bg"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list__item">
                        <div class="list__item-inner l-inner">
                            <div class="list__item-text">
                                동기화 주기
                            </div>
                            <div class="list__item-button">
                                <button type="button" class="btn--setting" data-setting="sync-cycle">
                                    실시간
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="l-gap-box"></div>

            <div class="l-grid__item">
                <div class="list">
                    <div class="list__title">
                        <div class="list__item-inner l-inner">
                            보고서 설정
                        </div>
                    </div>
                    <div class="list__item">
                        <div class="list__item-inner l-inner">
                            <div class="list__item-text">
                                주간 보고서
                            </div>
                            <div class="list__item-button">
                                <div class="btn--switch" data-setting="weekly-report">
                                    <input type="checkbox" name="weekly-report" class="swtich" />
                                    <div class="swtich__knob"></div>
                                    <div class="swtich__bg"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list__item">
                        <div class="list__item-inner l-inner">
                            <div class="list__item-text">
                                월간 보고서
                            </div>
                            <div class="list__item-button">
                                <div class="btn--switch" data-setting="monthly-report">
                                    <input type="checkbox" name="monthly-report" class="swtich" />
                                    <div class="swtich__knob"></div>
                                    <div class="swtich__bg"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list__item">
                        <div class="list__item-inner l-inner">
                            <div class="list__item-text">
                                보고서 포맷
                            </div>
                            <div class="list__item-button">
                                <button type="button" class="btn--setting" data-setting="report-format">
                                    PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
    renderComponent('modal/settingOptionModal');
?>