<?php

namespace App\Model;

class SkillManager extends AbstractManager
{

    /**
     *  Initializes this class.
     */
    const TABLE = "skills";
  
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    
    /**
     * Get one row from database by ID.
     *
     * @param int $projectId
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

    /**
     * @param array $project
     * @param int $projectId
     */
    public function updateForProject(array $project, int $projectId)
    {
        $delete = $this->pdo->prepare(
            "DELETE FROM project_need_skills  
                        WHERE project_id=:project_id"
        );
        $delete->bindValue('project_id', $projectId, \PDO::PARAM_INT);
        $delete->execute();

        // REQUEST INSERT THE PROJECT SKILLS IN project_need_skills AFTER DELETE PRECEDE SKILLS IN project_need_skills
        if (isset($project['skills'])) {
            foreach ($project['skills'] as $skillId) {
                $insert = $this->pdo->prepare(
                    "INSERT INTO project_need_skills (project_id, skill_id)
                        VALUES (:project_id, :skillId)"
                );
                $insert->bindValue('project_id', $projectId, \PDO::PARAM_INT);
                $insert->bindValue('skillId', $skillId, \PDO::PARAM_INT);
                $insert->execute();
            }
        }

    public function getAllSkills()
    {
        return $this->pdo->query(
            "SELECT * FROM skills"
        )->fetchAll();
    }

    public function getAllUserSkills()
    {
        return $this->pdo->query(
            "SELECT * FROM user_has_skills"
        )->fetchAll();

    }
}
