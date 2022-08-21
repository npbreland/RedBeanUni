<?php

namespace RedBeanUni\Controller;

use RedBeanPHP\R as R;

class Students extends Controller
{

    public function __construct()
    {
        $this->type = 'student';
    }

    public function buildBean(\RedBeanPHP\OODBBean $student, array $data)
    {
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $date_of_birth = $data['date_of_birth'];

        $student->first_name = $first_name;
        $student->last_name = $last_name;
        $student->date_of_birth = $date_of_birth;

        return $student;
    }

    public function readAll()
    {
        $students = R::findAll( 'student' );
        echo json_encode($students);
    }

    public function read($id)
    {
        $student = $this->loadBean($id);
        
        echo json_encode([
            "id" => $student->id,
            "first_name" => $student->first_name,
            "last_name" => $student->last_name,
            "date_of_birth" => $student->date_of_birth,
            "GPA" => $student->getGPA(),
            // TODO: Add attendance record
        ]);
    }

    public function create()
    {
        $student = R::dispense( 'student' );
        $student = $this->buildBean($student, $_POST);
        R::store( $student );
    }

    public function put($id)
    {
        $student = R::load( 'student' , $id);
        $student = $this->buildBean($student, $_POST);
        R::store( $student );
    }

    public function patch($id)
    {
        parse_str(file_get_contents("php://input"), $_PATCH);

        $key = $_PATCH['patch_key'];
        $val = $_PATCH['patch_val'];

        $student = R::load( 'student', $id );
        $student->{$key} = $val;

        R::store( $student );
    }

    public function delete($id)
    {
        $student = R::load( 'student', $id );
        R::trash( $student );
    }

    public function getCourseRegistrations($student_id)
    {
        $student = R::load( 'student', $student_id );
        echo json_encode($student->ownRegistrationList);
    }

    public function enroll($student_id, $offering_id)
    {
        $student = R::load( 'student', $student_id );
        $offering = R::load( 'offering', $offering_id );
        $reg = R::dispense( 'registration' );

        $reg->student = $student;
        $reg->offering = $offering;

        R::store( $reg );
    }

    public function withdraw($student_id, $offering_id)
    {
        $reg = R::find(
            'registration',
            ' student_id = ? AND offering_id = ? ',
            [ $student_id, $offering_id ] 
        );
        R::trash($reg);
    }
}
