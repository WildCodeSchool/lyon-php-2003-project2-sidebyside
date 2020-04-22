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

    public function getUserInfo($id)
    {
        return $this->pdo->query(
            "SELECT * FROM users u 
                        JOIN user_has_skills uhs ON u.id = uhs.user_id
                        JOIN skills s ON s.id= uhs.skill_id
                        WHERE u.id=$id"
        )->fetchAll();
    }


    public function setUserInfo(array $profil, int $id) : void
    {
        // REQUEST UPDATE THE USER INFO IN users
        $update = $this->pdo->prepare(
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
        $update->bindValue('id', $id, \PDO::PARAM_INT);
        $update->bindValue('first_name', $profil['firstName'], \PDO::PARAM_STR);
        $update->bindValue('last_name', $profil['lastName'], \PDO::PARAM_STR);
        $update->bindValue('email', $profil['email'], \PDO::PARAM_STR);
        $update->bindValue('zip_code', $profil['zipCode'], \PDO::PARAM_STR);
        $update->bindValue('description', $profil['description'], \PDO::PARAM_STR);

        //  TODO insert update value for picture image and banner_image after create upload function
        /*
        $update->bindValue('profil_picture', $profil['profil_picture'], \PDO::PARAM_STR);
        $update->bindValue('banner_image', $profil['banner_image'], \PDO::PARAM_STR);
        */
        $update->execute();

        // REQUEST DELETE THE USER SKILLS IN user_has_skills
        $delete = $this->pdo->prepare(
            "DELETE FROM user_has_skills uhs 
                        WHERE uhs.user_id=:id"
        );
        $delete->bindValue('id', $id, \PDO::PARAM_INT);
        $delete->execute();

        // REQUEST INSERT THE USER SKILLS IN user_has_skills AFTER DELETE PRECEDE SKILLS IN user_has_skills
        if (isset($profil['skills'])) {
            foreach ($profil['skills'] as $skillId) {
                $insert = $this->pdo->prepare(
                    "INSERT INTO user_has_skills (user_id, skill_id)
                        VALUES (:id, :skillId)"
                );
                $insert->bindValue('id', $id, \PDO::PARAM_INT);
                $insert->bindValue('skillId', $skillId, \PDO::PARAM_INT);
                $insert->execute();
            }
        }
    }
}
