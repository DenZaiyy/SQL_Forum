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
}
