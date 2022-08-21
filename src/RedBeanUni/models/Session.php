<?php
namespace RedBeanUni\Model;

class Session extends \RedBeanPHP\SimpleModel
{

    public function cancel(string $msg = ''): void
    {
        // Set to canceled
        $this->canceled = true;

        // TODO: Send message to students
    }

    public function recordPresent(Student $student): void
    {

    }


}
