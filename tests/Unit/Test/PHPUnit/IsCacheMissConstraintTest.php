<?php

/*
 * This file is part of the FOSHttpCache package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\HttpCache\Tests\Unit\Test\PHPUnit;

use FOS\HttpCache\Test\PHPUnit\IsCacheMissConstraint;
use PHPUnit\Framework\ExpectationFailedException;

// phpunit 5 has forward compatibility classes but missed this one
if (!class_exists('\PHPUnit\Framework\ExpectationFailedException')) {
    class_alias('\PHPUnit_Framework_ExpectationFailedException', '\PHPUnit\Framework\ExpectationFailedException');
}

class IsCacheMissConstraintTest extends AbstractCacheConstraintTest
{
    /**
     * @var IsCacheMissConstraint
     */
    private $constraint;

    public function setUp(): void
    {
        $this->constraint = new IsCacheMissConstraint('cache-header');
    }

    public function testMatches()
    {
        $response = $this->getResponseMock()
            ->shouldReceive('hasHeader')->with('cache-header')->andReturn(true)
            ->shouldReceive('getHeaderLine')->with('cache-header')->once()->andReturn('HIT')
            ->shouldReceive('getStatusCode')->andReturn(200)
            ->getMock();

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Failed asserting that response (with status code 200) is a cache miss');

        $this->constraint->evaluate($response);
    }
}
