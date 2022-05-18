<?php
namespace NPBreland\PHPUni\RedBeanUni;

class Model_Instructor extends Model_Person
{
    use ClassTrait;

    public function update(): void
    {
    }

    public function assignClass(Model_Class $c2): void
    {
        $classList = array_values($this->ownClassList);
        for($i = 0; $i < count($classList); $i++) {
            $c1 = $classList[$i]->box();
            if ($this->classesOverlap($c1, $c2)) {
                $err_msg = <<<MSG
Cannot enroll in class because it would overlap with another class 
the instructor is teaching.
MSG;
                throw new \Exception($err_msg);
            }
        }
        $this->ownClassList[] = $c2->unbox();
    }
}
