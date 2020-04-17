<?php


namespace App\Model;

class ProjectManager extends AbstractManager
{
    const TABLE = 'projects';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
