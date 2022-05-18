<?php

final class EnrollStudentTest extends ClassOverlapTest
{
    public function __construct()
    {
        parent::__construct();

        $this->student = R::dispense('student');
        $this->student->enrollInClass($this->c1);
    }

    public function testCannotEnroll1(): void
    {
        $c2 = $this->buildClass($this->class_data[1]);
        $this->expectException(Exception::class);
        $this->student->enrollInClass($c2);
    }

    public function testCannotEnroll2(): void
    {
        $c2 = $this->buildClass($this->class_data[2]);
        $this->expectException(Exception::class);
        $this->student->enrollInClass($c2);
    }

    public function testCanEnroll1(): void
    {
        $c2 = $this->buildClass($this->class_data[3]);
        $this->student->enrollInClass($c2);
        // No exception thrown, so all is well
        $this->assertTrue(true);
    }

    public function testCanEnroll2(): void
    {
        $c2 = $this->buildClass($this->class_data[4]);
        $this->student->enrollInClass($c2);
        $this->assertTrue(true);
    }
}
