<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Driving\Common\v1\Endpoint\User;

use App\Tests\Functional\KernelEndpointTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @coversDefaultClass \App\Infrastructure\Driving\Common\v1\Endpoint\User\MeController
 *
 * @small
 */
final class MeControllerTest extends KernelEndpointTestCase
{
    public function testEndpointWillReturn200(): void
    {
        $path = '/api/v1/common/me';

        $request = $this->createRequest(Request::METHOD_GET, $path);

        $this->validateEndpoint($request, $path, Response::HTTP_OK);
    }
}
