<h1>REGISTER FORM</h1>

<form action="index.php?ctrl=security&action=register" method="post" enctype="multipart/form-data">
    <input type="text" name="pseudo" placeholder="pseudo" required>
    <input type="email" name="mail" placeholder="email" required>
    <input type="password" name="password" placeholder="password" required>
    <input type="password" name="confirmPassword" placeholder="confirm password" required>
    <button type="submit">Valider</button>
</form>