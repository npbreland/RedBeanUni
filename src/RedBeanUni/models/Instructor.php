<?php
namespace RedBeanUni\Model;

use RedBeanUni\Exception\UnmetDependencyException;

use RedBeanPHP\R as R;

class Instructor extends AbstractPerson
{
    use OfferingTrait;

    public function update(): void
    {
    }

    public function getOfferings(): array
    {
        $sql = <<<SQL

SELECT o.*, c.name as course_name
  FROM offering o
       JOIN course c
       ON o.course_id = c.id
 WHERE o.instructor_id = ?

SQL;
        $rows = R::getAll($sql, [ $this->id ]);
        $offerings = R::convertToBeans( 'offerings', $rows );
        return $offerings;
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
                throw new UnmetDependencyException($err_msg);
            }
        }
        $this->bean->ownOfferingList[] = $o2->unbox();
    }

    public function getCurrentTermOfferings(): array
    {
        return $this
            ->bean
            ->withCondition('term_id = ?', [1])
            ->ownOfferingList;
    }

    public function getTodaysOfferings(): array
    {
        $sql = <<<SQL
         LEFT JOIN day_offering 
         ON offering.id = day_offering.offering_id

         LEFT JOIN day 
         ON day.id = day_offering.day_id

   WHERE day.day_num = ?
     AND offering.instructor_id = ?
ORDER BY offering.start_time
SQL;
        echo \RedBeanUni\getCurrentTerm()->unbox()->id;
        return \R::find('offering', $sql, [
            \RedBeanUni\getCurrentDayNum(),
            $this->bean->id,
            \RedBeanUni\getCurrentTerm()->unbox()->id
        ]);
    }


}
