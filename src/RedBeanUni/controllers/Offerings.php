<?php

namespace RedBeanUni\Controller;

use RedBeanPHP\R as R;

class Offerings
{
    public function buildBean(\RedBeanPHP\OODBBean $offering, array $data)
    {
        $course_id = $data['course_id'];
        $term_id = $data['term_id'];

        $course = R::load( 'course', $course_id );
        $term = R::load( 'term' , $term_id );

        $offering->course = $course;
        $offering->term = $term;

        if ($data['instructor_id']) {
            $instructor_id = $data['instructor_id'];
            $instructor = R::load( 'instructor' , $instructor_id );
            $offering->instructor = $instructor;
        }

        if ($data['start_time']) {
            $offering->start_time = $data['start_time'];
            $offering->end_time = $data['end_time'];
        }

        return $offering;
    }

    public function readAll()
    {
        $offerings = R::findAll( 'offering' );
        echo json_encode($offerings);
    }

    public function read($id)
    {
        $offering = R::load( 'offering', $id );
        echo json_encode($offering);
    }

    public function create()
    {
        $offering = R::dispense( 'offering' );
        $offering = $this->buildBean($offering, $_POST);
        R::store( $offering );
    }

    public function put($id)
    {
        parse_str(file_get_contents("php://input"), $_PUT);

        $offering = R::load( 'offering' , $id);

        $offering = $this->buildBean($offering, $_PUT);

        R::store( $offering );
    }

    public function patch($id)
    {
        parse_str(file_get_contents("php://input"), $_PATCH);

        $key = $_PATCH['patch_key'];
        $val = $_PATCH['patch_val'];

        $offering = R::load( 'offering', $id );
        $offering->{$key} = $val;

        R::store( $offering );
    }

    public function delete($id)
    {
        $offering = R::load( 'offering', $id );
        R::trash( $offering );
    }

}
