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
    }

    public function login()
    {
    }
}
