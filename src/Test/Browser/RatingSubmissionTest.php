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
        $this->setDesiredCapabilities(['chromeOptions' => ['w3c' => false]]); 
    }

    public function tearDown(): void
    {
        $this->stop();
    }

    public function testHomePage()
    {
        $this->url('/');
        $content = $this->byCssSelector('li span.title')->text();
        $this->assertEquals("Game 1", $content);
    }

    public function testSubmitRating()
    {
        $this->timeouts()->implicitWait(2000);
        $this->url('/');
        $this->byLinkText('Rate')->click();

        $form = $this->byTag('form');
        $form->byName('score')->value(5);
        $form->submit();

        $this->assertEquals('http://localhost/Projetos/tdd_sample_project/web/', $this->getBrowserUrl());

        $image = $this->currentScreenshot();
        file_put_contents(dirname(__DIR__, 3) . '/web/screenshots/submit-rating.jpg', $image);
    }
}