<?php

namespace App\Model;

class RequestManager extends AbstractManager
{
    const TABLE = 'projects';

    /**
     *  Initializes this class.
     */

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    // REQUEST USERS WHO ASK FOR COLLABORATION ON PROJECT BY ID
    public function selectRequestForCollaboration(int $id)
    {
        $statement = $this->pdo->prepare("SELECT c.user_id, c.project_id, c.message, c.status, c.created_at
                                                        FROM user_ask_collaboration_projects c 
                                                        JOIN " . self::TABLE . " p 
                                                        ON c.project_id=p.id 
                                                        WHERE p.id=:id
                                                        AND c.status='pending'");
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    // REQUEST TO INSERT ASK COLLABORATION IN user_ask_collaboration_projects
    public function askCollaboration(array $message, int $id) : void
    {
        $insert = $this->pdo->prepare("INSERT INTO user_ask_collaboration_projets 
                                                    (user_id, project_id, message, created_at) 
                                                    VALUES (:user_id, :project_id, :message, NOW())");
        $insert->bindValue('user_id', $message['id'], \PDO::PARAM_INT);
        $insert->bindValue('project_id', $id, \PDO::PARAM_INT);
        $insert->bindValue('message', $message['message'], \PDO::PARAM_STR);

        $insert->execute();
    }

    public function validateRequest($userId, $projectId)
    {
        $statement = $this->pdo->prepare("UPDATE user_ask_collaboration_projects uc 
                                                        SET status='ok' 
                                                        WHERE uc.user_id=:userId 
                                                        AND uc.project_id=:projectId");
        $statement->bindValue(':userId', $userId, \PDO::PARAM_INT);
        $statement->bindValue(':projectId', $projectId, \PDO::PARAM_INT);
        $statement->execute();

        $statement = $this->pdo->prepare("INSERT INTO project_has_collaborators (projet_id, user_id, join_at) 
                                                        VALUES (:projectId, :userId, NOW())");
        $statement->bindValue(':userId', $userId, \PDO::PARAM_INT);
        $statement->bindValue(':projectId', $projectId, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function ignoreRequest($userId, $projectId)
    {
        $statement = $this->pdo->prepare("UPDATE user_ask_collaboration_projects uc 
                                                        SET status='ignore' 
                                                        WHERE uc.user_id=:userId 
                                                        AND uc.project_id=:projectId");
        $statement->bindValue(':userId', $userId, \PDO::PARAM_INT);
        $statement->bindValue(':projectId', $projectId, \PDO::PARAM_INT);
        $statement->execute();
    }
}
