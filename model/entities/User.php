<?php

namespace Model\Entities;

use App\Entity;

final class User extends Entity
{

	private $id;
	private $pseudo;
	private $mail;
	private $password;
	private $createdAt;
	private $avatar;
	private $role;

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
	 * Get the value of pseudo
	 */
	public function getPseudo()
	{
		return $this->pseudo;
	}

	/**
	 * Set the value of pseudo
	 *
	 * @return  self
	 */
	public function setPseudo($pseudo)
	{
		$this->pseudo = $pseudo;

		return $this;
	}

	public function getCreatedAt()
	{
		$formattedDate = $this->createdAt->format("d/m/Y, H:i:s");
		return $formattedDate;
		// return $this->createdAt;
	}

	public function setCreatedAt($date)
	{
		$this->createdAt = new \DateTime($date);
		return $this;
	}

	/**
	 * Get the value of avatar
	 */
	public function getAvatar()
	{
		return $this->avatar;
	}

	/**
	 * Set the value of avatar
	 *
	 * @return  self
	 */
	public function setAvatar($avatar)
	{
		$this->avatar = $avatar;

		return $this;
	}

	/**
	 * Get the value of role
	 */
	public function getRole()
	{
		return json_decode($this->role);
	}

	/**
	 * Set the value of role
	 *
	 * @return  self
	 */
	public function setRole($role)
	{
		$this->role = json_encode($role);

		return $this;
	}

	public function hasRole($role)
	{
		$result = $this->getRole() == json_encode($role);
		return $result;
	}

	/**
	 * Get the value of email
	 */
	public function getMail()
	{
		return $this->mail;
	}

	/**
	 * Set the value of email
	 *
	 * @return  self
	 */
	public function setMail($mail)
	{
		$this->mail = $mail;

		return $this;
	}

	/**
	 * Get the value of password
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Set the value of password
	 *
	 * @return  self
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}
}
