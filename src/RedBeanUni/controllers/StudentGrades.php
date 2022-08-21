<?php

namespace RedBeanUni\Controller;

use RedBeanPHP\R as R;

class StudentGrades
{
    public function buildBean(
        \RedBeanPHP\OODBBean $grade,
        \RedBeanPHP\OODBBean $student, 
        \RedBeanPHP\OODBBean $offering,
        array $data
    )
    {
        $grade->student = $student;
        $grade->offering = $offering;
        $grade->score = $data['score_100'];

        return $offering;
    }

    public function find($student_id, $offering_id)
    {
        return R::findOne(
            'grade',
            ' student_id = ? AND offering_id = ? ',
            [ $student_id, $offering_id ]
        );
    }

    public function readAll($student_id)
    {
        $student = R::load( 'student', $student_id );
        echo json_encode($student->ownGradeList);
    }

    public function readByTerm($student_id, $term_id)
    {
        $grades = R::findAll( 
            'grade', 
            ' student_id = ? AND @joined.term.id = ? ',
            [ $student_id, $term_id ] 
        );
        return $grades;
    }

    public function create($student_id, $offering_id)
    {
        $grade = R::dispense( 'grade' );
        $student = R::load( 'student', $student_id );
        $offering = R::load( 'offering', $offering_id );

        $grade = $this->buildBean($grade, $student, $offering, $_POST);
        R::store( $grade );
    }

    public function patch($student_id, $offering_id)
    {
        parse_str(file_get_contents("php://input"), $_PATCH);

        $grade = $this->find($student_id, $offering_id);
        $key = $_PATCH['patch_key'];
        $val = $_PATCH['patch_val'];

        $grade->{$key} = $val;

        R::store( $grade );
    }

    public function delete($student_id, $offering_id)
    {
        $grade = $this->find($student_id, $offering_id);
        R::trash( $grade );
    }

}
