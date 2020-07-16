<?php

class MasterCest extends BaseCest
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

    public function viewMain(AcceptanceTester $I)
    {
        $I->click('div.swiper-container div.swiper-slide-active');
     
        //code
    }
}
