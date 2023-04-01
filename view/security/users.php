<h1>List of users</h1>
<?php
$users = $result['data']['users'];

foreach ($users as $user) {
?>
    <div class="card-user">
        <div class="infos">
            <h4>Registered since : <?= $user->getCreatedAt() ?></h4>
        </div>
        <div class="preview">
            <h3>Pseudo:</h3>
            <a href="index.php?ctrl=security&action=detailUser&id=<?= $user->getId() ?>">
                <p><?= $user->getPseudo() ?></p>
            </a>
        </div>
    </div>
<?php
}
