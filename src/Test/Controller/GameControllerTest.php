<?php

use PHPUnit\Framework\TestCase;
use Goutte\Client;

class GameControllerTest extends TestCase
{
    public function setUp(): void
    {
        exec("mysql -u'root' --password='root' < " . __DIR__ . "/../fixture.sql");
    }

    public function testIndex_HasUl()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://localhost/Projetos/tdd_sample_project/web/');
        $this->assertCount(6, $response->filter('ul > li'));
    }

    public function testApiGames_WithUser_Returns6Items()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'http://localhost/Projetos/tdd_sample_project/web/api-games.php', [
            'json' => [
                'user' => '1',
            ],
        ]);

        $json = $response->getBody()->getContents();
        $this->assertJsonStringEqualsJsonString(
            file_get_contents(__DIR__ . '/api-games-user.json'), $json
        );
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
                'multipart' => [
                    [
                        'name' => 'score',
                        'contents' => '5',
                    ],
                    [
                        'name' => 'screenshot',
                        'contents' => fopen(__DIR__ . '/screenshot.jpg', 'r')
                    ]
                ]
            ]
        );
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('/Projetos/tdd_sample_project/web/', $response->getHeaderLine('Location'));

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

        $this->assertFileExists(dirname(__DIR__, 3) . '/web/screenshots/1-1.jpg');
    }
}
