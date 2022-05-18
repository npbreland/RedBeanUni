<?php
namespace NPBreland\PHPUni\RedBeanUni;

function getCurrentTerm(): ?Model_Term
{
    $now = new \DateTime();
    return \R::findOne(
        'term',
        'start_date <= ? AND end_date >= ?',
        [$now, $now]
    );
}

function getNextTerm(): ?Model_Term
{
    $current_term = getCurrentTerm();
    return \R::findOne(
        'term',
        'start_date > ? ORDER BY start_date',
        [$current_term->start_date]
    );
}
