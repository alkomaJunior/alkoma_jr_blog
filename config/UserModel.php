<?php

namespace app\config;

use app\config\Repository;

/**
 * Class UserModel
 * @package app\config
 */
abstract class UserModel extends Repository
{
    abstract public function getDisplayName(): string;
}