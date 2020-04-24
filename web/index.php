<?php

require __DIR__ . "/../src/Repository/GameRepository.php";

$repo = new GameRepository();
$games = $repo->findByUserId(1);

?>

<ul>
<?php foreach ($games as $game) : ?>
    <li>
        <span class="title"><?php echo $game->getTitle() ?></span><br>
        <a href="add-rating.php?game=<?php echo $game->getId() ?>">Rate</a>
        <?php echo $game->getAverageScore() ?><br>
        <img src="<?php echo $game->getImagePath() ?>" style="max-width:100px; max-height:100px">
    </li>
<?php endforeach ?>
</ul>