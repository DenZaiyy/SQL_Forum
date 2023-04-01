<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
    <script src="<?= PUBLIC_DIR ?>/js/script.js"></script>
    <link rel="shortcut icon" href="public/img/logo.png" type="image/x-icon">
    <title><?= $title ?></title>
</head>
<?php
if (App\Session::getUser()) {
    echo '<body>';
} else {
    echo '<body class="bg-img">';
}
?>
<div class="container">
    <header>
        <nav>
            <a href="index.php">
                <div class="logo">
                    <img src="public/img/logo.png" alt="logo of forum" width="50" height="50">
                    <p>FORUM</p>
                </div>
            </a>
            <div class="searchBar">
                <input type="search" name="searchBar">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <?php
            if (App\Session::getUser()) {
            ?>
                <div class="profil" id="profil">
                    <i class="fa-solid fa-house-user fa-2xl"></i>
                    <div class="dropdown-user-menu" id="dropdown">
                        <a href="">
                            <div class="user-info">
                                <img src="<?= App\Session::getUser()->getAvatar() ?>" alt="image of <?= App\Session::getUser()->getPseudo() ?>" height="50" width="50">
                                <strong><?= App\Session::getUser()->getPseudo() ?></strong>
                            </div>
                        </a>
                        <div class="links">
                            <a href="">Profile</a>
                            <a href="index.php?ctrl=security&action=settings">Settings</a>
                            <a href="index.php?ctrl=forum&action=listTopics">List of topics</a>
                            <a href="index.php?ctrl=forum&action=listCategories">List of categories</a>
                            <a href="index.php?ctrl=security&action=listUsers">Voir la liste des gens</a>

                            <?php
                            // if (App\Session::isAdmin()) {
                            ?>
                            <!-- <a href="index.php?ctrl=security&action=users">Voir la liste des gens</a> -->
                            <?php
                            // }
                            ?>
                        </div>
                        <div class="btn-disconnect">
                            <a href="index.php?ctrl=security&action=logout"><i class="fa-solid fa-right-from-bracket"></i> Disconnect</a>
                        </div>

                    </div>
                </div>
            <?php } else {
            ?>
                <div>
                </div>
            <?php } ?>
        </nav>
    </header>
    <?php

    if (App\Session::getUser()) {
    ?>
        <div class="content-flex">

            <aside>
                <div class="themes">
                    <h3>Category</h3>
                    <div class="cat">
                        <?php foreach ($_SESSION['categories'] as $category) { ?>
                            <div class="item">
                                <a href="index.php?ctrl=forum&action=detailCategory&id=<?= $category->getId() ?>">
                                    <?= $category->getLabel(); ?>
                                </a>
                                <a href="index.php?ctrl=forum&action=addTopicForm&id=<?= $category->getId() ?>">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </aside>


            <main id="forum">
                <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
                <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>
                <?= $page ?>
            </main>
        </div>
    <?php } else {
    ?>
        <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
        <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>
        <main id="forum" class="main-content">
            <?= $page ?>
        </main>
    <?php
    } ?>

    <footer>
        <?php $date = date('Y'); ?>
        <div class="notices">
            <div class="lNotice">
                <a href="">Legal notice</a>
            </div>
            <div class="rules">
                <a href="/home/forumRules.html">Forum rules</a>
            </div>
        </div>
        <p>&copy; <?= $date ?> - Created by <strong><a href="https://github.com/DenZaiyy/" target="_blank">GRISCHKO Kevin</a></strong></p>
        <div class="socials">
            <div class="fb">
                <a href="" target="_blank">
                    <i class="fa-brands fa-square-facebook"></i>
                </a>
            </div>
            <div class="twitter">
                <a href="" target="_blank">
                    <i class="fa-brands fa-square-twitter"></i>
                </a>
            </div>
            <div class="insta">
                <a href="" target="_blank">
                    <i class="fa-brands fa-instagram"></i>
                </a>
            </div>
        </div>
        <!-- <button id="ajaxbtn">Surprise en Ajax !</button> -> cliqué <span id="nbajax">0</span> fois -->
    </footer>
</div>
</body>

</html>