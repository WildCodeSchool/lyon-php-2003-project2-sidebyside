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


    /**
     * Get one row from database by ID.
     *
     * @param  int $id
     *
     * @return array
     */
    public function selectOneById($id)
    {
        return parent::selectOneById($id);
    }

    /**
     * @param array $projects
     * @return bool
     */
    public function update(array $projects):bool
    {

        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title, 
        `banner_image`= :banner_image,`description` = :description,`zip_code` = :zip_code,
         `plan`= :plan, `team_description` = :team_description, `deadline`= :deadline,  WHERE id=:id ");
        $statement->bindValue('id', $projects['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $projects['title'], \PDO::PARAM_STR);
        $statement->bindValue('banner_image', $projects['banner_image'], \PDO::PARAM_STR);
        $statement->bindValue('description', $projects['description'], \PDO::PARAM_STR);
        $statement->bindValue('zip_code', $projects['zip_code'], \PDO::PARAM_STR);
        $statement->bindValue('plan', $projects['plan'], \PDO::PARAM_STR);
        $statement->bindValue('team_description', $projects['team_description'], \PDO::PARAM_STR);
        $statement->bindValue('deadline', $projects['deadline'], \PDO::PARAM_STR);


        return $statement->execute();
    }
}
