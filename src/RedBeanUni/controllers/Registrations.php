<?php

namespace RedBeanUni\Controller;

use RedBeanPHP\R as R;

class Registrations extends Controller
{
    public function __construct()
    {
        $this->type = 'registration';
    }

    public function read($id)
    {
        $reg = $this->loadBean($id);

        echo json_encode([
            "id" => $reg->id,
            "course_name" => $reg->offering->course->name,
            "student" => $reg->student
        ]);
    }

    public function create()
    {
        $reg = R::dispense( 'registration' );

        $student_id = $_POST['student_id'];
        $offering_id = $_POST['offering_id'];

        $student = R::load( 'student', $student_id );
        $offering = R::load( 'offering', $offering_id );

        $reg->student = $student;
        $reg->offering = $offering;

        R::store( $reg );
    }

    public function delete($id)
    {
        $reg = $this->loadBean($id);
        R::trash( $reg );
    }
}
