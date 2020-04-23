<?php


namespace App\Model;

class SkillManager extends AbstractManager
{

    const TABLE = 'skills';

    /**
     *  Initializes this class.
     */

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Get one row from database by ID.
     *
     * @param $projectId
     * @return array
     */
    public function getAllForProject($projectId)
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table 
        JOIN project_need_skills AS pns ON skills.id = pns.skill_id
        WHERE pns.project_id=:project_id");
        $statement->bindValue('project_id', $projectId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
