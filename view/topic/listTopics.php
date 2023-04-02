<?php
$topics = $result["data"]['topics'];

?>

<h1>List of topics</h1>
<div class="categories">
    <?php
    foreach ($topics as $topic) {
    ?>
        <a href="index.php?ctrl=forum&action=detailTopic&id=<?= $topic->getId() ?>">
            <div class="category">
                <p>Title: <?= $topic->getTitle() ?></p>
                <p>Post by : <?= $topic->getUser()->getPseudo() ?></p>
            </div>
        </a>
    <?php
    }
    $title = "List of topics";
    ?>
</div>