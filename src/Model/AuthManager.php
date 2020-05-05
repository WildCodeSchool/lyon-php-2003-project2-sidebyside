<?php


namespace App\Model;

class AuthManager extends AbstractManager
{
    const TABLE = 'users';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function signIn(string $email)
    {
        $user = $this->pdo->prepare(
            "SELECT * FROM users 
                        WHERE email=:email"
        );

        $user->bindValue('email', $email, \PDO::PARAM_STR);
        $user->execute();
        return $user->fetch();
    }
}