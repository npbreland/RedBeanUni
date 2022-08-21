<?php
namespace RedBeanUni;

function getCurrentTerm(): ?Model\Term
{
    $now = new \DateTime();
    $now_ymd = $now->format('Y-m-d');
    return \R::findOne(
        'term',
        'start_date <= ? AND end_date >= ?',
        [$now_ymd, $now_ymd]
    )->box();
}

function getNextTerm(): ?Model\Term
{
    $current_term = getCurrentTerm();
    return \R::findOne(
        'term',
        'start_date > ? ORDER BY start_date',
        [$current_term->start_date]
    )->box();
}

function getCurrentDayNum(): string
{
    $now = new \DateTime();
    return $now->format('N');
}

function getDayOfWeekInt(\DateTime $date): int
{
    return intval($date->format('w') + 1);
}

function fillInAbsentees()
{
    $sql = <<<SQL
      LEFT JOIN offering
      ON session.offering_id = offering.id

WHERE session.date = CURDATE()
  AND offering.end_time < NOW()
SQL;

    $sessions = \R::find('session', $sql, []);

    dmp($sessions);

    foreach ($sessions as $session) {
        dmp($session->offering->ownOfferingStudentList);
        break;
    }
    
}
