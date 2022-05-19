<?php
namespace RedBeanUni\Model;

class Offering extends \RedBeanPHP\SimpleModel
{
    public function update(): void
    {
        if ($this->startTimeAfterEndTime()) {
            throw new \Exception('Start time is after end time.');
        }
    }

    public function startTimeAfterEndTime(): bool
    {
        if (!isset($this->start_time)) {
            throw new \Exception('Start time not set.');
        }
        if (!isset($this->end_time)) {
            throw new \Exception('End time not set.');
        }
        return $this->start_time > $this->end_time;
    }

    public function listDayFormat(): string
    {
        $day_nums = array_column($this->sharedDayList, 'day_num');
        return array_reduce($day_nums, function($str, $day_num) {
          // Get the first letter of the day
          return $str .= DAY_MAP[$day_num]['short'];
        }, '');
    }
}
