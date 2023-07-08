<?php

declare(strict_types=1);

namespace App\Infrastructure\Driving\Common\v1\Model\User;

use App\Domain\Authentication\ViewModel\MeViewModel;
use Undabot\SymfonyJsonApi\Model\ApiModel;
use Undabot\SymfonyJsonApi\Model\Resource\Annotation\Attribute;
use Undabot\SymfonyJsonApi\Service\Resource\Validation\Constraint\ResourceType;

/**
 * @ResourceType(type="users")
 */
final class MeReadModel implements ApiModel
{
    public function __construct(
        public readonly string $id,
        /** @Attribute */
        public readonly string $email,
    ) {
    }

    public static function fromViewModel(MeViewModel $viewModel): self
    {
        return new self(
            $viewModel->id,
            $viewModel->email,
        );
    }
}
