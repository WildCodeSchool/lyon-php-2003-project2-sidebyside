<?php

namespace App\Model;

class MessageManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'messages';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectByUser(int $userId)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE to_user=:id ORDER BY id DESC");
        $statement->bindValue('id', $userId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectByProject(int $projectId)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT m.id, m.author, m.to_project, 
                                                        m.message, m.created_at, 
                                                        u.first_name, u.last_name, 
                                                        u.profil_picture, u.email 
                                                        FROM $this->table m 
                                                        JOIN users u 
                                                        ON m.author=u.id 
                                                        WHERE to_project=:id 

                                                        ORDER BY m.id DESC");
        $statement->bindValue('id', $projectId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function createToProject(array $message)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
                                                    " (author, 
                                                    to_project,  
                                                    message, 
                                                    created_at) 
                                                    VALUES 
                                                    (:author, 
                                                    :project, 
                                                    :message, 
                                                    NOW())");
        $statement->bindValue(':author', $message['author'], \PDO::PARAM_INT);
        $statement->bindValue(':project', $message['to_project'], \PDO::PARAM_INT);
        $statement->bindValue(':message', $message['message'], \PDO::PARAM_STR);
        $statement->execute();
    }
}
