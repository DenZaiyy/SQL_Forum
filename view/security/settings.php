<?php
// if user is connected, redirect to homepage else display settings page

if (!App\Session::getUser()) {
    header('Location: index.php?ctrl=home&action=index');
} else {
    $title = "Settings";
?>
    <div class="settings">
        <div class="password">
            <h2>Password</h2>
            <form action="index.php?ctrl=security&action=modifyPassword" method="post" enctype="multipart/form-data">
                <div class="inputs">
                    <input type="text" name="password" required>
                    <input type="text" name="newPassword" required>
                    <input type="password" name="newPasswordConfirm" required>
                </div>
                <button type="submit">Change my password</button>
            </form>
        </div>
    </div>
<?php
}
?>