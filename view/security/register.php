<?php
if (App\Session::getUser()) {
    header('Location: index.php?ctrl=home&action=index');
} else {

?>
    <div class="register">
        <form action="index.php?ctrl=security&action=register" method="POST" enctype="multipart/form-data">
            <div class="input">
                <label for="pseudo">username</label>
                <input type="text" name="pseudo" required>
            </div>
            <div class="input">
                <label for="email">email</label>
                <input type="email" name="email" required>
            </div>
            <div class="input">
                <label for="password">password</label>
                <input type="password" name="password" required>
            </div>
            <div class="input">
                <label for="confirmPassword">confirm password</label>
                <input type="password" name="confirmPassword" required>
            </div>
            <div class="input">
                <label>avatar</label>
                <div class="upload">
                    <input type="file" name="avatar" id="avatar">
                    <input type="text" placeholder="Select file" id="avatar-text" disabled>
                </div>
            </div>
            <button type="submit">register</button>
        </form>
    </div>

<?php
    $title = "Register page";
}
