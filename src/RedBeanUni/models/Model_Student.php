<?php
namespace NPBreland\PHPUni\RedBeanUni;

class Model_Student extends Model_Person
{
    use ClassTrait;

    public function update(): void
    {
    }

    public function enrollInClass(Model_Class $c2): void
    {
        if (!$this->hasPassedPrerequisites($c2->course->box())) {
            $err_msg = <<<MSG
Student has not passed all of the prerequisite courses.
MSG;
            throw new \Exception($err_msg);
        }

        $classList = array_values($this->sharedClassList);
        for($i = 0; $i < count($classList); $i++) {
            $c1 = $classList[$i]->box();
            if ($this->classesOverlap($c1, $c2)) {
                $err_msg = <<<MSG
Cannot enroll in class because it would overlap with another class the student
is taking.
MSG;
                throw new \Exception($err_msg);
            }
        }
        $this->sharedClassList[] = $c2->unbox();
    }

    private function hasPassedPrerequisites(Model_Course $course): bool
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

    public function withdrawFromClass(Model_Class $class): void
    {
        if (!$this->isInClass($class)) {
            throw new \Exception('Student must be enrolled in the class.');
        }

        unset($this->bean->sharedClassList[$class->id]);
    }

    private function isInClass(Model_Class $class): bool
    {
        foreach ($this->sharedClassList as $student_class) {
            if ($student_class->equals($class->unbox())) {
                return true;
            }
        }

        return false;
    }

    public function addGrade(Model_Grade $grade)
    {
        if (!$this->isInClass($grade->class->box())) {
            throw new \Exception('Student must be enrolled in the class.');
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
