<?php

class User
{
    protected $ratings;

    public function findRatingsByGenre($genreCode)
    {
        $filteredRatings = [];
        foreach ($this->getRatings() as $rating) {
            if ($rating->getGame()->getGenreCode() == $genreCode) {
                $filteredRatings[] = $rating;
            }
        }
    }

     /**
     * Gets the average score of the game.
     *
     * @return int Average Score
     */
    public function getGenreCompatibility($genreCode)
    {
        $ratings = $this->findRatingsByGenre($genreCode);
        $numRatings = count($ratings);

        // Implemented after test fail (Divided by zero).
        // This bug happened because $numRatings = 0
        if ($numRatings == 0) {
            return null;
        }

        $total = 0;
        foreach ($ratings as $rating) {
            $score = $rating->getScore();
            if ($score === null) {
                $numRatings--;
                continue;
            }
            $total += $score;
        }
        return $total / $numRatings;
    }

    public function getRatings()
    {
        return $this->ratings;
    }
}