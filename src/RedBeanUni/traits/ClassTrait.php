<?php
namespace NPBreland\PHPUni\RedBeanUni;

trait ClassTrait
{
    public function classesOverlap(Model_Class $c1, Model_Class $c2): bool
    {
        // Bypass this check if these are new (unsaved) beans
        if (!($c1->id === 0 && $c2->id === 0)) {
            // Don't count it as overlapping if these are the same bean
            if ($c1->bean->equals($c2->unbox())) {
                return false;
            }
        }

        // Do they have at least one day in common?
        $c1_day_nums = array_column($c1->sharedDayList, 'day_num');
        $c2_day_nums = array_column($c2->sharedDayList, 'day_num');

        $one_day_in_common = false;
        foreach ($c2_day_nums as $c2dn) {
            if (in_array($c2dn, $c1_day_nums)) {
                $one_day_in_common = true;
                break;
            }
        }

        if ($one_day_in_common === false) {
            return false;
        }

        // C1 start time during C2
        if ($c1->start_time >= $c2->start_time 
            && $c1->start_time <= $c2->end_time) {
            return true;
        }

        // C1 end time during C2
        if ($c1->end_time >= $c2->start_time
            && $c1->end_time <= $c2->end_time) {
            return true;
        }

        return false;
    }


}
