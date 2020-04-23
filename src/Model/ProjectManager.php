<?php


namespace App\Model;

class ProjectManager extends AbstractManager
{

    const TABLE = 'projects';

    /**
     *  Initializes this class.
     */

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $projects
     * @return int
     */
    public function insert(array $projects): int
    {
        // prepared request
        $statement = $this->pdo->prepare(
            "INSERT INTO $this->table
(`title`, `banner_image`, `description`, `deadline`,`zip_code`, `project_owner_id`, `category_id`, `created_at`)
                        VALUES 
 (:title, :banner_image, :description, :deadline, :zip_code, 1, 1, NOW())"
        );
        $statement->bindValue('title', $projects['title'], \PDO::PARAM_STR);
        $statement->bindValue('banner_image', $projects['banner_image'], \PDO::PARAM_STR);
        $statement->bindValue('description', $projects['description'], \PDO::PARAM_STR);
        $statement->bindValue('deadline', $projects['deadline']);
        $statement->bindValue('zip_code', $projects['zip_code'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }


    // REQUEST TO UPDATE PROJECT INFOS
    /**
     * @param array $project
     * @return bool
     */
    public function update(array $project)
    {

        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET 
        `title` = :title, 
        `banner_image`= :banner_image,
        `description` = :description,
        `zip_code` = :zip_code,
        `plan`= :plan,
        `team_description` = :team_description, 
        `deadline`= :deadline
         WHERE id=:id ");
        $statement->bindValue('id', $project['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $project['title'], \PDO::PARAM_STR);
        $statement->bindValue('banner_image', $project['banner_image'], \PDO::PARAM_STR);
        $statement->bindValue('description', $project['description'], \PDO::PARAM_STR);
        $statement->bindValue('zip_code', $project['zip_code'], \PDO::PARAM_STR);
        $statement->bindValue('plan', $project['plan'], \PDO::PARAM_STR);
        $statement->bindValue('team_description', $project['team_description'], \PDO::PARAM_STR);
        $statement->bindValue('deadline', $project['deadline']);


        return $statement->execute();
    }
    //requete delete (skills)
    //insert
}
