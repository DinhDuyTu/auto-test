<?php

class BasicInfoCest extends BaseCest
{
    protected $projectId;
    protected $projectId2;
    protected $title;
    protected $title2;

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

    public function testCreateBasicInfo(AcceptanceTester $I)
    {
        $today = \Carbon\Carbon::today();
        $today = $today->format('Y年n月j日');

        $this->projectId = $I->createProject($I);
        $I->click('パッケージ');
        $I->waitForText('パッケージ企画タイトル');

        // パッケージにメインアーティストとジャンル連携チェック
        $I->click('#pkg_release_date');
        $I->wait(1);
        $I->click('.ant-calendar-cell[title="'. $today .'"]');
        $I->wait(1);
        $I->click('登 録');
        $I->wait(1);
        $I->click('はい');
        $I->waitForText('新規追加');
    }

    public function testCreatePackageProductBasicInfo(AcceptanceTester $I)
    {
        $I->selectProject($I, $this->projectId);

        $I->click('基本情報');
        $I->wait(1);
        $I->click('新規追加');
        $I->wait(1);
        $I->waitForText('パッケージ基本情報登録');

        $taxExcluedPrice = $this->faker->numberBetween(1000, 9999);

        $this->title = $this->faker->unique()->text(10);

        $I->selectOptionCustom('#category_code', 'オーディオ-AUDIO-C');
        $I->fillField('#title_domestic', $this->title);
        $I->fillField('#title_kana', 'カナ');
        $I->fillField('#title_en', $this->faker->unique()->text(10));
        $I->fillField('#tax_exclued_price', $taxExcluedPrice);
        $I->click('自動計算');
        $I->click('自動計算');
        $I->selectOptionCustom('#ln_prhbtn_code', '洋楽禁止 (Y)(X)');
        $I->selectOptionCustom('#sales_classification_code', '再販対象');
        $I->fillField('#estimate_tax_excluded_price__0', $taxExcluedPrice);
        $I->click('#header-button-estimate_tax_excluded_price');
        $I->selectOptionCustom('#c_line__0', 'Sony Music Labels Inc.');
        $I->click('登 録');
        $I->wait(1);
        $I->click('はい');
        $I->wait(1);
        $I->waitForText($this->title);
        $I->click('//*[@id="container-packageBasicInfo"]/div/div[2]/div/div/div[1]/div[3]/div');
        $I->waitForText('パッケージ基本情報登録');
    }

    // 4. 作業が完了したタイミングで「会議上程・発決依頼」をクリック。会議資料の出力や品番POS取得はARISにて実施
    // TODO

    public function testCreateMusicOrderGuide(AcceptanceTester $I)
    {
        $I->selectProject($I, $this->projectId);

        $I->wait(1);
        $I->waitForText('新譜案内原稿');
        $I->click('新譜案内原稿');
        $I->waitForText('新譜案内原稿');
        $I->selectOptionCustom('#sales_genre_code', '203 - Pops');
        $I->click('一時保存');
        $I->wait(1);
        $I->click('はい');
        $I->waitForText('保存しました');
        $I->waitForElementNotVisible('.ant-message-notice-content');
        $I->click('保 存');
        $I->wait(1);
        $I->click('はい');
        $I->waitForText('保存しました');
    }

    // 6. レーベルコピーの登録（音源の場合）
    public function testRegisterLabelCopySoundReset(AcceptanceTester $I)
    {
        $soundName1 = $this->faker->unique()->text(10);
        $soundName2 = $this->faker->unique()->text(10);
        $I->selectProject($I, $this->projectId);

        $I->wait(1);
        $I->createAudio($I, $soundName1);
        $I->createAudio($I, $soundName2);
        $I->click('//*[@id="root"]/div/section/main/div/main/div[1]/div[1]/div/div[4]/div/div[2]/a');
        $I->wait(1);
        $I->click('アセット追加');
        $I->wait(1);
        $I->click('div.ant-spin-nested-loading > div > div > div:nth-child(1) > div > label');
        $I->click('div.ant-spin-nested-loading > div > div > div:nth-child(2) > div > label');
        $I->selectOptionCustom('#disk_sid', $this->title. '-[Disc 1]');
        $I->wait(1);
        $I->click('追 加');
        $I->wait(1);
        $I->reloadPage();
        $I->wait(1);
        $I->click('.anticon-right');
        $I->waitForText($soundName1);
        $I->waitForText($soundName2);
        $I->wait(1);
        $I->click('制作確定');
        $I->waitForText('(P) - line情報を再設定しますか？');
        $I->click('再設定');
        $I->waitForText('パッケージ基本情報登録');
    }

    public function testRegisterLabelCopySoundWithoutReset(AcceptanceTester $I)
    {
        $I->selectProject($I, $this->projectId);
        $I->wait(1);
        $I->click('//*[@id="root"]/div/section/main/div/main/div[1]/div[1]/div/div[4]/div/div[2]/a');
        $I->wait(1);
        $I->click('.anticon-right');
        $I->wait(1);
        $I->click('制作確定');
        $I->waitForText('(P) - line情報を再設定しますか？');
        $I->click('再設定せず制作確定');
        $I->waitForText('パッケージ - 基本情報');
    }

    // 10. レーベルコピーの登録（画源ディスクの場合）
    public function testRegisterLabelCopyImageDisk(AcceptanceTester $I)
    {
        $today = \Carbon\Carbon::today();
        $today = $today->format('Y年n月j日');
        $this->projectId2 = $I->createProject($I);
        $I->click('パッケージ');
        $I->waitForText('パッケージ企画タイトル');
        // パッケージにメインアーティストとジャンル連携チェック
        $I->click('#pkg_release_date');
        $I->wait(1);
        $I->click('.ant-calendar-cell[title="'. $today .'"]');
        $I->wait(1);
        $I->click('登 録');
        $I->wait(1);
        $I->click('はい');
        $I->waitForText('新規追加');

        $I->click('基本情報');
        $I->wait(1);
        $I->click('新規追加');
        $I->wait(1);
        $I->waitForText('パッケージ基本情報登録');
        $taxExcluedPrice = $this->faker->numberBetween(1000, 9999);
        $this->title2 = $this->faker->unique()->text(10);
        $I->selectOptionCustom('#format_code', 'DVD-VIDEO12cm');
        $I->selectOptionCustom('#category_code', 'ビデオ-VIDEO-音楽-P');
        $I->fillField('#title_domestic', $this->title2);
        $I->fillField('#title_kana', 'カナ');
        $I->fillField('#title_en', $this->faker->unique()->text(10));
        $I->fillField('#tax_exclued_price', $taxExcluedPrice);
        $I->click('自動計算');
        $I->click('自動計算');
        $I->selectOptionCustom('#ln_prhbtn_code', 'Sell or Rent');
        $I->selectOptionCustom('#sales_classification_code', '再販対象');
        $I->fillField('#estimate_tax_excluded_price__0', $taxExcluedPrice);
        $I->click('#header-button-estimate_tax_excluded_price');
        $I->selectOptionCustom('#c_line__0', 'Sony Music Labels Inc.');
        $I->click('登 録');
        $I->wait(1);
        $I->click('はい');
        $I->wait(1);
        $I->waitForText($this->title2);
        $I->click('//*[@id="container-packageBasicInfo"]/div/div[2]/div/div/div[1]/div[3]/div');
        $I->waitForText('パッケージ基本情報登録');


        $videoName1 = $this->faker->unique()->text(10);
        $videoName2 = $this->faker->unique()->text(10);
        $I->selectProject($I, $this->projectId2);
        $I->wait(1);
        $I->createVideo($I, $videoName1);
        $I->createVideo($I, $videoName2);
        $I->click('//*[@id="root"]/div/section/main/div/main/div[1]/div[1]/div/div[4]/div/div[2]/a');
        $I->click('アセット追加');
        $I->wait(1);
        $I->click('/html/body/div[4]/div/div[2]/div/div/div[2]/div/div/div[1]/div/div/div/div/div[1]/div[2]');
        $I->wait(1);
        $I->click('div.ant-spin-nested-loading > div > div > div:nth-child(1) > div > label');
        $I->click('div.ant-spin-nested-loading > div > div > div:nth-child(2) > div > label');
        $I->selectOptionCustom('#disk_sid', $this->title2. '-[Disc 1]');
        $I->selectOptionCustom('#title_sid', 'Title 1');
        $I->wait(1);
        $I->click('追 加');
        $I->wait(1);
    }

    // 13.ディスクの基本情報を登録する（登録順番はユーザによって異なる）
    public function testRegisterDisk(AcceptanceTester $I)
    {
        $name1 = $this->faker->unique()->text(10);
        $I->selectProject($I, $this->projectId2);
        $I->click('//*[@id="root"]/div/section/main/div/main/div[1]/div[1]/div/div[4]/div/div[2]/a');
        $I->wait(1);
        $I->click('.anticon-right');
        $I->wait(1);
        $I->click('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[1]/div/div/div/div/div[1]/div[1]');
        $I->waitForText('制作・著作');
        $I->fillField('#production', $name1);
        $I->selectOptionCustom('#naiyou_kb_code', '1 - 1. 音楽');
        $I->click('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[1]/div/div/div/div/div[1]/div[2]');
        $I->waitForText('Disc Layer');
        $I->selectOptionCustom('/html/body/div[1]/div/section/main/div/main/div[1]/div[2]/div/div/div[1]/div[2]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[3]/div[2]/div[2]/div/div/div[1]/form/div/div[1]/div/div[2]/div/span/div/div', 'Single ');
        $I->click('ALL');
        $I->selectOptionCustom('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[3]/div[2]/div[2]/div/div/div[1]/form/div/div[22]/div/div[2]/div/span/div', 'Color');
        $I->selectOptionCustom('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[3]/div[2]/div[2]/div/div/div[1]/form/div/div[23]/div/div[2]/div/span/div', 'Level 2');
        // $I->selectOptionCustom('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[3]/div[2]/div[2]/div/div/div[1]/form/div/div[25]/div/div[2]/div/span/div', 'OFF');
        $I->selectOptionCustom('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[3]/div[2]/div[2]/div/div/div[1]/form/div/div[30]/div/div[2]/div/span/div', 'to Menu');
        $I->selectOptionCustom('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[3]/div[2]/div[2]/div/div/div[1]/form/div/div[31]/div/div[2]/div/span/div', 'OFF ');
        $I->selectOptionCustom('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[3]/div[2]/div[2]/div/div/div[1]/form/div/div[32]/div/div[2]/div/span/div', 'ON');
        // $I->selectOptionCustom('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[3]/div[2]/div[2]/div/div/div[1]/form/div/div[35]/div/div[2]/div/span/div', 'ON');

        $I->click('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[1]/div/div/div/div/div[1]/div[3]');
        $I->click('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[1]/div/div/div/div/div[1]/div[4]');
        $I->click('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[1]/div/div/div/div/div[1]/div[5]');
        $I->click('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[1]/div/div/div/div/div[1]/div[6]');
        $I->click('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[1]/div/div/div/div/div[1]/div[7]');
        $I->click('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[1]/div/div/div/div/div[1]/div[8]');
        $I->click('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[1]/div/div/div/div/div[1]/div[9]');
        $I->click('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[1]/div/div/div/div/div[1]/div[10]');
        $I->click('保 存');
        $I->wait(1);
        $I->click('はい');
        $I->wait(1);
    }

    // 14. 制作確定, 15. (C)line登録
    // public function testConfirmProduction(AcceptanceTester $I)
    // {
    //     $I->selectProject($I, $this->projectId2);
    //     $I->click('//*[@id="root"]/div/section/main/div/main/div[1]/div[1]/div/div[4]/div/div[2]/a');
    //     $I->wait(1);
    //     $I->click('.anticon-right');
    //     $I->wait(1);
    //     $I->click('制作確定');
    //     $I->waitForText('(P) - line情報を再設定しますか？');
    //     $I->click('再設定せず制作確定');
    //     $I->waitForText('パッケージ - 基本情報');
    // }

    // 16. 画源のタイム登録（スタジオでの作業が終わり次第）
    public function testCopyChapterTime(AcceptanceTester $I)
    {
        $I->selectProject($I, $this->projectId2);
        $I->click('//*[@id="root"]/div/section/main/div/main/div[1]/div[1]/div/div[4]/div/div[2]/a');
        $I->wait(1);
        $I->click('.anticon-right');
        $I->wait(1);
        $I->click('//*[@id="container-packageTableLabelCopy"]/div/div[2]/div/div/div/div/div[2]/div/div/div/div/div[3]/div[1]/div[1]/div/div/div/div/div[1]/div[8]');
        $I->wait(1);
        $I->click('画源タイムコピー');
        $I->wait(1);
        $I->click('タイムコピー');
        $I->waitForText('タイトル検索');
    }

}
