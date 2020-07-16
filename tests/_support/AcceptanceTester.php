<?php

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    public function login($username = '', $password = '')
    {
        $username = "datdt@fabbi.io";
        $password = "test";

        if($this->loadSessionSnapshot('login')) return;

        $this->amOnPage('/login');

        if($this->haveElement('#login_contents')) {
            $this->fillField('input[name="login_id"]', $username);
            $this->fillField('input[name="login_pass"]', $password);
            $this->click('input[name="b_login"]');
            $this->waitForText('Research Concierge', 60, '.concierge');
        }
    }

    public function haveElement($element)
    {
        try {
            $this->waitForElementVisible($element, 10);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function haveNotElement($element)
    {
        try {
            $this->waitForElementVisible($element, 3);
        } catch (Exception $e) {
            return true;
        }

        return false;
    }
}
