<?php

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGenreCompatibility_With8And6_Returns7()
    {
        $rating1 = $this->getMockBuilder(Rating::class)
            ->setMethods(['getScore'])
            ->getMock();
        $rating1->method('getScore')->willReturn(6);

        $rating2 = $this->getMockBuilder(Rating::class)
            ->setMethods(['getScore'])
            ->getMock();
        $rating2->method('getScore')->willReturn(8);

        $user = $this->getMockBuilder(User::class)
            ->setMethods(['findRatingsByGenre'])
            ->getMock();
        $user->method('findRatingsByGenre')->willReturn([$rating1, $rating2]);

        $result = $user->getGenreCompatibility('zombies');

        $this->assertEquals(7, $result);
    }

    public function testRatingsByGenre_With1ZombieAnd1Shooter_Returns1Zombie()
    {
        $zombiesGame = $this->getMockBuilder(Game::class)
            ->setMethods(['getGenreCode'])
            ->getMock();
        $zombiesGame->method('getGenreCode')->willReturn('zombies');

        $shooterGame = $this->getMockBuilder(Game::class)
            ->setMethods(['getGenreCode'])
            ->getMock();
        $shooterGame->method('getGenreCode')->willReturn('shooter');

        $rating1 = $this->getMockBuilder(Rating::class)
            ->setMethods(['getScore'])
            ->getMock();
        $rating1->method('getScore')->willReturn($zombiesGame);

        $rating2 = $this->getMockBuilder(Rating::class)
            ->setMethods(['getScore'])
            ->getMock();
        $rating2->method('getScore')->willReturn($shooterGame);

        $user = $this->getMockBuilder(User::class)
            ->setMethods(['findRatingsByGenre'])
            ->getMock();
        $user->method('findRatingsByGenre')->willReturn([$rating1, $rating2]);

        $ratings = $user->findRatingsByGenre('zombies');
        $this->assertCount(1, $ratings);
        
        foreach ($ratings as $rating) {
            $result = $rating->getGame()->getGenreCode();
            $this->assertEquals('zombies', $result);
        }
    }
}