<?php

namespace RedBeanUni\Controller;

use RedBeanPHP\R as R;

class Terms
{
    public function buildBean(\RedBeanPHP\OODBBean $term, array $data)
    {
        $start_date = $term['start_date'];
        $end_date = $term['end_date'];

        $term->start_date = $start_date;
        $term->end_date = $end_date;
        return $term;
    }

    public function readAll()
    {
        $terms = R::findAll( 'term' );
        echo json_encode($terms);
    }

    public function read($id)
    {
        $term = R::load( 'term', $id );
        echo json_encode($term);
    }

    public function create()
    {
        $term = R::dispense( 'term' );
        $term = $this->buildBean($term, $_POST);
        R::store( $term );
    }

    public function put($id)
    {
        parse_str(file_get_contents("php://input"), $_PUT);

        $term = R::load( 'term' , $id);

        $term = $this->buildBean($term, $_PUT);

        R::store( $term );
    }

    public function patch($id)
    {
        parse_str(file_get_contents("php://input"), $_PATCH);

        $key = $_PATCH['patch_key'];
        $val = $_PATCH['patch_val'];

        $term = R::load( 'term', $id );
        $term->{$key} = $val;

        R::store( $term );
    }

    public function delete($id)
    {
        $term = R::load( 'term', $id );
        R::trash( $term );
    }

}
