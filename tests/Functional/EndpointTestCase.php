<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use GuzzleHttp\Psr7\Request;

/**
 * @coversNothing
 *
 * @small
 */
interface EndpointTestCase
{
    public function validateEndpoint(Request $request, string $path, int $expectedStatusCode): void;
}
