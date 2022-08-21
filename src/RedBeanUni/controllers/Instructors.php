<?php

namespace RedBeanUni\Controller;

use RedBeanPHP\R as R;

class Instructors extends Controller
{
    public function __construct()
    {
        $this->type = 'instructor';
    }

    public function buildBean(\RedBeanPHP\OODBBean $instructor, array $data)
    {
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $date_of_birth = $data['date_of_birth'];

        $instructor->first_name = $first_name;
        $instructor->last_name = $last_name;
        $instructor->date_of_birth = $date_of_birth;

        return $instructor;
    }

    public function readAll()
    {
        $instructors = R::findAll( 'instructor' );
        echo json_encode($instructors);
    }

    public function read($id)
    {
        $instructor = $this->loadBean($id);
        echo json_encode($instructor);
    }

    public function create()
    {
        $instructor = R::dispense( 'instructor' );
        $instructor = $this->buildBean($instructor, $_POST);
        R::store( $instructor );
    }

    public function put($id)
    {
        $instructor = $this->loadBean($id);
        $instructor = $this->buildBean($instructor, $_POST);
        R::store( $instructor );
    }

    public function patch($id)
    {
        parse_str(file_get_contents("php://input"), $_PATCH);

        $key = $_PATCH['patch_key'];
        $val = $_PATCH['patch_val'];

        $instructor = $this->loadBean($id);
        $instructor->{$key} = $val;

        R::store( $instructor );
    }

    public function delete($id)
    {
        $instructor = $this->loadBean($id);
        R::trash( $instructor );
    }

    public function readOfferings($id)
    {
        $instructor = $this->loadBean($id);
        $offerings = $instructor->getOfferings();
        echo json_encode($offerings);
    }

}
