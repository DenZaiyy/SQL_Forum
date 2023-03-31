<?php

namespace Model\Entities;

use App\Entity;

final class Like extends Entity
{

    private User $user;
    private Topic $topic;

    public function __construct($data)
    {
        $this->hydrate($data);
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

    /**
     * Get the value of topic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set the value of topic
     *
     * @return  self
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }
}
