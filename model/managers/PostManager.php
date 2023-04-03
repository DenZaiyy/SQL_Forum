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

		$sql = "SELECT m.id_message, m.message, m.date, m.topic_id, m.user_id 
				FROM message m, topic t
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
				AND m.topic_id = :id
				ORDER BY m.date ASC
				LIMIT 1";

		return $this->getOneOrNullResult(
			DAO::select($sql, ['id' => $id], false),
			$this->className
		);
	}

	public function updateMessagePost($message, $topicID)
	{
		$sql = "UPDATE `" . $this->tableName . "` m
				SET message = :message
				WHERE topic_id = :topicID
				ORDER BY m.date ASC
				LIMIT 1";

		return DAO::update($sql, ['message' => $message, 'topicID' => $topicID]);
	}

	public function deletePost($id)
	{
		$sql = "DELETE FROM `" . $this->tableName . "` m
				WHERE m.id_message = :id";

		return DAO::delete($sql, ['id' => $id]);
	}

	//function delete all post in a topic id
	public function deleteAllPost($id)
	{
		$sql = "DELETE FROM `" . $this->tableName . "` m
				WHERE m.topic_id = :id";

		return DAO::delete($sql, ['id' => $id]);
	}

	//count all post in a topic id
	public function countPost($id)
	{
		$sql = "SELECT COUNT(*) AS nbPost
				FROM message m, topic t
				WHERE m.topic_id = t.id_topic
				AND m.topic_id = :id";

		return $this->getOneOrNullResult(
			DAO::select($sql, ['id' => $id], false),
			$this->className
		);
	}
}
