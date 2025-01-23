<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\CategoryManager;

class HomeController extends AbstractController implements ControllerInterface
{

    public function index()
    {

        //if user not connected, redirect to login page
        if (!Session::getUser()) {
            $this->redirectTo("security", "loginForm");
        }

        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR . "home.php",
            "data" => [
                "topics" => $topicManager->findLastFiveTopics(["date", "DESC"]),
            ]
        ];
    }

    /* TODO: add rules and notice */
    public function forumRules()
    {
        return [
            "view" => VIEW_DIR . "rules.php"
        ];
    }

    /*public function ajax(){
            $nb = $_GET['nb'];
            $nb++;
            include(VIEW_DIR."ajax.php");
        }*/
}
