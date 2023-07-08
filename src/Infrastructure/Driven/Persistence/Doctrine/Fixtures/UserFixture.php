<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Persistence\Doctrine\Fixtures;

use App\Application\Service\Clock\ClockGenerator;
use App\Domain\Authentication\User;
use App\Domain\Authentication\UserId;
use App\Domain\Authentication\VO\Email;
use App\Domain\Authentication\VO\Password;
use App\Infrastructure\Driven\Authentication\SecurityUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

final class UserFixture extends Fixture
{
    public const IDS = [
        '123a21ae-0527-4f73-93da-e5f56268bb18',
    ];

    public const EMAILS = [
        'ash.ketchum@pokemon.com',
    ];

    public const PASSWORDS = [
        'pika123',
    ];

    public function __construct(
        private readonly ClockGenerator $clockGenerator,
        private readonly PasswordHasherFactoryInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        foreach (self::IDS as $i => $rawId) {
            $rawEmail = self::EMAILS[$i] ?? $faker->email;
            $rawPassword = self::PASSWORDS[$i] ?? $faker->password;
            $hashedRawPassword = $this->passwordHasher->getPasswordHasher(SecurityUser::class)->hash($rawPassword);

            $user = new User(
                UserId::fromString($rawId),
                new Email($rawEmail),
                new Password($hashedRawPassword),
                $this->clockGenerator->fromCurrentTime(),
            );

            $manager->persist($user);
            $this->setReference(User::class . $i, $user);
        }

        $manager->flush();
    }
}
