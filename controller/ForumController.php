<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\LikeManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\UserManager;

class ForumController extends AbstractController implements ControllerInterface
{

    public function index()
    {

        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR . "topic/listTopics.php",
            "data" => [
                "topics" => $topicManager->findAll(["date", "DESC"])
            ]
        ];
    }

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
        $likeManager = new LikeManager();

        return [
            "view" => VIEW_DIR . "topic/detailTopic.php",
            "data" => [
                "topic" => $topicManager->findOneById($id),
                "firstMessage" => $postManager->findFirstById($id),
                "findComments" => $postManager->findAllById($id),
                "like" => $likeManager->updateLikes($id)
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

    //Form for adding new comment to topic
    public function addComment()
    {
        return [
            "view" => VIEW_DIR . "topic/addComment.php"
        ];
    }

    //Function like for topics
    public function like()
    {
        $likeManager = new LikeManager();

        $user = SESSION::getUser()->getId();

        $topic = $_GET['id'];

        $userLiked = $likeManager->findOneByPseudo($user);
        $topicLiked = $likeManager->findOneByTopic($topic);

        if (!$userLiked || !$topicLiked) {
            $likeManager->add(
                [
                    "user_id" => $user,
                    "topic_id" => $topic,
                ]
            );

            $this->redirectTo("forum", "detailTopic", $topic);
        } else {
            $likeManager->deleteLike($topic, $user);
            $this->redirectTo("forum", "detailTopic", $topic);
        }

        $likeManager->updateLikes($topic);
    }
}
