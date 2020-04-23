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

    // REQUEST GET ALL USER INFO IN users & user_has_skills
    public function getUserInfo($id)
    {
        return $this->pdo->query(
            "SELECT 
                            u.id, 
                            u.last_name, 
                            u.first_name, 
                            u.email, 
                            u.zip_code, 
                            u.description, 
                            uhs.user_id, 
                            uhs.skill_id 
                        FROM users u 
                        LEFT JOIN user_has_skills uhs ON u.id = uhs.user_id
                        LEFT JOIN skills s ON s.id= uhs.skill_id
                        WHERE u.id=$id"
        )->fetchAll();
    }


    // REQUEST UPDATE THE USER INFO IN users
    public function setUserInfo(array $profil, int $id) : void
    {
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
        $update->bindValue('first_name', $profil['first_name'], \PDO::PARAM_STR);
        $update->bindValue('last_name', $profil['last_name'], \PDO::PARAM_STR);
        $update->bindValue('email', $profil['email'], \PDO::PARAM_STR);
        $update->bindValue('zip_code', $profil['zip_code'], \PDO::PARAM_STR);
        $update->bindValue('description', $profil['description'], \PDO::PARAM_STR);

        $update->execute();
    }


    // REQUEST INSERT THE USER PROFIL IMAGE IN users
    public function updateUserImg(array $path, int $id)
    {
        if (isset($path['banner_image']) && isset($path['profil_picture'])) {
            $update = $this->pdo->prepare("UPDATE users u 
                                                        SET 
                                                            u.profil_picture = :profil_picture, 
                                                            u.banner_image = :banner_image 
                                                        WHERE u.id = :id");
            $update->bindParam('profil_picture', $path["profil_picture"], \PDO::PARAM_STR);
            $update->bindParam('banner_image', $path["banner_image"], \PDO::PARAM_STR);
            $update->bindValue('id', $id, \PDO::PARAM_INT);
            $update->execute();
        } elseif (isset($path['banner_image']) && !isset($path['profil_picture'])) {
            $update = $this->pdo->prepare("UPDATE users u 
                                                        SET u.banner_image = :banner_image 
                                                        WHERE u.id = :id");
            $update->bindParam('banner_image', $path["banner_image"], \PDO::PARAM_STR);
            $update->bindValue('id', $id, \PDO::PARAM_INT);
            $update->execute();
        } elseif (!isset($path['banner_image']) && isset($path['profil_picture'])) {
            $update = $this->pdo->prepare("UPDATE users u 
                                                        SET u.profil_picture = :profil_picture 
                                                        WHERE u.id = :id");
            $update->bindParam('profil_picture', $path["profil_picture"], \PDO::PARAM_STR);
            $update->bindValue('id', $id, \PDO::PARAM_INT);
            $update->execute();
        }
    }


    // REQUEST DELETE THE USER SKILLS IN user_has_skills
    public function deleteSkillUser(int $id)
    {
        $delete = $this->pdo->prepare(
            "DELETE FROM user_has_skills uhs 
                        WHERE uhs.user_id=:id"
        );
        $delete->bindValue('id', $id, \PDO::PARAM_INT);
        $delete->execute();
    }

    // REQUEST INSERT THE USER SKILLS IN user_has_skills AFTER DELETE PRECEDE SKILLS IN user_has_skills
    public function insertSkillUser(array $profil, int $id)
    {
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

    public function selectByWord(string $keyword) : array
    {
        $query = "SELECT last_name, first_name, id, email, zip_code FROM users 
WHERE first_name LIKE :keyword OR last_name LIKE :keyword OR id LIKE :keyword OR zip_code LIKE :keyword";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':keyword', "%$keyword%");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
