<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager
{

    protected $className = "Model\Entities\User";
    protected $tableName = "user";


    public function __construct()
    {
        parent::connect();
    }

    public function findOneByPseudo($data)
    {
        $sql = "SELECT *
                FROM `" . $this->tableName . "` u
                WHERE u.pseudo = :pseudo";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['pseudo' => $data], false),
            $this->className
        );
    }

    public function connectUser($pseudo, $password)
    {
        $sql = "SELECT u.id_user, u.pseudo, u.avatar
                FROM `" . $this->tableName . "` u 
                WHERE u.pseudo = :pseudo 
                AND u.password = :password";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['pseudo' => $pseudo, 'password' => $password], false),
            $this->className
        );
    }

    // function updatePassword ($pseudo, $password) for SecurityController.php
    public function updatePassword($id, $password)
    {
        $sql = "UPDATE `" . $this->tableName . "` u
                SET u.password = :password
                WHERE u.id_user = :id";

        return DAO::update(
            $sql,
            [
                'id' => $id,
                'password' => $password
            ]
        );
    }

    //function updateRole
    public function updateRole($id, $role)
    {
        $sql = "UPDATE `" . $this->tableName . "` u 
                SET u.role = :role
                WHERE u.id_user = :id";

        return DAO::update(
            $sql,
            [
                'id' => $id,
                'role' => json_encode($role)
            ]
        );
    }

    //function to update user infos
    public function updateInfos($id, $pseudo, $email, $avatar)
    {
        $sql = "UPDATE `" . $this->tableName . "` u 
                SET u.pseudo = :pseudo, 
                    u.mail = :email, 
                    u.avatar = :avatar
                WHERE u.id_user = :id";

        return DAO::update(
            $sql,
            [
                'id' => $id,
                'pseudo' => $pseudo,
                'email' => $email,
                'avatar' => $avatar
            ]
        );
    }
}
