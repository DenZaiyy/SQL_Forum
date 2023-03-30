<?php
$topics = $result["data"]['topics'];
?>

<h1>The most 5 recents posts</h1>
<?php
foreach ($topics as $topic) {
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
$title = "Home Page";
