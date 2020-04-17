<?php

class Game
{
    protected $title;
    protected $imagePath;
    protected $ratings;

    /**
     * Gets the average score of the game.
     *
     * @return int Average Score
     */
    public function getAverageScore()
    {
        $ratings = $this->getRatings();
        $numRatings = count($ratings);

        // Implemented after test fail (Divided by zero).
        // This bug happened because $numRatings = 0
        if ($numRatings == 0) {
            return null;
        }

        $total = 0;
        foreach ($ratings as $rating) {
            $total = $rating->getScore();   // BUG - It's assigning, not adding.
        }
        return $total / $numRatings;
    }

    /**
     * Sees if the game is recommended or not,
     * depending on it's average score
     * 
     * @return ???
     */
    public function isRecommended()
    {
        return $this->getAverageScore() >= 3;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getImagePath()
    {
        if ($this->imagePath == null) {
            return '/images/placeholder.jpg';
        }
        return $this->imagePath;
    }

    public function setImagePath($value)
    {
        $this->imagePath = $value;
    }

    public function getRatings()
    {
        return $this->ratings;
    }

    public function setRatings($value)
    {
        $this->ratings = $value;
    }
}