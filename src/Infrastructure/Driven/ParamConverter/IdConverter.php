<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\ParamConverter;

use App\Domain\Common\Exception\InvalidIdentityException;
use App\Domain\Common\Id;
use App\Infrastructure\Driven\ParamConverter\Exception\ParamConverterInvalidUuidFormatException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class IdConverter implements ParamConverterInterface
{
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        if (false === is_subclass_of($this->idClass(), Id::class)) {
            throw new \InvalidArgumentException('IdClass class name must be instance of Id');
        }
        $name = $configuration->getName();

        try {
            $id = $request->attributes->get($name);

            if (false === \is_string($id)) {
                throw new \InvalidArgumentException(sprintf('Expected string, got %s.', get_debug_type($id)));
            }

            $value = $this->idClass()::fromString($id);
        } catch (InvalidIdentityException $ex) {
            throw new ParamConverterInvalidUuidFormatException($ex->getMessage(), (int) $ex->getCode(), $ex);
        }

        $request->attributes->set($name, $value);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $this->idClass() === $configuration->getClass();
    }

    /** @return class-string */
    abstract protected function idClass(): string;
}
