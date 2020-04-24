<?php

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGenreCompatibility_With8And6_Returns7()
    {
        $rating1 = $this->createMock('Rating', ['getScore']);
        $rating1->method('getScore')
                ->willReturn(6);

        $rating2 = $this->createMock('Rating', ['getScore']);
        $rating2->method('getScore')
                ->willReturn(8);
        
        $user = $this->createMock('User', ['findRatingsByGenre']);
        $user->method('findRatingsByGenre')
             ->willReturn([$rating1, $rating2]);
        $this->assertEquals(7, $user->getGenreCompatibility('zombies'));
    }

    public function testRatingsByGenre_With1ZombieAnd1Shooter_Returns1Zombie()
    {
        $zombiesGame = $this->createMock('Game', ['getGenreCode']);
        $zombiesGame->method('getGenreCode')
                    ->willReturn('zombies');

        $shooterGame = $this->createMock('Game', ['getGenreCode']);
        $shooterGame->method('getGenreCode')
                    ->willReturn('shooter');

        $rating1 = $this->createMock('Rating', ['getGame']);
        $rating1->method('getGame')
                ->willReturn($zombiesGame);

        $rating2 = $this->createMock('Rating', ['getGame']);
        $rating2->method('getGame')
                ->willReturn($shooterGame);
        
        $user = $this->createMock('User', ['getRatings']);
        $user->method('getRatings')
             ->willReturn([$rating1, $rating2]);

        $ratings = $user->findRatingsByGenre('zombies');
        $this->assertCount(1, $ratings);
        foreach ($ratings as $rating) {
            $this->assertEquals('zombies', $rating->getGame()->getGenreCode());
        }
    }
}