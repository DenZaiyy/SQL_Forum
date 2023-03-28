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

    //List of topics
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

    //Detail for one Topic
    public function detailTopic($id)
    {
        $topicManager = new TopicManager();
        $postManager = new PostManager();

        return [
            "view" => VIEW_DIR . "topic/detailTopic.php",
            "data" => [
                "topic" => $topicManager->findOneById($id),
                "firstMessage" => $postManager->findFirstById($id),
                "findComments" => $postManager->findAllById($id)
            ]
        ];
    }

    //List of categories
    public function listCategories()
    {
        return [
            "view" => VIEW_DIR . "category/listCategories.php"
        ];
    }

    //List of topics for one category
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
