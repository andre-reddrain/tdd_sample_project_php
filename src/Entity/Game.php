<?php

class Game
{
    protected $id;
    protected $title;
    protected $imagePath;
    protected $ratings;

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

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
            $score = $rating->getScore();
            if ($score === null) {
                $numRatings--;
                continue;
            }
            $total += $score;
        }
        return $total / $numRatings;
    }

    public function toArray()
    {
        $array = [
            'title' => $this->getTitle(),
            'imagePath' => $this->getImagePath(),
            'ratings' => [],
        ];
        foreach ($this->getRatings() as $rating) {
            $array['ratings'][] = $rating->toArray();
        }
        return $array;
    }

    /**
     * Sees if the game is recommended or not,
     * depending on it's average score
     * 
     * @return ???
     */
    public function isRecommended($user)
    {
        $compatibility = $user->getGenreCompatibility($this->getGenreCode());
        return $this->getAverageScore() / 10 * $compatibility >= 3;
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
            return '/Projetos/tdd_sample_project/web/images/placeholder.jpg';
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