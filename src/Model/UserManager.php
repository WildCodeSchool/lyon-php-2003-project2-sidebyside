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
JOIN user_has_skills ON users.id=user_id JOIN skills ON skill_id=skills.id ORDER BY user_id")->fetchAll();
    }

    public function selectByName(string $keyword) : array
    {
        $query = "SELECT last_name, first_name, id, email, zip_code FROM users 
WHERE first_name LIKE :keyword";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':keyword', "%$keyword%");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
