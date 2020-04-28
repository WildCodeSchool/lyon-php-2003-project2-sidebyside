<?php


namespace App\Model;

class CategoryManager extends AbstractManager
{
    const TABLE = 'category';

    /**
     *  Initializes this class.
     */

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getCategory($id)
    {
        $statement = $this->pdo->prepare("SELECT c.name , c.id 
        FROM $this->table  AS c
        JOIN projects AS p ON c.id = p.category_id
        WHERE c.id=:category_id");
        $statement->bindValue('category_id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}
