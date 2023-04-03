<h1>List of users</h1>
<?php
$users = $result['data']['users'];
$title = "List of users";

foreach ($users as $user) {
?>
    <div class="card-user">
        <div class="infos">
            <p><strong>Registered since :</strong> <?= $user->getCreatedAt() ?></p>
        </div>
        <div class="preview">
            <p>
                <strong>Pseudo:</strong>
                <a href="index.php?ctrl=forum&action=detailUser&id=<?= $user->getId() ?>">
                    <?= $user->getPseudo() ?>
                </a>
            </p>
            <p><strong>Role:</strong> <?= $user->getRole() == json_encode("ROLE_ADMIN") ? "Admin" : "User" ?></p>
            <p><strong>Change Role:</strong>
            <form action="index.php?ctrl=security&action=updateRole&id=<?= $user->getId() ?>" method="post">
                <select name="role">
                    <option value="ROLE_USER">User</option>
                    <option value="ROLE_ADMIN">Admin</option>
                </select>
                <button type="submit">Update</button>
            </form>
            </p>
        </div>
    </div>
<?php
}
