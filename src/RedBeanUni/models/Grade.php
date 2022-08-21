<?php
namespace RedBeanUni\Model;

use RedBeanUni\Exception\InvalidParameterException;

class Grade extends \RedBeanPHP\SimpleModel
{

    public function update(): void
    {
        $this->validate();
    }

    // Validates direct properties (ones on same table)
    private function validate(): void
    {
        $err_msg = 'Grade must be a number between 0 and 100.';
        if (is_string($this->score_100)) {
            if(!preg_match('/\d{1,3}/', $this->score_100)) {
                throw new InvalidParameterException($err_msg);
            }
            $this->score_100 = intval($this->score_100);
        } 

        if (!is_int($this->score_100)) {
            throw new InvalidParameterException($err_msg);
        }
        if ($this->score_100 < 0 || $this->score_100 > 100) {
            throw new InvalidParameterException($err_msg);
        }
    }
}
