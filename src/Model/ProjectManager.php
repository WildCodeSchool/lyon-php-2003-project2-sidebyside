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
     * @param string
     * @return array
     */
    public function selectByWord(string $keyword) : array
    {
        $query = "SELECT p.title, p.description, p.zip_code, p.banner_image, u.first_name FROM projects p
JOIN users u ON p.project_owner_id=u.id WHERE u.first_name LIKE :keyword OR p.title LIKE :keyword 
OR p.description LIKE :keyword OR p.zip_code LIKE :keyword OR u.first_name LIKE :keyword";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':keyword', "%$keyword%");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
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
