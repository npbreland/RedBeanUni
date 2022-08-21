<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

require_once '../bootstrap.php';

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

use RedBeanUni\Exception\Exception404;


/* /1* Common functions *1/ */
/* function getBean(string $type, int $id) { */
/*     $bean = R::load($type, $id); */
/*     if ($bean->id === 0) { */
/*         throw new Exception404(ucfirst($type) . " $id not found."); */
/*     } */
/*     return $bean; */
/* } */


$router = new RouteCollector();

$router->any('/', function() {
    include 'index.html';
});

$c_ns = '\RedBeanUni\Controller\\';

// Student routes
$router->get('/students', [$c_ns . 'Students', 'readAll']);
$router->get('/students/{id:i}', [$c_ns . 'Students', 'read']);
$router->post('/students', [$c_ns . 'Students', 'create']);
$router->put('/students/{id:i}', [$c_ns . 'Students', 'put']);
$router->patch('/students/{id:i}', [$c_ns . 'Students', 'patch']);
$router->delete('/students/{id:i}', [$c_ns . 'Students', 'delete']);

// Grade routes
$router->get('/grades/{id:i}', [$c_ns . 'Grades', 'read']);
$router->post('/grades', [$c_ns . 'Grades', 'create']);
$router->patch('/grades/{id:i}', [$c_ns . 'Grades', 'patch']);
$router->delete('/grades/', [$c_ns . 'StudentGrades', 'delete']);

// Offering registration routes 
$router->get('/registrations/{id}', [$c_ns . 'Registrations', 'read']);
$router->post('/registrations/{id}', [$c_ns . 'Registrations', 'create']);
$router->delete('/registrations/{id}', [$c_ns . 'Registrations', 'delete']);


// Instructor routes
$router->get('/instructors', [$c_ns . 'Instructors', 'readAll']);
$router->get('/instructors/{id:i}', [$c_ns . 'Instructors', 'read']);
$router->post('/instructors', [$c_ns . 'Instructors', 'create']);
$router->put('/instructors/{id:i}', [$c_ns . 'Instructors', 'put']);
$router->patch('/instructors/{id:i}', [$c_ns . 'Instructors', 'patch']);
$router->delete('/instructors/{id:i}', [$c_ns . 'Instructors', 'delete']);

// Instructor offerings routes
$router->get(
    '/instructors/{id:i}/offerings',
    [$c_ns . 'Instructors', 'readOfferings']
);

// Course routes
$router->get('/courses', [$c_ns . 'Courses', 'readAll']);
$router->get('/course/{id:i}', [$c_ns . 'Courses', 'read']);
$router->post('/course', [$c_ns . 'Courses', 'create']);
$router->put('/course/{id:i}', [$c_ns . 'Courses', 'put']);
$router->patch('/course/{id:i}', [$c_ns . 'Courses', 'patch']);
$router->delete('/course/{id:i}', [$c_ns . 'Courses', 'delete']);

// Term routes
$router->get('/terms', [$c_ns . 'Terms', 'readAll']);
$router->get('/term/{id:i}', [$c_ns . 'Terms', 'read']);
$router->post('/term', [$c_ns . 'Terms', 'create']);
$router->put('/term/{id:i}', [$c_ns . 'Terms', 'put']);
$router->patch('/term/{id:i}', [$c_ns . 'Terms', 'patch']);
$router->delete('/term/{id:i}', [$c_ns . 'Terms', 'delete']);

// Offering routes
$router->get('/offerings', [$c_ns . 'Offerings', 'readAll']);
$router->get('/offering/{id:i}', [$c_ns . 'Offerings', 'read']);
$router->post('/offering', [$c_ns . 'Offerings', 'create']);
$router->put('/offering/{id:i}', [$c_ns . 'Offerings', 'put']);
$router->patch('/offering/{id:i}', [$c_ns . 'Offerings', 'patch']);
$router->delete('/offering/{id:i}', [$c_ns . 'Offerings', 'delete']);

// Session routes
$router->get('/sessions/{id:i}', [$c_ns . 'Sessions', 'read']);
$router->post('/sessions', [$c_ns . 'Sessions', 'create']);
$router->patch('/sessions/{id:i}', [$c_ns . 'Sessions', 'patch']);
$router->put('/sessions/{id:i}', [$c_ns . 'Sessions', 'put']);

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$dispatcher = new Dispatcher($router->getData());

try {
    $dispatcher->dispatch($method, parse_url($uri, PHP_URL_PATH));
} catch (Exception400 $e) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 400 ' . $e->getMessage());
} catch (Exception404 $e) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 ' . $e->getMessage());
} catch (\Exception $e) {
    // Fallback to 500 error if we can't explain
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
}

