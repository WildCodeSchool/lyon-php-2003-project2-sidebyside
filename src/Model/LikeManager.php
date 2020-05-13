<?php

namespace App\Model;

class LikeManager extends AbstractManager
{
    const TABLE = 'user_like_projects';

    /**
     *  Initializes this class.
     */

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function like($like)
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO $this->table
                        (user_id, project_id,`like`, created_at)
                        VALUES 
                        (:user_id, :project_id, 1, NOW())"
        );
        $statement->bindValue('user_id', $like['user_id'], \PDO::PARAM_INT);
        $statement->bindValue('project_id', $like['project_id'], \PDO::PARAM_INT);

        $statement->execute();
    }

    public function delete($like)
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " 
        WHERE user_id =:user_id AND project_id =:project_id");
        $statement->bindValue('user_id', $like['user_id'], \PDO::PARAM_INT);
        $statement->bindValue('project_id', $like['project_id'], \PDO::PARAM_INT);
        $statement->execute();
    }

    public function selectAllById(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE project_id = :project_id");
        $statement->bindValue('project_id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
