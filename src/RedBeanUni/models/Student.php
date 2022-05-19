<?php
namespace RedBeanUni\Model;

class Student extends Person
{
    use OfferingTrait;

    public function update(): void
    {
    }

    public function enrollInOffering(Offering $o2): void
    {
        if (!$this->hasPassedPrerequisites($o2->course->box())) {
            $err_msg = <<<MSG
Student has not passed all of the prerequisite courses.
MSG;
            throw new \Exception($err_msg);
        }

        $offering_list = array_values($this->sharedOfferingList);
        for($i = 0; $i < count($offering_list); $i++) {
            $o1 = $offering_list[$i]->box();
            if ($this->offeringsOverlap($o1, $o2)) {
                $err_msg = <<<MSG
Cannot enroll in offering because it would overlap with another offering the 
student is taking.
MSG;
                throw new \Exception($err_msg);
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
        if (!$this->isInOffering($offering)) {
            throw new \Exception('Student must be enrolled in the offering.');
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

    public function addGrade(Grade $grade)
    {
        if (!$this->isInOffering($grade->offering->box())) {
            throw new \Exception('Student must be enrolled in the offering.');
        }
        if (!is_int($grade->score)) {
            throw new \Exception('Grade must be an integer.');
        }
        if ($grade->score <= 0 || $grade->score >= 100) {
            throw new \Exception('Grade must be between 0 and 100');
        }

        $this->bean->ownGradeList[] = $grade->unbox();
    }

    public function getGradePointAverage(): float
    {
        if (!$this->ownGradeList) {
            throw new \Exception('No grades for this student.');
        }

        $sum = array_reduce($this->ownGradeList, function($acc, $grade) {
            $acc += $grade->score;
            return $acc;
        }, 0);

        return round((($sum / count($this->ownGradeList)) / 100) * 4, 2);
    }

}
