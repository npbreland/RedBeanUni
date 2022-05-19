<?php
namespace RedBeanUni\Model;

class Person extends \RedBeanPHP\SimpleModel
{
    public function getListName(): string
    {
        return "$this->last_name, $this->first_name";
    }

    public function isBirthday(): bool
    {
        $today = new \DateTime();
        $dob = new \DateTime($this->date_of_birth);

        return $dob->format('d/m') === $today->format('d/m');
    }

}
