<?php
namespace RedBeanUni\Model;

class Instructor extends Person
{
    use OfferingTrait;

    public function update(): void
    {
    }

    public function assignOffering(Offering $o2): void
    {
        $offering_list = array_values($this->ownOfferingList);
        for($i = 0; $i < count($offering_list); $i++) {
            $o1 = $offering_list[$i]->box();
            if ($this->offeringsOverlap($o1, $o2)) {
                $err_msg = <<<MSG
Cannot enroll in class because it would overlap with another class 
the instructor is teaching.
MSG;
                throw new \Exception($err_msg);
            }
        }
        $this->bean->ownOfferingList[] = $o2->unbox();
    }
}
