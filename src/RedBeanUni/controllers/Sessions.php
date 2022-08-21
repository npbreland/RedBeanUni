<?php

namespace RedBeanUni\Controller;

use RedBeanPHP\R as R;

class Sessions extends Controller
{
    public function __construct()
    {
        $this->type = 'session';
    }

    public function read($id)
    {
        $session = $this->loadBean($id);

        echo json_encode([
            "id" => $session->id,
            "course_name" => $session->offering->course->name,
            "start_time" => $session->offering->start_time,
            "end_time" => $session->offering->end_time,
            "date" => $session->date
        ]);
    }

    public function create()
    {
        $session = R::dispense( 'session' );

        $offering_id = $_POST['offering_id'];
        $offering = R::load('offering', $offering_id);
        $session->offering = $offering;

        $session->date = $_POST['date'];

        R::store( $session );
    }

    public function delete($id)
    {
        $session = $this->loadBean($id);
        R::trash( $session );
    }
}
