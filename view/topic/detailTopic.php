<?php $topic = $result["data"]["topic"];
$message = $result["data"]["firstMessage"];
$comments = $result["data"]["findComments"];
// var_dump($message);
// die();
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
        <div class="comments">
            <a href="">
                <i class="fa-solid fa-comment"></i>
                Comments
            </a>
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
                        <p><?= $comment->getUser()->getPseudo() ?>, <?= $comment->getDate() ?></p>
                    </div>
                </div>
                <div class="preview">
                    <div class="msg">
                        <p><?= $comment->getMessage() ?></p>
                    </div>
                </div>
            </div>
<?php
        }
    }
}

$title = "Detail topic";
