<?php

namespace Model\Entities;

use App\Entity;

final class Post extends Entity
{

	private $id;
	private $message;
	private $creationdate;
	private Topic $topic;
	private User $user;

	public function __construct($data)
	{
		$this->hydrate($data);
	}

	/**
	 * Get the value of id
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set the value of id
	 *
	 * @return  self
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * Get the value of title
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * Set the value of title
	 *
	 * @return  self
	 */
	public function setMessage($message)
	{
		$this->message = $message;

		return $this;
	}

	/**
	 * Get the value of user
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Set the value of user
	 *
	 * @return  self
	 */
	public function setUser($user)
	{
		$this->user = $user;

		return $this;
	}

	public function getCreationdate()
	{
		$formattedDate = $this->creationdate->format("d/m/Y, H:i:s");
		return $formattedDate;
	}

	public function setCreationdate($date)
	{
		$this->creationdate = new \DateTime($date);
		return $this;
	}

	/**
	 * Get the value of closed
	 */
	public function getTopic()
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
}
