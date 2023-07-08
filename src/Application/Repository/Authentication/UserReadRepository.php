<?php

declare(strict_types=1);

namespace App\Application\Repository\Authentication;

use App\Domain\Authentication\Exception\UserNotFoundException;
use App\Domain\Authentication\User;
use App\Domain\Authentication\VO\Email;

interface UserReadRepository
{
    /** @throws UserNotFoundException */
    public function findByEmail(Email $email): User;
}
