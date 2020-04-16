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

        return $this->pdo->query("SELECT user_id, name FROM users JOIN user_has_skills ON users.id=user_id JOIN skills ON skill_id=skills.id ORDER BY user_id")->fetchAll();

    }
}