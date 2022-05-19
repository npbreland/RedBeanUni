<?php
namespace RedBeanUni\Model;

trait OfferingTrait
{
    public function offeringsOverlap(Offering $o1, Offering $o2): bool
    {
        // Bypass this check if these are new (unsaved) beans
        if (!($o1->id === 0 && $o2->id === 0)) {
            // Don't count it as overlapping if these are the same bean
            if ($o1->bean->equals($o2->unbox())) {
                return false;
            }
        }

        // Do they have at least one day in common?
        $o1_day_nums = array_column($o1->sharedDayList, 'day_num');
        $o2_day_nums = array_column($o2->sharedDayList, 'day_num');

        $one_day_in_common = false;
        foreach ($o2_day_nums as $o2dn) {
            if (in_array($o2dn, $o1_day_nums)) {
                $one_day_in_common = true;
                break;
            }
        }

        if ($one_day_in_common === false) {
            return false;
        }

        // O1 start time during O2
        if ($o1->start_time >= $o2->start_time 
            && $o1->start_time <= $o2->end_time) {
            return true;
        }

        // O1 end time during O2
        if ($o1->end_time >= $o2->start_time
            && $o1->end_time <= $o2->end_time) {
            return true;
        }

        return false;
    }


}
