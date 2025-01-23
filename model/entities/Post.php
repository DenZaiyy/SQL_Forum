<?php

namespace Model\Entities;

use App\Entity;

final class Post extends Entity
{

	private int $id;
	private string $message;
	private $date;
	private Topic $topic;
	private User $user;

	public function __construct($data)
	{
		$this->hydrate($data);
	}

	/**
	 * Get the value of id
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * Set the value of id
	 *
	 */
	public function setId($id): Post
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * Get the value of user
	 */
	public function getUser(): User
	{
		return $this->user;
	}

	/**
	 * Set the value of user
	 *
	 */
	public function setUser($user): Post
	{
		$this->user = $user;

		return $this;
	}

	public function getDate()
	{
        return $this->date->format("d/m/Y, H:i:s");
	}

	public function setDate($date)
	{
		$this->date = new \DateTime($date);
		return $this;
	}

	/**
	 * Get the value of closed
	 */
	public function getTopic(): Topic
	{
		return $this->topic;
	}

	/**
	 * Set the value of closed
	 *
	 * @return  self
	 */
	public function setTopic($topic)
	{
		$this->topic = $topic;

		return $this;
	}

	/**
	 * Get the value of message
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * Set the value of message
	 *
	 * @return  self
	 */
	public function setMessage($message)
	{
		$this->message = $message;

		return $this;
	}
}
