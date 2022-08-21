<?php
namespace RedBeanUni\Model;

use RedBeanUni\Exception\UnmetDependencyException;
use RedBeanUni\Exception\NotFoundException;
use RedBeanUni\Exception\InvalidParameterException;

class Student extends AbstractPerson
{
    use OfferingTrait;

    public function update(): void
    {

    }

    private function validate(): void
    {

    }

    public function enrollInOffering(Offering $o2): void
    {
        if (!$this->hasPassedPrerequisites($o2->course->box())) {
            $err_msg = <<<MSG
Student has not passed all of the prerequisite courses.
MSG;
            throw new UnmetDependencyException($err_msg);
        }

        $offering_list = array_values($this->sharedOfferingList);
        for($i = 0; $i < count($offering_list); $i++) {
            $o1 = $offering_list[$i]->box();
            if ($this->offeringsOverlap($o1, $o2)) {
                $err_msg = <<<MSG
Cannot enroll in offering because it would overlap with another offering the 
student is taking.
MSG;
                throw new UnmetDependencyException($err_msg);
            }
        }
        $this->bean->sharedOfferingList[] = $o2->unbox();
    }

    private function hasPassedPrerequisites(Course $course): bool
    {
        foreach ($course->sharedPrerequisiteList as $prereq) {

            $pass_grades = array_filter(
                $this->ownGradeList, 
                function($grade) use ($prereq){
                    return $grade->course_id === $prereq->id
                        && $grade->score >= PASSING_GRADE;
                }
            );

            // No passing grades for this prereq course
            if ($pass_grades === []) {
                return false;
            }

        }

        // Had a passing grade for each prereq course
        return true;
    }

    public function withdrawFromOffering(Offering $offering): void
    {
        if ($this->isInOffering($offering) === false) {
            $ex_msg = 'Student must be enrolled in the offering.';
            throw new UnmetDependencyException($ex_msg);
        }

        unset($this->bean->sharedOfferingList[$offering->id]);
    }

    private function isInOffering(Offering $offering): bool
    {
        foreach ($this->sharedOfferingList as $student_offering) {
            if ($student_offering->equals($offering->unbox())) {
                return true;
            }
        }

        return false;
    }

    private function findGrade(Offering $offering): int
    {
        $offering_ids = array_column($this->ownGradeList, 'offering_id', 'id');
        $key = array_search($offering->id, $offering_ids);
        if ($key === false) {
            throw new \Exception('Grade not found');
        }
        return $key;
    }

    public function updateGrade(Grade $grade): void
    {
        if (!$this->isInOffering($grade->offering->box())) {
            $ex_msg = 'Student must be enrolled in the offering.';
            throw new UnmetDependencyException($ex_msg);
        }

        $key = $this->findGrade($grade->offering);
        if ($key === false) {
            $this->bean->ownGradeList[] = $grade->unbox();
        } else {
            $this->bean->ownGradeList[$key] = $grade->score_100;
        }
    }

    public function deleteGrade(Offering $offering): void
    {
        $key = $this->findGrade($offering);
        if ($key === false) {
            throw new NotFoundException('Grade not found.');
        }

        unset($this->bean->ownGradeList[$key]->score_100);
    }

    public function getGPA(): float
    {
        if (!$this->ownGradeList) {
            throw new \Exception('No grades to average');
        }

        $grades = $this->ownGradeList;

        $sum = array_reduce($grades, function($acc, $grade) {
            $acc += $grade->score_100;
            return $acc;
        }, 0);

        return round((($sum / count($grades)) / 100) * 4, 2);
    }

    public function getCurrentTermOfferings(): array
    {
        return $this
            ->bean
            ->withCondition('term_id = ?', [1])
            ->sharedOfferingList;
    }

    public function getTodaysOfferings(): array
    {
        $sql = <<<SQL
         LEFT JOIN offering_student 
         ON offering.id = offering_student.offering_id

         LEFT JOIN student 
         ON offering_student.student_id = student.id

         LEFT JOIN day_offering 
         ON offering.id = day_offering.offering_id

         LEFT JOIN day 
         ON day.id = day_offering.day_id

   WHERE day.day_num = ?
     AND student.id = ?
     AND offering.term_id = ?
ORDER BY offering.start_time
SQL;
        return \R::find('offering', $sql, [2, $this->bean->id, 1]);
    }

    public function getAllGrades(): array
    {
        $grades = $this->ownOfferingStudentList;
        return $grades;
    }

    public function recordPresent(Session $session): void
    {

    }

}
