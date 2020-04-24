<?php

use PHPUnit\Extensions\Selenium2TestCase;

class RatingSubmissionTest extends Selenium2TestCase
{
    public function setUp(): void
    {
        $this->setHost('localhost');
        $this->setPort(4444);
        $this->setBrowserUrl('http://localhost/Projetos/tdd_sample_project/web/');
        $this->setBrowser('chrome');
        // $this->setDesiredCapabilities(['chromeOptions' => ['w3c' => false]]); 
    }

    public function tearDown(): void
    {
        $this->stop();
    }

    public function testHomePage()
    {
        $this->url('/');
        $content = $this->byTag('li')->text();
        $this->assertEquals("Game 1\n4.5", $content);
    }
}