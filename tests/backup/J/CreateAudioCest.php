<?php

class CreateAudioCest extends BaseCest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function _before(AcceptanceTester $I)
    {
        $I->maximizeWindow();
        $I->login();
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function testCreateNewAudio(AcceptanceTester $I)
    {
        $I->selectProject($I);

        $I->click('音源');
        $I->wait(1);
        $I->click('新規音源追加');
        $I->wait(1);

        // 配信用ジャンルチェック
        $I->waitForElementVisible('#genre_digital_code');
        $I->seeOptionText('#genre_digital_code', 'J-Pop');

        // デフォルト「該当なし」チェック
        $I->see('該当なし', '.ant-radio-wrapper-checked');

        // メインアーティスト反映チェック
        $I->seeInField('#artist_code_project', 126);
        $I->seeInField('#artist_name_project', 'DJ デクストラス');

        // デフォルト2020チェック
        $I->seeInField('#p_year', '2020');

        // 他社フラグ
        // TODO

        // GRPS
        // TODO

        // パーティシパント
        // TODO

        $audioName = $this->faker->unique()->text(10);
        $I->selectOptionCustom('#artist_domestic', 'DJ デクストラス');
        $I->fillField('#asset_name_1_domestic', $audioName);
        $I->fillField('#asset_name_1_kana', 'カナ');
        $I->fillField('#asset_name_1_en', $this->faker->unique()->text(10));
        $I->selectOptionCustom('#p_company_name', 'Sony Music Labels Inc.');
        $I->click('登 録');
        $I->wait(1);
        $I->click('はい', 'body > div:last-child');
        $I->wait(1);
        $I->waitForText($audioName, 10, '#container-soundExisting');
    }

    public function testCreateFromExistAudio(AcceptanceTester $I)
    {
        $I->selectProject($I);

        $audioName = $I->getAudioname();

        $I->click('音源');
        $I->wait(1);
        $I->click('既存音源追加');
        $I->wait(1);

        /*
        デフォルトでは何も候補を表示しない。
        検索してから結果を表示する。
        */
        // TODO

        /*
        アセット一覧（ライブラリ）への追加方法は2通り。
        追加したいアセットにチェックをつけ、
        ①まとめてドラッグ＆ドロップ
        ②「追加」ボタンをクリック
        */
        // TODO

        $I->fillField('input[placeholder="検索ワードを入力してください"]', $audioName);
        $I->click('検 索');
        $I->waitForText($audioName, 60, '#container-soundAvailable');
        $I->waitForElementVisible('.ant-drawer-wrapper-body div[data-react-beautiful-dnd-draggable]:nth-child(1) .ant-checkbox-wrapper');
        $I->click('.ant-drawer-wrapper-body div[data-react-beautiful-dnd-draggable]:nth-child(1) .ant-checkbox-wrapper');
        $I->wait(1);
        $I->click('追 加');
        $I->waitForText($audioName, 10, '#container-soundExisting');
    }

}
