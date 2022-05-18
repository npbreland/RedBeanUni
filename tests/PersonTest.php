<?php

use PHPUnit\Framework\TestCase;

final class PersonTest extends TestCase
{

    public function testGetListName(): void
    {
        $student = R::dispense('student');
        $student->first_name = 'Dolly';
        $student->last_name = 'Parton';
        $this->assertEquals($student->getListName(), 'Parton, Dolly');
    }

    public function testIsBirthday(): void
    {
        $student = R::dispense('student');
        $student->date_of_birth = new DateTime();

        $this->assertTrue($student->isBirthday());

        $fifty_years_ago = (new DateTime())->modify('-50 years');
        $student->date_of_birth = $fifty_years_ago;

        $this->assertTrue($student->isBirthday());

        $tomorrow = (new DateTime())->modify('+1 day');
        $student->date_of_birth = $tomorrow;

        $this->assertFalse($student->isBirthday());
    }

}
