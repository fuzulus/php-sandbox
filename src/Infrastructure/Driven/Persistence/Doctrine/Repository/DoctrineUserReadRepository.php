<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Persistence\Doctrine\Repository;

use App\Application\Repository\Authentication\UserReadRepository;
use App\Domain\Authentication\Exception\UserNotFoundException;
use App\Domain\Authentication\User;
use App\Domain\Authentication\VO\Email;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<User> */
final class DoctrineUserReadRepository extends ServiceEntityRepository implements UserReadRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByEmail(Email $email): User
    {
        $user = $this->findOneBy(['email.email' => (string) $email]);

        if (null === $user) {
            throw UserNotFoundException::byEmail($email);
        }

        return $user;
    }
}
