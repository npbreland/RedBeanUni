<?php

use PHPUnit\Framework\TestCase;

final class ClassTest extends TestCase
{
    public function testOverlaps(): void
    {
    }

    public function testValidStartTime(): void
    {
        $c1 = R::dispense('class');

        $c1->start_time = '12:00';
        $c1->end_time = '13:00';
        $this->assertFalse($c1->startTimeAfterEndTime());

        $c1->start_time = '13:00';
        $c1->end_time = '12:00';
        $this->assertTrue($c1->startTimeAfterEndTime());
    }

}
