<?php

class CreateVideoCest extends BaseCest
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

    public function testCreateNewVideoWithoutAudio(AcceptanceTester $I)
    {
        $I->selectProject($I);

        $I->click('画源');
        $I->wait(1);
        $I->click('新規画源追加');
        $I->wait(1);

        // チェック
        // TODO

        $I->selectOptionCustom('#original_recording_possession_label_name', '（株）ｿﾆｰ･ﾐｭｰｼﾞｯｸｴﾝﾀﾃｲﾝﾒﾝﾄ');

        $videoName = $this->faker->unique()->text(10);
        $I->selectOptionCustom('#artist_domestic', 'DJ デクストラス');
        $I->fillField('#asset_name_1_domestic', $videoName);
        $I->fillField('#asset_name_1_kana', 'カナ');
        $I->fillField('#asset_name_1_en', $this->faker->unique()->text(10));
        $I->click('.Pane2 > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(3) > div:nth-child(1) > .ant-checkbox-wrapper');
        $I->wait(1);
        $I->click('登 録');
        $I->waitForText('登録してよろしいですか？');
        $I->click('はい');
        $I->wait(1);
        $I->waitForText($videoName, 10, '#container-video');
    }

    public function testCreateNewVideoWithExistAudio(AcceptanceTester $I)
    {
        $I->selectProject($I);

        $audioName = $I->getAudioname();

        $I->click('画源');
        $I->wait(1);
        $I->click('新規画源追加');
        $I->wait(1);

        $I->selectOptionCustom('#original_recording_possession_label_name', '（株）ｿﾆｰ･ﾐｭｰｼﾞｯｸｴﾝﾀﾃｲﾝﾒﾝﾄ');

        $videoName = $this->faker->unique()->text(10);
        $I->selectOptionCustom('#artist_domestic', 'DJ デクストラス');
        $I->fillField('#asset_name_1_domestic', $videoName);
        $I->fillField('#asset_name_1_kana', 'カナ');
        $I->fillField('#asset_name_1_en', $this->faker->unique()->text(10));

        $I->click('音源から 著作情報を作成');
        $I->waitForElement('input[placeholder="検索ワードを入力してください"]');
        $I->fillField('input[placeholder="検索ワードを入力してください"]', $audioName);
        $I->click('検 索');
        $I->waitForText($audioName, 60, '#dragOrderTable-soundChildAvailable');
        $I->wait(1);
        $I->click('#container-soundChildAvailable div[data-react-beautiful-dnd-draggable]:nth-child(1) .ant-checkbox-wrapper');
        $I->click('追 加');
        $I->waitForText('GRPS連携(関連音源として連携)の選択');
        $I->executeJS('document.querySelector(\'.ant-modal-mask\').style.display = \'none\';');
        $I->wait(1);
        $I->click('.ant-modal-body > div:nth-child(7) .ant-btn-primary');
        $I->waitForText('使用楽曲著作情報登録');
        $I->wait(1);
        $I->selectOptionCustom('.ant-modal-body #artist_domestic', 'DJ デクストラス');
        $videoName1 = $this->faker->unique()->text(10);
        $I->fillField('.ant-modal-body #asset_name_1_domestic', $videoName1);
        $I->fillField('.ant-modal-body #asset_name_1_kana', 'カナ');
        $I->fillField('.ant-modal-body #asset_name_1_en', $this->faker->unique()->text(10));
        $I->fillField('.ant-modal-body #p_year', '2020');
        $I->selectOptionCustom('#language_code', 'Bulgarian');
        $I->selectOptionCustom('#p_company_name_en', 'Sony Music Labels Inc.');
        $I->click('登 録', 'body > div:last-child');
        $I->waitForText('登録してよろしいですか？');
        $I->click('はい');
        $I->wait(1);
        $I->click('.ant-drawer-close');
        $I->wait(1);
        $I->waitForText($videoName1, 10,'#container-soundOfVideo');
        $I->click('登 録');
        $I->waitForText('登録してよろしいですか？');
        $I->click('はい');
        $I->waitForText($videoName, 10);
    }

    public function testCreateNewVideoWithExistAudioAndGoToCreateAudio(AcceptanceTester $I)
    {
        $I->selectProject($I);

        $audioName = $I->getAudioname();

        $I->click('画源');
        $I->wait(1);
        $I->click('新規画源追加');
        $I->wait(1);

        $I->selectOptionCustom('#original_recording_possession_label_name', '（株）ｿﾆｰ･ﾐｭｰｼﾞｯｸｴﾝﾀﾃｲﾝﾒﾝﾄ');

        $videoName = $this->faker->unique()->text(10);
        $I->selectOptionCustom('#artist_domestic', 'DJ デクストラス');
        $I->fillField('#asset_name_1_domestic', $videoName);
        $I->fillField('#asset_name_1_kana', 'カナ');
        $I->fillField('#asset_name_1_en', $this->faker->unique()->text(10));

        $I->click('音源から 著作情報を作成');
        $I->wait(1);
        $I->click('新規音源登録する');
        $I->waitForText('新規音源追加');
    }

    public function testCreateFromExistVideoAndGoToCreateAudio(AcceptanceTester $I)
    {
        $I->selectProject($I);

        $audioName = $I->getAudioname();

        $I->click('画源');
        $I->wait(1);
        $I->click('新規画源追加');
        $I->wait(1);

        $I->selectOptionCustom('#original_recording_possession_label_name', '（株）ｿﾆｰ･ﾐｭｰｼﾞｯｸｴﾝﾀﾃｲﾝﾒﾝﾄ');

        $videoName = $this->faker->unique()->text(10);
        $I->selectOptionCustom('#artist_domestic', 'DJ デクストラス');
        $I->fillField('#asset_name_1_domestic', $videoName);
        $I->fillField('#asset_name_1_kana', 'カナ');
        $I->fillField('#asset_name_1_en', $this->faker->unique()->text(10));

        $I->click('著作情報を 手作業で作成');
        $I->wait(1);
        $I->click('音源登録へ');
        $I->waitForText('新規音源追加');
    }

    public function testCreateFromExistVideoAndGoToCreateVideo(AcceptanceTester $I)
    {
        $I->selectProject($I);

        $I->click('画源');
        $I->wait(1);
        $I->click('新規画源追加');
        $I->wait(1);

        $I->selectOptionCustom('#original_recording_possession_label_name', '（株）ｿﾆｰ･ﾐｭｰｼﾞｯｸｴﾝﾀﾃｲﾝﾒﾝﾄ');

        $videoName = $this->faker->unique()->text(10);
        $I->selectOptionCustom('#artist_domestic', 'DJ デクストラス');
        $I->fillField('#asset_name_1_domestic', $videoName);
        $I->fillField('#asset_name_1_kana', 'カナ');
        $I->fillField('#asset_name_1_en', $this->faker->unique()->text(10));

        $I->click('著作情報を 手作業で作成');
        $I->wait(1);
        $I->click('登録画面へ');

        $I->waitForText('使用楽曲著作情報登録');
        $I->wait(1);
        $I->selectOptionCustom('.ant-modal-body #artist_domestic', 'DJ デクストラス');
        $videoName1 = $this->faker->unique()->text(10);
        $I->fillField('.ant-modal-body #asset_name_1_domestic', $videoName1);
        $I->fillField('.ant-modal-body #asset_name_1_kana', 'カナ');
        $I->fillField('.ant-modal-body #asset_name_1_en', $this->faker->unique()->text(10));
        $I->selectOptionCustom('.ant-modal-body #language_code', 'Bulgarian');
        $I->selectOptionCustom('.ant-modal-body #p_company_name_en', 'Sony Music Labels Inc.');
        $I->click('登 録', 'body > div:last-child');
        $I->waitForText('登録してよろしいですか？');
        $I->click('はい', 'body > div:last-child');
        $I->wait(1);
        $I->waitForText($videoName1, 10, '#container-soundOfVideo');
        $I->click('登 録');
        $I->waitForText('登録してよろしいですか？');
        $I->click('はい', 'body > div:last-child');
        $I->waitForText($videoName, 10);
    }
}
