<?php

namespace RedBeanUni\Controller;

use RedBeanPHP\R as R;

class Departments extends Controller
{
    public function __construct()
    {
        $this->type = 'department';
    }

    public function readAll()
    {
        $departments = R::findAll( 'department' );
        echo json_encode($departments);
    }

    public function read($id)
    {
        $department = $this->loadBean($id);
        echo json_encode($department);
    }

    public function create()
    {
        $department = R::dispense( 'department' );
        $department->name = $_POST['name'];
        R::store( $department );
    }

    public function put($id)
    {
        $department = $this->loadBean($id);
        $department->name = $_POST['name'];
        R::store( $department );
    }

    public function patch($id)
    {
        parse_str(file_get_contents("php://input"), $_PATCH);

        $key = $_PATCH['patch_key'];
        $val = $_PATCH['patch_val'];

        $department = $this->loadBean($id);
        $department->{$key} = $val;

        R::store( $department );
    }

    public function delete($id)
    {
        $department = $this->loadBean($id);
        R::trash( $department );
    }
}
