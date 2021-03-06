<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework;

use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \PHPUnit\Framework\TestBuilder
 */
final class TestBuilderTest extends TestCase
{
    public function testCreateTestForConstructorlessTestClass(): void
    {
        $reflector = $this->getMockBuilder(\ReflectionClass::class)
                          ->setConstructorArgs([$this])
                          ->getMock();

        \assert($reflector instanceof MockObject);
        \assert($reflector instanceof \ReflectionClass);

        $reflector->expects($this->once())
                  ->method('getConstructor')
                  ->willReturn(null);

        $reflector->expects($this->once())
                  ->method('isInstantiable')
                  ->willReturn(true);

        $reflector->expects($this->once())
                  ->method('getName')
                  ->willReturn(__CLASS__);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('No valid test provided.');

        (new TestBuilder)->build($reflector, 'TestForConstructorlessTestClass');
    }
}
