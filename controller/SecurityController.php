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

    public function settings()
    {
        // $this->restrictTo("ROLE_USER");

        $manager = new UserManager();
        $user = $manager->findOneById(SESSION::getUser()->getId());

        return [
            "view" => VIEW_DIR . "security/settings.php",
            "data" => [
                "user" => $user
            ]
        ];
    }

    //function to register a new user
    public function register()
    {
        $target_dir = "public/img/uploads/"; //chemin ou l'image va être upload
        $target_file = $target_dir . uniqid() . "-" . basename($_FILES['avatar']['name']); //chemin du fichier avec le nom contenant un id unique + extension du fichier
        $file_tmp = $_FILES['avatar']['tmp_name']; //le nom temporaire qui va être utiliser pour l'upload sur le serveur
        $uploadOk = 1; //initialisation du statu d'upload à 1
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); //permet de récuperer l'extension du fichier à upload



        if (!empty($_POST)) {
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $confirmPassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $avatar = $target_file;

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
                            "avatar" => $avatar,
                            "role" => json_encode("ROLE_USER")
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

    //function to login user
    public function login()
    {
        if (!empty($_POST)) {
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($pseudo && $password) {

                $manager = new UserManager();
                $user = $manager->findOneByPseudo($pseudo);

                $hash = $user->getPassword();

                if ($user) {
                    if (password_verify($password, $hash)) {
                        $manager->connectUser($pseudo, $hash);
                        SESSION::setUser($user);

                        SESSION::addFlash("success", "Bienvenue " . SESSION::getUser()->getPseudo() . " !");
                        $this->redirectTo("home", "index");
                    } else {
                        SESSION::addFlash("error", "Une erreur est survenue lors de la connexion");
                        $this->redirectTo("security", "loginForm");
                    }
                } else {
                    SESSION::addFlash("error", "Identifiant incorrect");
                    $this->redirectTo("security", "loginForm");
                }
            } else {
                SESSION::addFlash("error", "Identifiant incorrect");
                $this->redirectTo("security", "loginForm");
            }
        }
    }

    //function to logout user
    public function logout()
    {
        if (SESSION::getUser()) {
            unset($_SESSION['user']);
            session_destroy();
            SESSION::addFlash("success", "Vous êtes bien déconnecté");
            $this->redirectTo("security", "loginForm");
        } else {
            SESSION::addFlash("error", "Vous devez être connecté pour vous déconnecter");
            $this->redirectTo("security", "loginForm");
        }
    }

    //function to list all users
    public function listUsers()
    {
        $this->restrictTo("ROLE_ADMIN");

        $manager = new UserManager();
        $users = $manager->findAll();

        return [
            "view" => VIEW_DIR . "security/users.php",
            "data" => [
                "users" => $users
            ]
        ];
    }

    //function modifyPassword and use current password to modify password
    public function modifyPassword()
    {
        if (!empty($_POST)) {
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS); //current password
            $newPassword = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS); //new password
            $confirmNewPassword = filter_input(INPUT_POST, 'newPasswordConfirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS); //confirm new password

            $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS); //token

            if (SESSION::checkToken($token)) {

                //if all inputs have validate data
                if ($password && $newPassword && $confirmNewPassword) {
                    $manager = new UserManager();

                    $user = SESSION::getUser(); //find user by pseudo (current user

                    $hash = $user->getPassword(); //hash current password

                    if (password_verify($password, $hash)) {
                        if ($newPassword == $confirmNewPassword) {
                            $hash = password_hash($newPassword, PASSWORD_DEFAULT); //hash new password

                            $manager->updatePassword($user->getId(), $hash); //update password

                            unset($_SESSION['_token']);

                            SESSION::addFlash("success", "Votre mot de passe a bien été modifié");
                            $this->redirectTo("security", "loginForm");
                        } else {
                            unset($_SESSION['_token']);
                            SESSION::addFlash("error", "Les mots de passe ne correspondent pas");
                            $this->redirectTo("security", "loginForm");
                        }
                    } else {
                        SESSION::addFlash("error", "Mot de passe incorrect");
                        $this->redirectTo("security", "loginForm");
                    }
                } else {
                    SESSION::addFlash("error", "Veuillez remplir tous les champs");
                    $this->redirectTo("security", "loginForm");
                }
            } else {
                SESSION::addFlash("error", "Une erreur est survenue");
                $this->redirectTo("security", "loginForm");
            }
        }
    }

    //function to update role of user
    public function updateRole()
    {
        $this->restrictTo("ROLE_ADMIN");

        if (!empty($_POST)) {

            $id = $_GET['id'];
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $token = filter_input(INPUT_POST, '_token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (SESSION::checkToken($token)) {
                $manager = new UserManager();

                $manager->updateRole($id, $role);

                unset($_SESSION['_token']);

                SESSION::addFlash("success", "Le rôle a bien été modifié");
                $this->redirectTo("security", "listUsers");
            } else {
                SESSION::addFlash("error", "Une erreur est survenue");
                $this->redirectTo("security", "loginForm");
            }
        } else {
            SESSION::addFlash("error", "Une erreur est survenue");
            $this->redirectTo("security", "listUsers");
        }
    }

    public function updateInfos()
    {
        if (!empty($_POST)) {
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_EMAIL);
            $avatar = PUBLIC_DIR . "img/default-avatar.png";

            $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (SESSION::checkToken($token)) {
                $id = SESSION::getUser()->getId();

                if ($pseudo && $email) {
                    $manager = new UserManager();
                    $user = $manager->findOneByPseudo($pseudo);

                    if (!$user) {
                        $manager->updateInfos($id, $pseudo, $email, $avatar);

                        unset($_SESSION['_token']);

                        SESSION::addFlash("success", "Vos informations ont bien été modifiées, veuillez vous reconncter");
                        $this->redirectTo("security", "logout");
                    } else {
                        unset($_SESSION['_token']);

                        SESSION::addFlash("error", "Pseudo déjà utilisé");
                        $this->redirectTo("security", "settings");
                    }
                } else {
                    SESSION::addFlash("error", "Veuillez remplir tous les champs");
                    $this->redirectTo("security", "settings");
                }
            } else {
                SESSION::addFlash("error", "Une erreur est survenue");
                $this->redirectTo("security", "settings");
            }
        }
    }
}
