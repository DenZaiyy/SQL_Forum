<?php
if (!App\Session::getUser()) {
    header('Location: index.php?ctrl=security&action=loginForm');
} else {
    $user = $result['data']['user'];
    $topics = $result['data']['topics'];
    $title = "Detail of " . $user->getPseudo();

    if ($topics) {
?>
        <h1>Topics posted by <?= $user->getPseudo() ?></h1>
        <div class="categories">
            <?php foreach ($topics as $topic) {
            ?>

                <a href="index.php?ctrl=forum&action=detailTopic&id=<?= $topic->getId() ?>">
                    <div class="category">
                        <strong>Title:</strong>
                        <p> <?= $topic->getTitle() ?></p>
                    </div>
                </a>
            <?php
            } ?>
        </div>
<?php
    } else {
        echo "<h1>This user has not posted any topic yet</h1>";
    }
}
?>