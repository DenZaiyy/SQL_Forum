<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class LikeManager extends Manager
{

    protected $className = "Model\Entities\Like";
    protected $tableName = "like";


    public function __construct()
    {
        parent::connect();
    }

    public function findOneByPseudo($user)
    {
        $sql = "SELECT * 
                FROM `" . $this->tableName . "` u 
                WHERE u.user_id = ?";

        return $this->getOneOrNullResult(
            DAO::select($sql, [$user]),
            $this->className
        );
    }

    public function findOneByTopic($topic)
    {
        $sql = "SELECT * 
                FROM `" . $this->tableName . "` u 
                WHERE u.topic_id = ?";

        return $this->getOneOrNullResult(
            DAO::select($sql, [$topic]),
            $this->className
        );
    }

    public function deleteLike($topicID, $userID)
    {
        $sql = "DELETE FROM `" . $this->tableName . "` 
                WHERE topic_id = :topic
                AND user_id = :user";

        return DAO::delete($sql, [
            "topic" => $topicID,
            "user" => $userID
        ]);
    }

    public function updateLikes($topicID)
    {
        $sql = "UPDATE topic t
                SET likes = (
                    SELECT COUNT(*) 
                    FROM `" . $this->tableName . "` l 
                    WHERE l.topic_id = ?
                )
                WHERE t.id_topic = ?";

        return $this->getMultipleResults(
            DAO::select($sql, [$topicID, $topicID], true),
            $this->className
        );
    }

    public function countLikes($topicID)
    {
        $sql = "SELECT COUNT(*)
                FROM `" . $this->tableName . "` l 
                WHERE l.topic_id = ?";

        return $this->getOneOrNullResult(
            DAO::select($sql, [$topicID]),
            $this->className
        );
    }
}
