<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
    <link rel="shortcut icon" href="public/img/logo.png" type="image/x-icon">
    <title><?= $title ?></title>
</head>

<body>
    <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
    <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
    <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>
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
                <div class="profil" id="profil">
                    <img src="public/img/default-user.png" alt="image of user" id="user" height="50" width="50">
                    <div class="dropdown-user-menu" id="dropdown">
                        <a href="">
                            <div class="user-info">
                                <img src="public/img/default-user.png" alt="image of user" height="50" width="50">
                                <strong>test</strong>
                            </div>
                        </a>
                        <div class="links">
                            <a href="">Profile</a>
                            <a href="">Settings</a>
                            <a href="index.php?ctrl=forum&action=listTopics">List of topics</a>
                            <a href="index.php?ctrl=forum&action=listCategories">List of categories</a>
                        </div>
                        <div class="btn-disconnect">
                            <a href="">Disconnect</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- <nav>
                    <div id="nav-left">
                        <a href="/">Accueil</a>
                        <?php
                        if (App\Session::isAdmin()) {
                        ?>
                            <a href="index.php?ctrl=home&action=users">Voir la liste des gens</a>

                        <?php
                        }
                        ?>
                    </div>
                    <div id="nav-right">
                        <?php

                        if (App\Session::getUser()) {
                        ?>
                            <a href="/security/viewProfile.html"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser() ?></a>
                            <a href="/security/logout.html">Déconnexion</a>
                        <?php
                        } else {
                        ?>
                            <a href="./view/security/login.php">Connexion</a>
                            <a href="/security/register.html">Inscription</a>
                            <a href="index.php?ctrl=forum&action=listTopics">la liste des topics</a>
                        <?php
                        }


                        ?>
                    </div>
                </nav> -->
        </header>
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
                                <a href="">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </aside>
            <main id="forum">
                <?= $page ?>
            </main>
        </div>


        <footer>
            <?php $date = date('Y'); ?>
            <p><a href="">Legal notice</a> - <a href="/home/forumRules.html">Forum rules</a></p>
            <p>&copy; <?= $date ?> - Created by <strong><a href="https://www.elan-formation.eu/" target="_blank">Elan Formation</a></strong></p>
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $(".message").each(function() {
                if ($(this).text().length > 0) {
                    $(this).slideDown(500, function() {
                        $(this).delay(3000).slideUp(500)
                    })
                }
            })
            $(".delete-btn").on("click", function() {
                return confirm("Etes-vous sûr de vouloir supprimer?")
            })
            // tinymce.init({
            //     selector: '.post',
            //     menubar: false,
            //     plugins: [
            //         'advlist autolink lists link image charmap print preview anchor',
            //         'searchreplace visualblocks code fullscreen',
            //         'insertdatetime media table paste code help wordcount'
            //     ],
            //     toolbar: 'undo redo | formatselect | ' +
            //         'bold italic backcolor | alignleft aligncenter ' +
            //         'alignright alignjustify | bullist numlist outdent indent | ' +
            //         'removeformat | help',
            //     content_css: '//www.tiny.cloud/css/codepen.min.css'
            // });

            $("#profil").on('click', function() {
                $('#dropdown').toggleClass("active");
            })
        })




        // $("#ajaxbtn").on("click", function() {
        //     $.get(
        //         "index.php?action=ajax", {
        //             nb: $("#nbajax").text()
        //         },
        //         function(result) {
        //             $("#nbajax").html(result)
        //         }
        //     )
        // })
    </script>
</body>

</html>