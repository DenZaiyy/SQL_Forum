<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class TopicManager extends Manager
{

    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";


    public function __construct()
    {
        parent::connect();
    }

    //function find last five topics
    public function findLastFiveTopics($order = null)
    {
        $orderQuery = ($order) ?
            "ORDER BY " . $order[0] . " " . $order[1] :
            "";

        $sql = "SELECT * FROM topic t " .
            $orderQuery .
            " LIMIT 5";

        return $this->getMultipleResults(
            DAO::select($sql),
            $this->className
        );
    }

    //function find all topics in category
    public function findAllTopicsInCategory($id)
    {
        $sql = "SELECT *
                FROM " . $this->tableName . " t
                WHERE t.category_id = :id";

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id], true),
            $this->className
        );
    }

    //function find all topics by user
    public function findAllByUser($id)
    {
        $sql = "SELECT *
                FROM " . $this->tableName . " t
                WHERE t.user_id = :id";

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id], true),
            $this->className
        );
    }

    //function delete topic
    public function delete($id)
    {
        $sql = "DELETE FROM `" . $this->tableName . "` t
                WHERE t.id_topic = :id";

        return DAO::delete($sql, ['id' => $id]);
    }

    //function to lock topic id
    public function lockTopic($id)
    {
        $sql = "UPDATE `" . $this->tableName . "` 
                SET `lock` = 1
                WHERE id_topic = :id";

        return DAO::update($sql, ['id' => $id]);
    }

    //function to unlock topic id
    public function unlockTopic($id)
    {
        $sql = "UPDATE `" . $this->tableName . "` 
                SET `lock` = 0
                WHERE id_topic = :id";

        return DAO::update($sql, ['id' => $id]);
    }

    //function to update topic id with title and category id
    public function updateTopic($title, $categoryId, $id)
    {
        $sql = "UPDATE `" . $this->tableName . "` 
                SET `title` = :title, 
                    `category_id` = :categoryId,
                    'date' = NOW(), 
                WHERE id_topic = :id";

        return DAO::update(
            $sql,
            [
                'id_topic' => $id,
                'title' => $title,
                'category_id' => $categoryId
            ]
        );
    }
}
