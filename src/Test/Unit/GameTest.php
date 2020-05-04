<?php

use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testImage_WithNull_ReturnsPlaceHolder()
    {
        $game = new Game();
        $game->setImagePath(null);
        $this->assertEquals('/Projetos/tdd_sample_project/web/images/placeholder.jpg', $game->getImagePath());
    }

    public function testImage_WithPath_ReturnsPath()
    {
        $game = new Game();
        $game->setImagePath('/images/game.jpg');
        $this->assertEquals('/images/game.jpg', $game->getImagePath());
    }

    public function testAverageScore_WithoutRatings_ReturnsNull()
    {
        $game = new Game();
        $game->setRatings([]);
        $this->assertNull($game->getAverageScore());
    }

    public function testAverageScore_With6And8_Returns7()
    {
        $rating1 = $this->getMockBuilder(Rating::class)
            ->setMethods(['getScore'])
            ->getMock();
        $rating1->method('getScore')->willReturn(6);

        $rating2 = $this->getMockBuilder(Rating::class)
            ->setMethods(['getScore'])
            ->getMock();
        $rating2->method('getScore')->willReturn(8);

        $game = $this->getMockBuilder(Game::class)
            ->setMethodsExcept(['getAverageScore'])
            ->getMock();
        $game->method('getRatings')->willReturn([$rating1, $rating2]);

        $result = $game->getAverageScore();

        $this->assertEquals(7, $result);
    }

    public function testAverageScore_WithNullAnd5_Returns5()
    {
        $rating1 = $this->getMockBuilder(Rating::class)
            ->setMethods(['getScore'])
            ->getMock();
        $rating1->method('getScore')->willReturn(null);

        $rating2 = $this->getMockBuilder(Rating::class)
            ->setMethods(['getScore'])
            ->getMock();
        $rating2->method('getScore')->willReturn(5);

        $game = $this->getMockBuilder(Game::class)
            ->setMethodsExcept(['getAverageScore'])
            ->getMock();
        $game->method('getRatings')->willReturn([$rating1, $rating2]);

        $result = $game->getAverageScore();

        $this->assertEquals(5, $result);
    }

    public function testIsRecommended_WithCompatibility2AndScore10_ReturnsFalse()
    {
        $game = $this->createMock('Game', ['getAverageScore', 'getGenreCode']);
        $game->method('getAverageScore')
             ->willReturn(10);

        $user = $this->createMock('User', ['getGenreCompatibility']);
        $game->method('getGenreCompatibility')
            ->willReturn(2);

        $this->assertFalse($game->isRecommended($user));
    }

    public function testIsRecommended_WithCompatibility10AndScore10_ReturnsFalse()
    {
        $game = $this->getMockBuilder(Game::class)
            ->setMethodsExcept(['isRecommended'])
            ->getMock();
        $game->method('getAverageScore')->willReturn(10);

        $user = $this->getMockBuilder(User::class)
            ->setMethods(null)
            ->getMock();
        $user->method('getGenreCompatibility')->willReturn(10);

        $result = $game->isRecommended($user);

        $this->assertTrue($result);
    }
}