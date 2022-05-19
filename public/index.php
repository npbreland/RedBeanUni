<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

require_once $_ENV['COMPOSER_PATH'] . '/autoload.php';
require_once $_ENV['SRC_PATH'] . '/autoload.php';
require_once $_ENV['CONFIG_PATH'] . '/config.php';

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

$router = new RouteCollector();

$router->any('/', function() {
    include 'index.html';
});

$router->get('/student/{id}', function($id) {
    $student = R::load('student', $id);
    include 'views/student-profile.php';
});

$router->get('/instructor/{id}', function($id) {
    $instructor = R::load('instructor', $id);
    include 'views/instructor-profile.php';
});

$router->post('/offering/{offering_id}/instructor/{instructor_id}', function ($offering_id, $instructor_id) {
    $offering = R::load('offering', $offering_id);
    $instructor = R::load('instructor', $instructor_id);

    $instructor->assignOffering($offering->box());
    R::store($instructor);
});

$router->post('/offering/{offering_id}/student/{student_id}', function ($offering_id, $student_id) {
    $offering = R::load('offering', $offering_id);
    $student = R::load('student', $student_id);

    $student->enrollInOffering($offering->box());
    R::store($student);
});

$router->delete('/offering/{offering_id}/student/{student_id}', function ($offering_id, $student_id) {
    $offering = R::load('offering', $offering_id);
    $student = R::load('student', $student_id);

    $student->withdrawFromOffering($offering->box());
    R::store($student);
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$dispatcher = new Dispatcher($router->getData());
$dispatcher->dispatch($method, $uri);


