<?php
namespace RedBeanUni\Model;

use \RedBeanPHP\R as R;

class Term extends \RedBeanPHP\SimpleModel
{

    public function update(): void
    {
        if (!isset($this->start_date) || !isset($this->end_date)) {
            throw new \Exception('Start and end dates must be set.');
        }
        if ($this->overlapsAnotherTerm()) {
            $err_msg = <<<MSG
Cannot update term, as it would overlap an existing term.
MSG;
            throw new \Exception($err_msg);
        }
    }

    private function overlapsAnotherTerm(): bool
    {
        $sql = <<<SQL
(start_date > ? AND start_date < ?)
OR (end_date > ? AND end_date < ?)
SQL;
        return !is_null(
            R::findOne('term', $sql, [
                $this->start_date, $this->end_date,
                $this->start_date, $this->end_date
            ])
        );
    }
}
