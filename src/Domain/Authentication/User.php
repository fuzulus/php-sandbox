<?php

declare(strict_types=1);

namespace App\Domain\Authentication;

use App\Domain\Authentication\ViewModel\MeViewModel;
use App\Domain\Authentication\VO\Email;
use App\Domain\Authentication\VO\Password;
use App\Domain\Common\CreateTimestampTrait;
use App\Domain\Common\UpdateTimestampTrait;
use App\Domain\Common\VO\Clock;
use App\Domain\Common\VO\NullableClock;

class User
{
    use CreateTimestampTrait;

    use UpdateTimestampTrait;

    public function __construct(
        private readonly UserId $id,
        private Email $email,
        private Password $password,
        Clock $createdAt,
    ) {
        $this->createdAt = $createdAt;
        $this->updatedAt = NullableClock::createEmpty();
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function password(): Password
    {
        return $this->password;
    }

    public function meViewModel(): MeViewModel
    {
        return new MeViewModel(
            (string) $this->id,
            (string) $this->email,
        );
    }
}
