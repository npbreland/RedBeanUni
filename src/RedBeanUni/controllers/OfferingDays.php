<?php

namespace RedBeanUni\Controller;

use RedBeanPHP\R as R;

class OfferingDays
{
    public function buildBean(\RedBeanPHP\OODBBean $offering, array $data)
    {
        foreach ($data['days'] as $day_num) {
            $day = R::findOne('day', ' day_num = ? ', [ $day_num ]);
            $offering->sharedDayList[] = $day;
        }

        return $offering;
    }

    public function readAll($offering_id)
    {
        $offering = R::load( 'offering', $offering_id );
        echo json_encode($offering->sharedDayList);
    }

    public function create($offering_id)
    {
        $offering = R::load( 'offering', $offering_id );
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

    public function delete($id)
    {
        $offering = R::load( 'offering', $id );
        R::trash( $offering );
    }

}
