<?php
namespace NPBreland\PHPUni\RedBeanUni\Test;

//Test autoloader
require_once dirname(__FILE__) . '/autoload.php';

final class AssignInstructorTest extends ClassOverlapTest
{
    public function __construct()
    {
        parent::__construct();

        $this->instructor = \R::dispense('instructor');
        $this->instructor->assignCourse($this->c1);
    }

    public function testCannotAssign1(): void
    {
        $c2 = $this->buildClass($this->class_data[1]);
        $this->expectException(Exception::class);
        $this->instructor->assignCourse($c2);
    }

    public function testCannotAssign2(): void
    {
        $c2 = $this->buildClass($this->class_data[2]);
        $this->expectException(Exception::class);
        $this->instructor->assignCourse($c2);
    }

    public function testCanAssign1(): void
    {
        $c2 = $this->buildClass($this->class_data[3]);
        $this->instructor->assignCourse($c2);
        // No exception thrown, so all is well
        $this->assertTrue(true);
    }

    public function testCanAssign2(): void
    {
        $c2 = $this->buildClass($this->class_data[4]);
        $this->instructor->assignCourse($c2);
        $this->assertTrue(true);
    }

}
