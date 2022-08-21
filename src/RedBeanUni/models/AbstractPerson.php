<?php

namespace RedBeanUni\Model;

abstract class AbstractPerson extends \RedBeanPHP\SimpleModel
{
    public function getListName(): string
    {
        return "$this->last_name, $this->first_name";
    }

    public function getDateOfBirthString(): string
    {
        $dob = new \DateTime($this->date_of_birth);
        return $dob->format('m/d/Y');
    }

    public function isBirthday(): bool
    {
        $today = new \DateTime();
        $dob = new \DateTime($this->date_of_birth);

        return $dob->format('d/m') === $today->format('d/m');
    }

    abstract public function getCurrentTermOfferings(): array;
    abstract public function getTodaysOfferings(): array;

}
