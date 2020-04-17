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
}
