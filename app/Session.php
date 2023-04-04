<?php

namespace App;

class Session
{

    private static $categories = ['error', 'success'];

    /**
     *   ajoute un message en session, dans la catégorie $categ
     */
    public static function addFlash($categ, $msg)
    {
        $_SESSION[$categ] = $msg;
    }

    /**
     *   renvoie un message de la catégorie $categ, s'il y en a !
     */
    public static function getFlash($categ)
    {

        if (isset($_SESSION[$categ])) {
            $msg = $_SESSION[$categ];
            unset($_SESSION[$categ]);
        } else $msg = "";

        return $msg;
    }

    /**
     *   met un user dans la session (pour le maintenir connecté)
     */
    public static function setUser($user)
    {
        $_SESSION["user"] = $user;
        if (!$user or empty($user)) {
            unset($_SESSION['_token']);
        }
    }

    public static function getUser()
    {
        return (isset($_SESSION['user'])) ? $_SESSION['user'] : false;
    }

    public static function isAdmin()
    {
        if (self::getUser() && self::getUser()->hasRole("ROLE_ADMIN")) {
            return true;
        }
        return false;
    }

    public static function getToken()
    {
        return (isset($_SESSION['_token'])) ? $_SESSION['_token'] : false;
    }

    public static function checkToken()
    {
        $token = filter_input(INPUT_POST, '_token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $result = false;
        $_token = self::getToken();

        if ($_token) {
            $result = ($token == $_token);
            if (!$result) {
                self::setUser(null);

                self::addFlash("error", "Une erreur est survenue");
                header('location: index.php?ctrl=security&action=loginForm');
            }
        }
        unset($_SESSION['_token']);
        return $result;
    }
}
