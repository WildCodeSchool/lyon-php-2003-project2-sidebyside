<?php

namespace App\Model;

class UserManager extends AbstractManager
{

    /**
     *
     */
    const TABLE = 'users';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getSkills()
    {
        return $this->pdo->query("SELECT user_id, name FROM users 
                                            JOIN user_has_skills ON users.id=user_id 
                                            JOIN skills ON skill_id=skills.id 
                                            ORDER BY user_id")->fetchAll();
    }

    public function getUserInfo()
    {
        return $this->pdo->query("SELECT * FROM users u 
                                            JOIN user_has_skills uhs ON u.id = uhs.user_id
                                            JOIN skills s ON s.id= uhs.skill_id")->fetchAll();
    }

    public function setUserInfo()
    {

    }
}
