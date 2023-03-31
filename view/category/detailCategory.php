<?php $topics = $result["data"]['topics'];
// var_dump($topics);
// die();
if ($topics) { ?>
    <h1>Topics for this category</h1>
    <?php foreach ($topics as $topic) {
    ?>
        <div class="card-topic">
            <div class="infos">
                <h4>posted by : <?= $topic->getUser()->getPseudo() . " - " . $topic->getDate() ?></h4>
            </div>
            <div class="preview">
                <a href="index.php?ctrl=forum&action=detailTopic&id=<?= $topic->getId() ?>">
                    <p><?= $topic->getTitle() ?></p>
                </a>
            </div>
            <div class="btns">
                <div class="like">
                    <a href="">
                        <i class="fa-regular fa-thumbs-up"></i>
                        Like
                    </a>
                </div>
                <div class="comments">
                    <a href="">
                        <i class="fa-solid fa-comment"></i>
                        Comment
                    </a>
                </div>
            </div>
        </div>
    <?php
    }
} else { ?>
    <h1>No topic for this category</h1>
<?php }
$title = "Details category";
