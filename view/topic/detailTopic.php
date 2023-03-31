<?php
$title = "Detail topic";

$topic = $result["data"]["topic"];
$message = $result["data"]["firstMessage"];
$comments = $result["data"]["findComments"];
?>
<div class="card-topic">
    <div class="infos">
        <h4>posted by : <?= $topic->getUser()->getPseudo() . " - " . $topic->getDate() ?></h4>
    </div>
    <div class="preview">
        <div class="title">
            <p><?= $topic->getTitle() ?></p>
        </div>
        <div class="msg">
            <p><?= $message->getMessage() ?></p>
        </div>
    </div>
    <div class="btns">
        <div class="like">
            <form action="index.php?ctrl=forum&action=like&id=<?= $topic->getId() ?>" method="post">
                <button type="submit"><i class="fa-regular fa-thumbs-up"></i> <?= $topic->getLikes() ? "(" . $topic->getLikes() . ")" : "" ?> Like</button>
            </form>
        </div>
    </div>
</div>
<?php

if ($comments) {
    foreach ($comments as $key => $comment) {
        if ($key != 0) {
?>
            <div class="card-comment">
                <div class="infos">
                    <div class="img">
                        <img src="<?= $comment->getUser()->getAvatar() ?>" alt="image of user(<?= $comment->getUser()->getPseudo() ?>)">
                    </div>
                    <div class="createBy">
                        <p><?= $comment->getUser()->getPseudo() ?></p>
                        <p><?= $comment->getDate() ?></p>
                    </div>
                </div>
                <hr>
                <div class="preview">
                    <div class="msg">
                        <p><?= $comment->getMessage() ?></p>
                    </div>
                </div>
            </div>
<?php
        }
    }
} ?>

<div class="newCom">
    <a href="index.php?ctrl=forum&action=addComment">
        <i class="fa-solid fa-plus fa-l"></i> Add new comment
    </a>
</div>