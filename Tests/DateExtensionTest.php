<?php

/*
 * This file is part of Twig.
 *
 * (c) 2014-2019 Fabien Potencier
 * (c) 2022-2022 Stéphane Férey
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Twig\Extra\Date\Tests;

use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Extra\Date\DateExtension;
use Twig\Loader\LoaderInterface;

/**
 * @author Robin van der Vleuten <robinvdvleuten@gmail.com>
 */
class DateExtensionTest extends TestCase
{
    private $env;

    protected function setUp(): void
    {
        $this->env = new Environment($this->getMockBuilder(LoaderInterface::class)->getMock());
    }

    /**
     * @dataProvider getDiffTestData()
     */
    public function testDiffWithStringsFromGivenNow($expected, $translated, $date, $now)
    {
        $extension = new DateExtension();
        $this->assertEquals($expected, $extension->diff($this->env, $date, $now));
    }

    public function testDiffWithStringsFromNow()
    {
        $extension = new DateExtension();
        $this->assertMatchesRegularExpression('/^[0-9]+ (second|minute|hour|day|month|year)s* ago$/', $extension->diff($this->env, '24-07-2014'));
    }

    /**
     * @dataProvider getDiffTestData()
     * @throws Exception
     */
    public function testDiffWithDateTimeFromGivenNow($expected, $translated, $date, $now)
    {
        $extension = new DateExtension();
        $this->assertEquals($expected, $extension->diff($this->env, new DateTime($date), new DateTime($now)));
    }

    public function testDiffWithDateTimeFromNow()
    {
        $extension = new DateExtension();
        $this->assertMatchesRegularExpression('/^[0-9]+ (second|minute|hour|day|month|year)s* ago$/', $extension->diff($this->env, new DateTime('24-07-2014')));
    }

    /**
     * @dataProvider getDiffTestData()
     */
    public function testDiffCanReturnTranslatableString($expected, $translated, $date, $now)
    {
        $translator = $this->getMockBuilder(TranslatorInterface::class)->getMock();
        $translator
            ->expects($this->once())
            ->method('trans')
            ->with($translated);

        $extension = new DateExtension($translator);
        $extension->diff($this->env, $date, $now);
    }

    public function getDiffTestData(): array
    {
        return array_merge($this->getDiffAgoTestData(), $this->getDiffInTestData());
    }

    public function getDiffAgoTestData(): array
    {
        return [
            ['1 second ago', 'diff.ago.second', '24-07-2014 17:28:01', '24-07-2014 17:28:02'],
            ['5 seconds ago', 'diff.ago.second', '24-07-2014 17:28:01', '24-07-2014 17:28:06'],
            ['1 minute ago', 'diff.ago.minute', '24-07-2014 17:28:01', '24-07-2014 17:29:01'],
            ['5 minutes ago', 'diff.ago.minute', '24-07-2014 17:28:01', '24-07-2014 17:33:03'],
            ['1 hour ago', 'diff.ago.hour', '24-07-2014 17:28:01', '24-07-2014 18:29:01'],
            ['9 hours ago', 'diff.ago.hour', '24-07-2014 17:28:01', '25-07-2014 02:33:03'],
            ['1 day ago', 'diff.ago.day', '23-07-2014', '24-07-2014'],
            ['5 days ago', 'diff.ago.day', '19-07-2014', '24-07-2014'],
            ['1 month ago', 'diff.ago.month', '23-07-2014', '24-08-2014'],
            ['6 months ago', 'diff.ago.month', '19-07-2014', '24-01-2015'],
            ['1 year ago', 'diff.ago.year', '19-07-2014', '20-08-2015'],
            ['3 years ago', 'diff.ago.year', '19-07-2014', '20-08-2017'],
        ];
    }

    public function getDiffInTestData(): array
    {
        return [
            ['in 1 second', 'diff.in.second', '24-07-2014 17:28:02', '24-07-2014 17:28:01'],
            ['in 5 seconds', 'diff.in.second', '24-07-2014 17:28:06', '24-07-2014 17:28:01'],
            ['in 1 minute', 'diff.in.minute', '24-07-2014 17:29:01', '24-07-2014 17:28:01'],
            ['in 5 minutes', 'diff.in.minute', '24-07-2014 17:33:03', '24-07-2014 17:28:01'],
            ['in 1 hour', 'diff.in.hour', '24-07-2014 18:29:01', '24-07-2014 17:28:01'],
            ['in 9 hours', 'diff.in.hour', '25-07-2014 02:33:03', '24-07-2014 17:28:01'],
            ['in 1 day', 'diff.in.day', '24-07-2014', '23-07-2014'],
            ['in 5 days', 'diff.in.day', '24-07-2014', '19-07-2014'],
            ['in 1 month', 'diff.in.month', '24-08-2014', '23-07-2014'],
            ['in 6 months', 'diff.in.month', '24-01-2015', '19-07-2014'],
            ['in 1 year', 'diff.in.year', '20-08-2015', '19-07-2014'],
            ['in 3 years', 'diff.in.year', '20-08-2017', '19-07-2014'],
        ];
    }
}
