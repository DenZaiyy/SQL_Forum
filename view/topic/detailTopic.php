<?php
$title = "Detail topic";

$topic = $result["data"]["topic"];
$message = $result["data"]["firstMessage"];
$comments = $result["data"]["findComments"];
$like = $result["data"]["like"];

// var_dump(App\Session::getUser());
?>
<div class="card-topic">
    <?php
    //if user is admin or owner of topic, show delete/lock button
    if (App\Session::isAdmin() || App\Session::getUser()->getId() == $topic->getUser()->getId()) {
    ?>
        <div class="status">
            <form action="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>" method="post">
                <input type="hidden" name="_token" value="<?= $_SESSION['_token'] ?>">
                <button type="submit" name="submit" class="delete-btn"><i class="fa-solid fa-trash-can fa-xl"></i></button>
            </form>
            <form action="index.php?ctrl=forum&action=editForm&id=<?= $topic->getId() ?>" method="post">
                <button type="submit" name="submit" class="edits-btn"><i class="fa-solid fa-pen-to-square fa-xl"></i></button>
            </form>
            <?php if ($topic->getLock() == 0) { ?>
                <form action="index.php?ctrl=forum&action=lockTopic&id=<?= $topic->getId() ?>" method="post">
                    <button type="submit" name="submit" class="lock-btn"><i class="fa-solid fa-lock fa-xl"></i></button>
                </form>
            <?php } else {
            ?>
                <form action="index.php?ctrl=forum&action=unlockTopic&id=<?= $topic->getId() ?>" method="post">
                    <button type="submit" name="submit" class="unlock-btn"><i class="fa-solid fa-unlock fa-xl"></i></button>
                </form>
            <?php } ?>
        </div>
    <?php
    }
    ?>

    <div class="infos">
        <h4>posted by : <a href="index.php?ctrl=forum&action=detailUser&id=<?= $topic->getUser()->getId() ?>"><?= $topic->getUser()->getPseudo() . "</a> - " . $topic->getDate() ?></h4>
    </div>
    <div class="preview">
        <div class="title">
            <strong>Title:</strong>
            <p><?= $topic->getTitle() ?></p>
        </div>
        <div class="msg">
            <strong>Message:</strong>
            <p><?= $message->getMessage() ?></p>
        </div>
    </div>
    <div class="btns">
        <div class="like">
            <form action="index.php?ctrl=forum&action=like&id=<?= $topic->getId() ?>" method="post">
                <button type="submit" name="submit" id="nbLikes"><i class="fa-regular fa-thumbs-up"></i> <?= $like ? "(" . $like . ")" : "" ?> Like</button>
            </form>
        </div>
    </div>
</div>
<?php

if ($comments) {
    foreach ($comments as $key => $comment) {
        if ($key !== 0) {
?>
            <div class="card-comment">
                <?php
                //if user is admin, display delete button
                if (App\Session::isAdmin() || App\Session::getUser()->getId() === $comment->getUser()->getId()) {
                ?>
                    <div class="status">
                        <form action="index.php?ctrl=forum&action=deleteComment&id=<?= $comment->getId() ?>" method="post">
                            <button type="submit" name="submit" class="delete-btn"><i class="fa-solid fa-trash-can fa-xl"></i></button>
                        </form>
                    </div>
                <?php
                }
                ?>
                <div class="infos">
                    <div class="img">
                        <img src="<?= $comment->getUser()->getAvatar() ?>" alt="image of user(<?= $comment->getUser()->getPseudo() ?>)">
                    </div>
                    <div class="createBy">
                        <a href="index.php?ctrl=forum&action=detailUser&id=<?= $comment->getUser()->getId() ?>">
                            <p><?= $comment->getUser()->getPseudo() ?></p>
                        </a>
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
}
if (App\Session::getUser() && $topic->getLock() == 0) { ?>

    <div class="form-comment">
        <form action="index.php?ctrl=forum&action=addComment&id=<?= $topic->getId() ?>" method="post">
            <input type="hidden" name="_token" value="<?= $_SESSION['_token'] ?>">
            <textarea name="message" placeholder="Write your comment ..." required></textarea>
            <button type="submit" name="submit">Add comment</button>
        </form>
    </div>

<?php } ?>
