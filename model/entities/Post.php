<?php

namespace Model\Entities;

use App\Entity;

final class Post extends Entity
{

	private $id;
	private $message;
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

	public function getDate()
	{
		$formattedDate = $this->date->format("d/m/Y, H:i:s");
		return $formattedDate;
	}

	public function setDate($date)
	{
		$this->date = new \DateTime($date);
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
