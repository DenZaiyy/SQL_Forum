<?php
// if user is connected, redirect to homepage else display login form

if (App\Session::getUser()) {
    header('Location: index.php?ctrl=home&action=index');
} else {
    $title = "Login page";
?>
    <div class="login">
        <form action="index.php?ctrl=security&action=login" method="post" enctype="multipart/form-data">
            <div class="input">
                <label for="pseudo">username</label>
                <input type="text" name="pseudo" required>
            </div>
            <div class="input">
                <label for="password">password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <a class="btn-register" href="index.php?ctrl=security&action=registerForm">register</a>
    </div>
<?php
}
?>