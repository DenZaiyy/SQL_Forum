<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;

class SecurityController extends AbstractController implements ControllerInterface
{

    public function index()
    {
    }

    public function registerForm()
    {
        return [
            "view" => VIEW_DIR . "security/register.php"
        ];
    }

    public function loginForm()
    {
        return [
            "view" => VIEW_DIR . "security/login.php"
        ];
    }

    public function register()
    {
        // $target_dir = "public/img/uploads/"; //chemin ou l'image va être upload
        // $target_file = $target_dir . uniqid() . "-" . basename($_FILES['avatar']['name']); //chemin du fichier avec le nom contenant un id unique + extension du fichier
        // $file_tmp = $_FILES['avatar']['tmp_name']; //le nom temporaire qui va être utiliser pour l'upload sur le serveur
        // $uploadOk = 1; //initialisation du statu d'upload à 1
        // $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); //permet de récuperer l'extension du fichier à upload

        if (!empty($_POST)) {
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $confirmPassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // $avatar = $target_file;

            if ($pseudo && $email && $password) {
                if (($password == $confirmPassword) and strlen($password) >= 8) {
                    $manager = new UserManager();
                    $user = $manager->findOneByPseudo($pseudo);

                    if (!$user) {
                        $hash = password_hash($password, PASSWORD_DEFAULT);

                        if ($manager->add([
                            "pseudo" => $pseudo,
                            "mail" => $email,
                            "password" => $hash,
                            "role" => '"ROLE_USER"'
                        ])) {
                            $this->redirectTo("security", "loginForm");
                            SESSION::addFlash("success", "Vous êtes bien inscrit");
                        } else {
                            $this->redirectTo("security", "registerForm");
                            SESSION::addFlash("error", "Erreur d'inscription");
                        }
                    } else {
                        $this->redirectTo("security", "registerForm");
                        SESSION::addFlash("error", "Pseudo déjà utilisé");
                    }
                } else {
                    $this->redirectTo("security", "registerForm");
                    SESSION::addFlash("error", "Information incorrect");
                }
            }
        }
    }

    public function login()
    {
        if (!empty($_POST)) {
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($pseudo && $password) {

                $manager = new UserManager();
                $user = $manager->findOneByPseudo($pseudo);

                $hash = password_hash($password, PASSWORD_DEFAULT);

                if ($user) {
                    if (password_verify($password, $hash)) {
                        $manager->connectUser($pseudo, $password);
                        SESSION::setUser($pseudo);

                        SESSION::addFlash("success", "Bravo " . SESSION::getUser() . ", vous êtes connecté!");
                        $this->redirectTo("forum", "listTopics");
                    } else {
                        $this->redirectTo("security", "loginForm");
                        SESSION::addFlash("error", "Une erreur est survenue lors de la connexion");
                    }
                } else {
                    $this->redirectTo("security", "loginForm");
                    SESSION::addFlash("error", "Identifiant incorrect");
                }
            } else {
                $this->redirectTo("security", "loginForm");
                SESSION::addFlash("error", "Identifiant incorrect");
            }
        }
    }

    public function modifyPassword()
    {
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        $this->redirectTo("security", "loginForm");
    }
}
