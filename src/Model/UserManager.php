<?php

namespace App\Model;

class UserManager extends AbstractManager
{

    /**
     *
     */
    const TABLE = 'users';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getSkills()
    {
        return $this->pdo->query(
            "SELECT user_id, name FROM users 
                        JOIN user_has_skills ON users.id=user_id 
                        JOIN skills ON skill_id=skills.id 
                        ORDER BY user_id"
        )->fetchAll();
    }

    public function getUserInfo()
    {
        return $this->pdo->query(
            "SELECT * FROM users u 
                        JOIN user_has_skills uhs ON u.id = uhs.user_id
                        JOIN skills s ON s.id= uhs.skill_id"
        )->fetchAll();
    }


    public function setUserInfo(array $profil, int $id) : void
    {
        $statement = $this->pdo->prepare(
            "UPDATE users u
                        SET 
                            u.first_name = :first_name, 
                            u.last_name = :last_name, 
                            u.email = :email, 
                            u.zip_code = :zip_code,
                            u.description = :description 
                        WHERE 
                              u.id = :id"
        );

        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->bindValue('first_name', $profil['firstName'], \PDO::PARAM_STR);
        $statement->bindValue('last_name', $profil['lastName'], \PDO::PARAM_STR);
        $statement->bindValue('email', $profil['email'], \PDO::PARAM_STR);
        $statement->bindValue('zip_code', $profil['zipCode'], \PDO::PARAM_STR);
        $statement->bindValue('description', $profil['description'], \PDO::PARAM_STR);

        // TODO insert update value for picture image and banner_image after create upload function
//        $statement->bindValue('profil_picture', $profil['profil_picture'], \PDO::PARAM_STR);
//        $statement->bindValue('banner_image', $profil['banner_image'], \PDO::PARAM_STR);

        $statement->execute();
    }
}
