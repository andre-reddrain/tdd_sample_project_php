<?php

use PHPUnit\Framework\TestCase;
use Goutte\Client;

class GameControllerTest extends TestCase
{
    public function testIndex_HasTitle()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://localhost/Projetos/tdd_sample_project/web/');
        $this->assertCount(6, $response->filter('ul > li'));
        // $this->assertRegExp('/<title>/', $response->getBody()->getContents());
    }
}
