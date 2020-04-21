<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class GameControllerTest extends TestCase
{
    public function testIndex_HasTitle()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://google.pt');
        $this->assertRegExp('/<title>/', $response->getBody()->getContents());
    }
}
