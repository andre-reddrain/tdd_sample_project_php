<?php

use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testImage_WithNull_ReturnsPlaceHolder()
    {
        $game = new Game();
        $game->setImagePath(null);
        $this->assertEquals('/images/placeholder.jpg', $game->getImagePath());
    }

    public function testImage_WithPath_ReturnsPath()
    {
        $game = new Game();
        $game->setImagePath('/images/game.jpg');
        $this->assertEquals('/images/game.jpg', $game->getImagePath());
    }

    // This test no longer serves any porpuse because of isRecommended change of behaviour
    // public function testIsRecommended_With5_ReturnsTrue()
    // {
    //     $game = $this->getMock('Game', ['getAverageScore']);
    //     $game->method('getAverageScore')
    //          ->willReturn(5);
    //     $this->assertTrue($game->isRecommended());
    // }

    public function testAverageScore_WithoutRatings_ReturnsNull()
    {
        $game = new Game();
        $game->setRatings([]);
        $this->assertNull($game->getAverageScore());
    }

    public function testAverageScore_With6And8_Returns7()
    {
        $rating1 = $this->createMock('Rating', ['getScore']);
        $rating1->method('getScore')
                ->willReturn(6);

        $rating2 = $this->createMock('Rating', ['getScore']);
        $rating2->method('getScore')
                ->willReturn(8);

        $game = $this->createMock('Game', ['getRatings']);
        $game->method('getRatings')
             ->willReturn([$rating1, $rating2]);

        $this->assertEquals(7, $game->getAverageScore());
    }

    public function testAverageScore_WithNullAnd5_Returns5()
    {
        $rating1 = $this->createMock('Rating', ['getScore']);
        $rating1->method('getScore')
                ->willReturn(null);

        $rating2 = $this->createMock('Rating', ['getScore']);
        $rating2->method('getScore')
                ->willReturn(5);

        $game = $this->createMock('Game', ['getRatings']);
        $game->method('getRatings')
             ->willReturn([$rating1, $rating2]);

        $this->assertEquals(5, $game->getAverageScore());
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
        $game = $this->createMock('Game', ['getAverageScore', 'getGenreCode']);
        $game->method('getAverageScore')
             ->willReturn(10);

        $user = $this->createMock('User', ['getGenreCompatibility']);
        $game->method('getGenreCompatibility')
            ->willReturn(10);

        $this->assertTrue($game->isRecommended($user));
    }
}