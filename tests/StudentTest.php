<?php

use PHPUnit\Framework\TestCase;
use \RedBeanPHP\R as R;

final class StudentTest extends TestCase
{
    public function testAddValidGrade(): void
    {
        $student = R::dispense('student');
        $grade = R::dispense('grade');
        $class = R::dispense('class');

        $student->sharedClassList[] = $class;

        $grade->score = 95;
        $grade->class = $class;

        $student->addGrade($grade->box());

        $this->assertTrue(true);
    }

    public function testAddInvalidGrade1(): void
    {
        $student = R::dispense('student');
        $class = R::dispense('class');
        $student->sharedClassList[] = $class;

        $grade = R::dispense('grade');
        $grade->score = 101;
        $grade->class = $class;

        $this->expectException(Exception::class);
        $student->addGrade($grade->box());
    }

    public function testAddInvalidGrade2(): void
    {
        $student = R::dispense('student');
        $class = R::dispense('class');
        $student->sharedClassList[] = $class;

        $grade = R::dispense('grade');
        $grade->score = -1;
        $grade->class = $class;

        $this->expectException(Exception::class);
        $student->addGrade($grade->box());
    }

    public function testAddInvalidGrade3(): void
    {
        $student = R::dispense('student');
        $class = R::dispense('class');

        $student->sharedClassList[] = $class;

        $grade = R::dispense('grade');
        $grade->score = 'A';
        $grade->class = $class;

        $this->expectException(Exception::class);
        $student->addGrade($grade->box());
    }

    public function testAddInvalidGrade4(): void
    {
        $student = R::dispense('student');
        $class = R::dispense('class');

        $grade = R::dispense('grade');
        $grade->score = 95;
        $grade->class = $class;

        $this->expectException(Exception::class);
        $student->addGrade($grade->box());
    }

    public function testGetGradePointAverage(): void
    {
        $student = R::dispense('student');
        $c1 = R::dispense('class');
        $c2 = R::dispense('class');
        $c3 = R::dispense('class');

        $student->sharedClassList[] = $c1;
        $student->sharedClassList[] = $c2;
        $student->sharedClassList[] = $c3;

        $g1 = R::dispense('grade');
        $g1->score = 95;
        $g1->class = $c1;

        $g2 = R::dispense('grade');
        $g2->score = 76;
        $g2->class = $c2;

        $g3 = R::dispense('grade');
        $g3->score = 49;
        $g3->class = $c3;

        $student->addGrade($g1->box());
        $student->addGrade($g2->box());
        $student->addGrade($g3->box());

        $this->assertEquals(2.93, $student->getGradePointAverage());
    }

    public function testWithdrawFromClass(): void
    {
        $student = R::dispense('student');
        $c1 = R::dispense('class');
        $student->sharedClassList[] = $c1;

        $student->withdrawFromClass($c1->box());
        $this->assertEquals($student->sharedClassList, []);
    }

}
