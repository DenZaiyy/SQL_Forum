<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;

class ForumController extends AbstractController implements ControllerInterface
{

    public function index()
    {

        $topicManager = new TopicManager();
        $postManager = new PostManager();

        return [
            "view" => VIEW_DIR . "forum/listTopics.php",
            "data" => [
                "topics" => $topicManager->findAll(["date_topic", "DESC"]),
                "messages" => $postManager->findAll(["date_msg"], "DESC")
            ]
        ];
    }
}
