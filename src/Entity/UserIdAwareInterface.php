<?php

namespace App\Entity;

interface UserIdAwareInterface
{
    public function setUserId(int $id);
}