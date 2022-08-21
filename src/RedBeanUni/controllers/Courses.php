<?php

namespace RedBeanUni\Controller;

use RedBeanPHP\R as R;

class Courses extends Controller
{
    public function __construct()
    {
        $this->type = 'course';
    }

    public function buildBean(\RedBeanPHP\OODBBean $course, array $data)
    {
        $name = $data['name'];
        $course->name = $name;

        if ($data['prereqs']) {
            foreach ($data['prereqs'] as $prereq) {
                $prereq_bean = R::load( 'course', $prereq['id'] );
                $course->ownCourseList[] = $prereq_bean;
            }
        }

        return $course;
    }

    public function readAll()
    {
        $courses = R::findAll( 'course' );
        echo json_encode($courses);
    }

    public function read($id)
    {
        $course = $this->loadBean($id);
        echo json_encode($course);
    }

    public function create()
    {
        $course = R::dispense( 'course' );
        $course = $this->buildBean($course, $_POST);
        R::store( $course );
    }

    public function put($id)
    {
        parse_str(file_get_contents("php://input"), $_PUT);

        $course = R::load( 'course' , $id);

        $course = $this->buildBean($course, $_PUT);

        R::store( $course );
    }

    public function patch($id)
    {
        parse_str(file_get_contents("php://input"), $_PATCH);

        $key = $_PATCH['patch_key'];
        $val = $_PATCH['patch_val'];

        $course = R::load( 'course', $id );
        $course->{$key} = $val;

        R::store( $course );
    }

    public function delete($id)
    {
        $course = R::load( 'course', $id );
        R::trash( $course );
    }

}
