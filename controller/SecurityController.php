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
            "view" => VIEW_DIR . "security/register.php",
            "data" => null
        ];
    }

    public function loginForm()
    {
        return [
            "view" => VIEW_DIR . "security/login.php",
            "data" => null
        ];
    }

    public function register()
    {
        if (!empty($_POST)) {
            $nickname = filter_input(INPUT_POST, $_POST['pseudo'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, $_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, $_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $confirmPassword = filter_input(INPUT_POST, $_POST['confirmPassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($nickname && $password && $email) {
                if (($password == $confirmPassword) and strlen($password >= 8)) {
                    $manager = new UserManager();
                    $user = $manager->findOneByPseudo($nickname);

                    if (!$user) {
                        $hash = password_hash($password, PASSWORD_DEFAULT);

                        if ($manager->add([
                            "pseudo" => $nickname,
                            "email" => $email,
                            "password" => $hash,
                        ])) {
                            return var_dump("Vous êtes bien inscrit");
                        }
                    }
                }
            }
        }

        return [
            "view" => VIEW_DIR . "security/register.php"
        ];
    }

    public function login()
    {
    }
}
