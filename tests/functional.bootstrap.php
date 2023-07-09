<?php

declare(strict_types=1);

passthru(sprintf(
    'APP_ENV=test php "%s/../bin/console" doctrine:database:drop --if-exists --force',
    __DIR__
));

passthru(sprintf(
    'APP_ENV=test php "%s/../bin/console" doctrine:database:create',
    __DIR__
));

passthru(sprintf(
    'APP_ENV=test php "%s/../bin/console" doctrine:migrations:migrate --no-interaction',
    __DIR__
));

passthru(sprintf(
    'APP_ENV=test php "%s/../bin/console" doctrine:fixtures:load --no-interaction',
    __DIR__
));

passthru('openssl genrsa -out config/jwt/private-test.pem 2048');

passthru('openssl rsa -in config/jwt/private-test.pem -pubout -out config/jwt/public-test.pem');

passthru('sh scripts/create_oauth2_test_client.sh');

require __DIR__ . '/bootstrap.php';
