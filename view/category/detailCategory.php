<?php $topics = $result["data"]['topics'];
// var_dump($topics);
// die();
if ($topics) { ?>
    <h1>Topics for this category</h1>
    <?php foreach ($topics as $topic) {
    ?>
        <div class="card-topic">
            <div class="infos">
                <h3>Posted at : <?= $topic->getDate() ?></h3>
                <h3>By : <?= $topic->getUser()->getPseudo() ?></h3>
            </div>
            <div class="preview">
                <h3>Title:</h3>
                <a href="index.php?ctrl=forum&action=detailTopic&id=<?= $topic->getId() ?>">
                    <p><?= $topic->getTitle() ?></p>
                </a>
            </div>
        </div>
    <?php
    }
} else { ?>
    <h1>No topic for this category</h1>
<?php }
$title = "Details category";
