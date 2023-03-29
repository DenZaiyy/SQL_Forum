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
        if (!empty($_POST)) {
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $confirmPassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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
                        ])) {
                            return [
                                "view" => VIEW_DIR . "security/login.php",
                                SESSION::addFlash("success", "Vous êtes bien inscrit")
                            ];
                        } else {
                            return [
                                "view" => VIEW_DIR . "security/register.php",
                                SESSION::addFlash("error", "Erreur d'inscription")
                            ];
                        }
                    } else {
                        return [
                            "view" => VIEW_DIR . "security/register.php",
                            SESSION::addFlash("error", "Pseudo déjà utilisé")
                        ];
                    }
                } else {
                    return [
                        "view" => VIEW_DIR . "security/register.php",
                        SESSION::addFlash("error", "Information incorrect")
                    ];
                }
            }
        }
    }

    public function login()
    {
        if (!empty($_POST)) {
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $hash = password_hash($password, PASSWORD_DEFAULT);

            if ($pseudo && $password) {
                if (password_verify($password, $hash)) {
                    $manager = new UserManager();
                    $manager->connectUser($pseudo, $password);
                    SESSION::setUser($pseudo);
                    return [
                        "view" => VIEW_DIR . "home.php",
                        SESSION::addFlash("success", "Bravo " . SESSION::getUser() . ", vous êtes connecté!")
                    ];
                } else {
                    return [
                        "view" => VIEW_DIR . "security/login.php",
                        SESSION::addFlash("error", "Une erreur est survenue lors de la connexion")
                    ];
                }
            } else {
                return [
                    "view" => VIEW_DIR . "security/login.php",
                    SESSION::addFlash('error', 'Identifiant incorrect.')
                ];
            }
        }
    }

    public function modifyPassword()
    {
    }

    public function logout()
    {
    }
}
