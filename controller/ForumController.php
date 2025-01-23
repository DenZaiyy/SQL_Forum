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

    public function index(): array
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
    public function listTopics(): array
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
    public function detailTopic($id): array
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
                "countComments" => $postManager->countPost($id),
                "like" => $likeManager->countLikes($id)
            ]
        ];
    }

    //function for return to the form to add a new topic
    public function addTopicForm(): array
    {
        return [
            "view" => VIEW_DIR . "topic/addTopic.php"
        ];
    }

    //List of categories
    public function listCategories(): array
    {
        return [
            "view" => VIEW_DIR . "category/listCategories.php"
        ];
    }

    //List of topics for one category
    public function detailCategory($id): array
    {
        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR . "category/detailCategory.php",
            "data" => [
                "topics" => $topicManager->findAllTopicsInCategory($id)
            ]
        ];
    }

    //function to add new comment to a topic
    public function addComment(): void
    {
        if (!empty($_POST)) {
            $postManager = new PostManager();

            $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $token = filter_input(INPUT_POST, "_token", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            if (SESSION::checkToken($token)) {

                if ($message) {
                    $postManager->add(
                        [
                            "message" => $message,
                            "date" => date("Y-m-d H:i:s"),
                            "topic_id" => $_GET['id'],
                            "user_id" => SESSION::getUser()->getId(),
                        ]
                    );
                } else {
                    SESSION::addFlash("error", "Veuillez remplir tous les champs");
                }

                unset($_SESSION['_token']);

                SESSION::addFlash("success", "Votre commentaire a bien été ajouté");
                $this->redirectTo("forum", "detailTopic", $_GET['id']);
            } else {
                SESSION::addFlash("error", "Token invalide");
                $this->redirectTo("security", "loginForm");
            }
        } else {
            SESSION::addFlash("error", "Veuillez remplir tous les champs");
            $this->redirectTo("forum", "detailTopic", $_GET['id']);
        }
    }

    public function deleteComment($id): void
    {
        $postManager = new PostManager();
        $topicID = $postManager->findOneById($id)->getTopic()->getId();
        $postManager->deletePost($id);
        SESSION::addFlash('success', 'Votre commentaire a bien été supprimé');
        $this->redirectTo("forum", "detailTopic", $topicID);
    }

    //function to add new topic with first message
    public function addTopic(): void
    {
        if (!empty($_POST)) {
            $topicManager = new TopicManager();
            $postManager = new PostManager();

            //filtre les données
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $token = filter_input(INPUT_POST, "_token", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (SESSION::checkToken($token)) {

                if ($title && $message) {
                    $id = $topicManager->add(
                        [
                            "title" => $title,
                            "user_id" => SESSION::getUser()->getId(),
                            "date" => date("Y-m-d H:i:s"),
                            "category_id" => $_GET['id'],
                        ]
                    );

                    $postManager->add(
                        [
                            "message" => $message,
                            "date" => date("Y-m-d H:i:s"),
                            "topic_id" => $id,
                            "user_id" => SESSION::getUser()->getId(),
                        ]
                    );
                }
                unset($_SESSION['_token']);

                SESSION::addFlash("success", "Votre sujet a bien été ajouté");
                $this->redirectTo("forum", "detailTopic", $id);
            } else {
                SESSION::addFlash("error", "Token invalide");
                $this->redirectTo("security", "loginForm");
            }
        } else {
            unset($_SESSION['_token']);

            SESSION::addFlash("error", "Veuillez remplir tous les champs");
            $this->redirectTo("forum", "addTopicForm", $_GET['id']);
        }
    }

    //function for the form to edit a topic
    public function editForm(): array
    {
        $topicManager = new TopicManager();
        $postManager = new PostManager();

        return [
            "view" => VIEW_DIR . "topic/editTopic.php",
            "data" => [
                "topic" => $topicManager->findOneById($_GET['id']),
                "firstMessage" => $postManager->findFirstById($_GET['id'])
            ]
        ];
    }


    //function to edit a topic
    public function editTopic($id): void
    {
        if (!empty($_POST)) {
            $category = filter_input(INPUT_POST, "category", FILTER_SANITIZE_NUMBER_INT);
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $token = filter_input(INPUT_POST, "_token", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (SESSION::checkToken($token)) {

                $topicManager = new TopicManager();
                $postManager = new PostManager();

                if ($category && $title && $message) {
                    $topicManager->updateTopic($title, $category, $id);
                    $postManager->updateMessagePost($message, $id);
                }

                unset($_SESSION['_token']);

                SESSION::addFlash("success", "Votre sujet a bien été modifié");
                $this->redirectTo("forum", "detailTopic", $id);
            } else {
                SESSION::addFlash("error", "Token invalide");
                $this->redirectTo("security", "loginForm");
            }
        } else {
            SESSION::addFlash("error", "Veuillez remplir tous les champs");
            $this->redirectTo("forum", "detailTopic", $id);
        }
    }

    //function detailUser to show user's profile
    public function detailUser($id): array
    {
        $topicManager = new TopicManager();
        $userManager = new UserManager();

        $user = $userManager->findOneById($id);

        return [
            "view" => VIEW_DIR . "security/detailUser.php",
            "data" => [
                "user" => $user,
                "topics" => $topicManager->findAllByUser($id)
            ]
        ];
    }

    //Function like for topics
    public function like(): void
    {
        if (!empty($_POST)) {
            $likeManager = new LikeManager();

            //find id of connected user in session
            $user = SESSION::getUser()->getId();

            //get the id of the topic
            $topic = $_GET['id'];

            //look if there is a dublicate of the user and the topic
            $userLike = $likeManager->findOneByPseudo($user, $topic);

            if (!$userLike) {
                $likeManager->add(
                    [
                        "user_id" => $user,
                        "topic_id" => $topic,
                    ]
                );

                unset($_SESSION['_token']);

                $this->redirectTo("forum", "detailTopic", $topic);
            } else {
                $likeManager->deleteLike($topic, $user);
                $this->redirectTo("forum", "detailTopic", $topic);
            }

            $this->redirectTo("forum", "listTopics");
        }
    }

    //function to delete a topic
    public function deleteTopic($id): void
    {
        $topicManager = new TopicManager();
        $postManager = new PostManager();
        $likeManager = new LikeManager();

        $postManager->deleteAllPost($id);
        $likeManager->deleteAllLike($id);
        $topicManager->delete($id);


        $this->redirectTo("forum", "listTopics");
        SESSION::addFlash("success", "Votre topic a bien été supprimé");
    }

    //function to lock a topic
    public function lockTopic($id): void
    {
        $topicManager = new TopicManager();

        $topicManager->lockTopic($id);

        $this->redirectTo("forum", "detailTopic", $id);
        SESSION::addFlash("success", "Votre topic a bien été verrouillé");
    }

    //function to unlock a topic
    public function unlockTopic($id): void
    {
        $topicManager = new TopicManager();

        $topicManager->unlockTopic($id);

        $this->redirectTo("forum", "detailTopic", $id);
        SESSION::addFlash("success", "Votre topic a bien été déverrouillé");
    }
}
