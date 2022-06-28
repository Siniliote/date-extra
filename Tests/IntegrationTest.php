<?php

/*
 * This file is part of Twig.
 *
 * (c) 2022-2022 Stéphane Férey
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Twig\Extra\Date\Tests;

use Twig\Extra\Date\DateExtension;
use Twig\Test\IntegrationTestCase;

class IntegrationTest extends IntegrationTestCase
{
    public function getExtensions(): array
    {
        return [
            new DateExtension(),
        ];
    }

    public function getFixturesDir(): string
    {
        return __DIR__.'/Fixtures/';
    }
}