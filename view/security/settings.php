<?php
// if user is connected, redirect to homepage else display settings page

if (!App\Session::getUser()) {
    header('Location: index.php?ctrl=home&action=index');
} else {
    $title = "Settings";
?>
    <div class="settings">
        <div class="user-infos">
            <h2>User Infos</h2>
            <form action="index.php?ctrl=security&action=updateInfos" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="<?= $_SESSION['_token'] ?>">
                <div class="inputs">
                    <div class="pseudo">
                        <label for="pseudo">Pseudo</label>
                        <input type="text" name="pseudo" value="<?= App\Session::getUser()->getPseudo() ?>" required>
                    </div>
                    <div class="email">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="<?= App\Session::getUser()->getMail() ?>" required>
                    </div>
                    <div class="avatar">
                        <label for="avatar">Avatar</label>
                        <input type="file" name="avatar" accept="image/*">
                    </div>
                </div>
                <button type="submit">Update my infos</button>
            </form>
        </div>
        <div class="password">
            <h2>Password</h2>
            <form action="index.php?ctrl=security&action=modifyPassword" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="<?= $_SESSION['_token'] ?>">
                <div class="inputs">
                    <div class="current">
                        <label for="password">Current password</label>
                        <input type="password" name="password" required>
                    </div>
                    <div class="new-pwd">
                        <label for="newPassword">New password</label>
                        <input type="password" name="newPassword" required>
                    </div>
                    <div class="confirm-new-pwd">
                        <label for="newPasswordConfirm">Confirm new password</label>
                        <input type="password" name="newPasswordConfirm" required>
                    </div>
                </div>
                <button type="submit">Change my password</button>
            </form>
        </div>
    </div>
<?php
}
?>