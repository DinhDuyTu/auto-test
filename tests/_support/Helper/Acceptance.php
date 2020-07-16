<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{
    public function getProjectId()
    {
        return '545883';
    }

    public function getAudioname()
    {
        return 'けだるい朝';
    }

    public function getVideoname()
    {
        return '花とみつばち';
    }
}
