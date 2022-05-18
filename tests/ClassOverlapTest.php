<?php
namespace NPBreland\PHPUni\RedBeanUni\Test;

use PHPUnit\Framework\TestCase;

abstract class ClassOverlapTest extends TestCase
{
    protected $class_data = [
        [
            'start_time' => '12:00',
            'end_time' => '13:00',
            'day_nums' => [ 1, 2 ] // Sunday, Monday
        ],
        [
            'start_time' => '11:00',
            'end_time' => '12:30',
            'day_nums' => [ 1 ]
        ],
        [
            'start_time' => '11:00',
            'end_time' => '12:00',
            'day_nums' => [ 2 ]
        ],
        [
            'start_time' => '13:30',
            'end_time' => '14:30',
            'day_nums' => [ 1, 2 ]
        ],
        [
            'start_time' => '10:00',
            'end_time' => '11:30',
            'day_nums' => [ 1 ]
        ],
    ];

    public function __construct()
    {
        parent::__construct();

        // First class, against which we will test others
        $this->c1 = $this->buildClass($this->class_data[0]);
    }

    protected function buildClass($class_data): Model_Class
    {
        $class = R::dispense('class');

        foreach ($class_data['day_nums'] as $day_num) {
            $day = R::dispense('day');
            $day->day_num = $day_num;
            $class->sharedDayList[] = $day;
        }

        $class->start_time = $class_data['start_time'];
        $class->end_time = $class_data['end_time'];
        return $class->box();
    }
}
