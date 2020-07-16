<?php

require_once 'vendor/autoload.php';

class BaseCest
{
    protected $faker;
    protected $projectId = '545883';
    protected $audioName = 'けだるい朝';
    protected $videoName = '花とみつばち';

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }
}
