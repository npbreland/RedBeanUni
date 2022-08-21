<?php

namespace RedBeanUni\Controller;

use RedBeanPHP\R as R;

class Attendances extends Controller
{
    public function __construct()
    {
        $this->type = 'attendance';
    }

    public function read($id)
    {
        $attendance = $this->loadBean($id);
        echo json_encode($attendance);
    }

    public function create()
    {
        $attendance = R::dispense( 'attendance' );

        $session_id = $_POST['session_id'];
        $student_id = $_POST['student_id'];

        $session = R::load( 'session', $session_id );
        $student = R::load( 'student', $student_id );

        $attendance->session = $session;
        $attendance->student = $student;

        R::store( $attendance );
    }

    public function delete($id)
    {
        $attendance = $this->loadBean($id);
        R::trash( $attendance );
    }
}
