<?php
$topics = $result["data"]['topics'];
//if user are not connected, redirect to login page
if (!App\Session::getUser()) {
    header('Location: index.php?ctrl=security&action=login');
} else {

?>

    <h1>The most 5 recents posts</h1>
    <?php
    foreach ($topics as $topic) {
    ?>
        <div class="card-topic">
            <div class="infos">
                <h4>posted by : <a href="index.php?ctrl=forum&action=detailUser&id=<?= $topic->getUser()->getId() ?>"><?= $topic->getUser()->getPseudo() . "</a> - " . $topic->getDate() ?></h4>
            </div>
            <div class="preview">
                <h3>Title:</h3>
                <a href="index.php?ctrl=forum&action=detailTopic&id=<?= $topic->getId() ?>">
                    <p><?= $topic->getTitle() ?></p>
                </a>
            </div>
            <div class="btns">
                <?= $topic->getLikes() ? "<div class='like'>(" . $topic->getLikes() . ") <i class='fa-regular fa-thumbs-up'></i></div>" : "" ?>
                <div class="comments">
                    <i class="fa-solid fa-comment"></i>
                </div>
            </div>
        </div>
<?php
    }
    $title = "Home Page";
}
