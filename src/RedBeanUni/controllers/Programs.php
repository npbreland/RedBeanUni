<?php

namespace RedBeanUni\Controller;

use RedBeanPHP\R as R;

class Programs extends Controller
{
    public function __construct()
    {
        $this->type = 'program';
    }

    public function read($id)
    {
        $program = $this->loadBean($id);
        echo json_encode($program);
    }

    public function create()
    {
        $program = R::dispense( $this->type );
        $program->name = $_POST['name'];

        $department_id = $_POST['department_id'];
        $department = R::load( 'department', $department_id );
        $program->department = $department;

        R::store( $program );
    }

    public function delete($id)
    {
        $program = $this->loadBean($id);
        R::trash( $program );
    }
}
