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

require __DIR__ . '/bootstrap.php';
