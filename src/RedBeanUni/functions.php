<?php
namespace RedBeanUni;

function getCurrentTerm(): ?Model\Term
{
    $now = new \DateTime();
    return \R::findOne(
        'term',
        'start_date <= ? AND end_date >= ?',
        [$now, $now]
    );
}

function getNextTerm(): ?Model\Term
{
    $current_term = getCurrentTerm();
    return \R::findOne(
        'term',
        'start_date > ? ORDER BY start_date',
        [$current_term->start_date]
    );
}
