<?php


namespace App\Model;

class SkillManager extends AbstractManager
{
    const TABLE = "skills";


    public function __construct()
    {
        parent::__construct(self::TABLE);
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
