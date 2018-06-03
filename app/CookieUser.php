<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class CookieUser
{
    const COOKIE_KEY = 'ms_user';

    public $uuid;

    function __construct()
    {
        $this->uuid = cookie()->forget(self::COOKIE_KEY)->getValue();

        if(!$this->uuid)
        {
            try {

                // Generate a version 4 (random) UUID object
                $uuid = Uuid::uuid4()->toString();

            } catch (UnsatisfiedDependencyException $e) {

                // Some dependency was not met. Either the method cannot be called on a
                // 32-bit system, or it can, but it relies on Moontoast\Math to be present.
                echo 'Caught exception: ' . $e->getMessage() . "\n";
                $uuid = '';

            }

            $this->uuid = $uuid;
        }
    }
}