<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class PostManager extends Manager
{

    protected $className = "Model\Entities\Post";
    protected $tableName = "message";


    public function __construct()
    {
        parent::connect();
    }

    public function findAllById($id, $order = null)
    {
        $orderQuery = ($order) ?
            "ORDER BY " . $order[0] . " " . $order[1] :
            "";

        $sql = "SELECT * FROM message m, topic t
                WHERE m.topic_id = t.id_topic
                AND t.id_topic = :id" .
            $orderQuery;

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id], true),
            $this->className
        );
    }

    public function findFirstById($id)
    {
        $sql = "SELECT * FROM message m, topic t
                WHERE m.topic_id = t.id_topic
                AND m.topic_id = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id], false),
            $this->className
        );
    }
}
