<?php

namespace SallaProducts\Database\Concerns;

use SallaProducts\Database\Managers\Contracts\DatabaseManager;

trait ConnectsTo
{
    public static function connect(DatabaseManager $manager)
    {
        return $manager->connect();
    }
}