<?php
namespace RedBeanUni\Model;

use RedBeanUni\Exception\InvalidParameterException;

class Course extends \RedBeanPHP\SimpleModel
{
    public function update(): void
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (!is_string($this->name)) {
            throw new InvalidParameterException('Course name must be a string');
        }

        if (strlen($this->name) < 3 || strlen($this->name) > 30) {
            $ex_msg = 'Course name must be between 3 and 30 characters';
            throw new InvalidParameterException($ex_msg);
        }
    }


}
