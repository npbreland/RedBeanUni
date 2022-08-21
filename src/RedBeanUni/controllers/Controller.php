<?php

namespace RedBeanUni\Controller;

use RedBeanPHP\R as R;

use RedBeanUni\Exception\Exception404;

class Controller
{
    protected $type;

    public function loadBean(int $id)
    {
        $bean = R::load( $this->type, $id );
        if ($bean->id === 0) {
            throw new Exception404(ucfirst($this->type) . " $id not found.");
        }
        return $bean;
    }
}
