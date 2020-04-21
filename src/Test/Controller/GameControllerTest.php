<?php

use PHPUnit\Framework\TestCase;
use Goutte\Client;

class GameControllerTest extends TestCase
{
    protected $pdo;

    public function testIndex_HasTitle()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://localhost/Projetos/tdd_sample_project/web/');
        $this->assertCount(6, $response->filter('ul > li'));
    }

    public function testAddRating_WithGet_HasEmptyForm()
    {
        $client = new Client();
        $response = $client->request('GET',
            'http://localhost/Projetos/tdd_sample_project/web/add-rating.php?game=1'
        );

        $this->assertCount(1, $response->filter('form'));
        $this->assertEquals('',
            $response->filter('form input[name=score]')->attr('value')
        );
    }

    public function testAddRating_WithPost_IsRedirect()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST',
            'http://localhost/Projetos/tdd_sample_project/web/add-rating.php?game=1',
            [
                'allow_redirects' => false,
                'form_params' => [
                    'score' => '5'
                ],
            ]
        );
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('/', $response->getHeaderLine('Location'));

        $dsn = "mysql:host=127.0.0.1;dbname=gamebook_test;port=3306";
        $user = "root";
        $pass = "root";

        $pdo = new PDO($dsn, $user, $pass);

        $statement = $pdo->prepare('SELECT * FROM rating');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $this->assertCount(1, $result);
        $this->assertEquals(
            [
                'user_id' => '1',
                'game_id'=> '1',
                'score' => '5',
            ], $result[0]
        );
    }
}
