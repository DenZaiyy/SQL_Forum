<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\UserManager;

class ForumController extends AbstractController implements ControllerInterface
{

    // public function index()
    // {

    //     $topicManager = new TopicManager();

    //     return [
    //         "view" => VIEW_DIR . "topic/listTopics.php",
    //         "data" => [
    //             "topics" => $topicManager->findAll(["date", "DESC"])
    //         ]
    //     ];
    // }

    public function listTopics()
    {
        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR . "topic/listTopics.php",
            "data" => [
                "topics" => $topicManager->findAll()
            ]
        ];
    }

    public function detailTopic($id)
    {
        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR . "topic/detailTopic.php",
            "data" => [
                "topics" => $topicManager->findOneById($id)
            ]
        ];
    }

    public function listCategories()
    {
        return [
            "view" => VIEW_DIR . "category/listCategories.php"
        ];
    }

    public function detailCategory($id)
    {
        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR . "category/detailCategory.php",
            "data" => [
                "topics" => $topicManager->findAllTopicsInCategory($id)
            ]
        ];
    }
}
