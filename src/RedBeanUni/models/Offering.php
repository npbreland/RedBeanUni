<?php
namespace RedBeanUni\Model;

use RedBeanUni\Exception\InvalidParameterException;
use RedBeanUni\Exception\MissingRequiredParameterException;

class Offering extends \RedBeanPHP\SimpleModel
{
    public function update(): void
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (!isset($this->course)) {
            echo $this->course;
            $ex_msg = 'Course must be set';
            throw new MissingRequiredParameterException($ex_msg);
        }

        if (!isset($this->term)) {
            $ex_msg = 'Term must be specified';
            throw new MissingRequiredParameterException($ex_msg);
        }

        /* We can save without start and end time, but if either is set, we must
        check that they are valid */
        if (isset($this->start_time) || isset($this->end_time)) {

            if (!isset($this->start_time) || !isset($this->end_time)) {
                $ex_msg = <<<MSG
If supplying offering times, you must supply both start AND end times.
MSG;
                throw new MissingRequiredParameterException($ex_msg);
            }

            if ($this->start_time > $this->end_time) {
                $ex_msg = 'Start time is after end time.';
                throw new InvalidParameterException($ex_msg);
            }

            $start_fmt = (new \DateTime($this->start_time))->format('H:i');
            $end_fmt = (new \DateTime($this->end_time))->format('H:i');

            if (
                $start_fmt !== $this->start_time
                || $end_fmt !== $this->end_time
            ) {
                $ex_msg = 'Start and end times must match the format HH:MM.';
                throw new InvalidParameterException($ex_msg);
            }
        }
    }

    private function getDayNums(): array
    {
        return array_column($this->sharedDayList, 'day_num');
    }


    public function listDayFormat(): string
    {
        return array_reduce($this->getDayNums(), function($str, $day_num) {
          // Get the first letter of the day
          return $str .= DAY_MAP[$day_num]['short'];
        }, '');
    }

    public function createSessions(): void
    {
        $start = new \DateTime($this->term->start_date); 
        $end = new \DateTime($this->term->end_date);
        $end = $end->modify('+1 day');

        $day_nums = $this->getDayNums();

        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($start, $interval, $end);
        foreach ($period as $date) {
            $day_num = \RedBeanUni\getDayOfWeekInt($date);
            if (in_array($day_num, $day_nums)) {
                $session = \R::dispense('session');
                $session->date = $date;
                $session->offering = $this->bean;
                $session->canceled = false;
                \R::store($session);
            }
        }
    }
}
